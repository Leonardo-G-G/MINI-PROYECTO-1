<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session()->get('carrito', []);
        return view('carrito', compact('carrito'));
    }

    public function agregar($id)
    {
        $producto = Producto::findOrFail($id);

        if ($producto->cantidad <= 0) {
            return back()->with('error', 'Este producto no está disponible actualmente.');
        }

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            if ($carrito[$id]['cantidad'] < $producto->cantidad) {
                $carrito[$id]['cantidad']++;
            } else {
                return back()->with('error', 'No hay suficiente stock disponible.');
            }
        } else {
            $carrito[$id] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'foto' => $producto->foto,
                'autor' => $producto->autor,
                'cantidad' => 1,
            ];
        }

        session()->put('carrito', $carrito);
        return back()->with('success', 'Producto agregado al carrito.');
    }

    public function eliminar($id)
    {
        $carrito = session()->get('carrito', []);
        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function vaciar()
    {
        session()->forget('carrito');
        return back()->with('success', 'Carrito vaciado correctamente.');
    }

    public function finalizarCompra()
    {
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return back()->with('error', 'El carrito está vacío.');
        }

        $venta = Venta::create([
            'comprador_id' => Auth::id(),
            'estado' => 'pendiente',
            'ticket' => 'ticket_placeholder.jpg',
        ]);

        foreach ($carrito as $item) {
            $producto = Producto::find($item['id']);

            if ($producto && $producto->cantidad >= $item['cantidad']) {
                $producto->cantidad -= $item['cantidad'];
                $producto->save();

                $venta->productos()->attach($producto->id, [
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                ]);
            }
        }

        session()->forget('carrito');
        return redirect()->route('cliente.comprador.dashboard')->with('success', 'Compra finalizada exitosamente.');
    }
}