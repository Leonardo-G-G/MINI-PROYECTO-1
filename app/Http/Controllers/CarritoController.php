<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session()->get('carrito', []);
        return view('carrito', compact('carrito'));
    }

    public function agregar($id, Request $request)
    {
        $producto = Producto::findOrFail($id);
        $cantidadSolicitada = (int) $request->input('cantidad', 1);

        if ($producto->cantidad <= 0) {
            return back()->with('error', 'Este producto no está disponible actualmente.');
        }

        if ($cantidadSolicitada < 1 || $cantidadSolicitada > $producto->cantidad) {
            return back()->with('error', 'Cantidad inválida o supera el stock disponible.');
        }

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $nuevaCantidad = $carrito[$id]['cantidad'] + $cantidadSolicitada;

            if ($nuevaCantidad > $producto->cantidad) {
                return back()->with('error', 'No hay suficiente stock disponible.');
            }

            $carrito[$id]['cantidad'] = $nuevaCantidad;
        } else {
            $carrito[$id] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'foto' => $producto->foto,
                'autor' => $producto->autor,
                'cantidad' => $cantidadSolicitada,
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

    public function finalizarCompra(Request $request)
    {
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return back()->with('error', 'El carrito está vacío.');
        }

        $request->validate([
            'ticket' => 'required|image|max:2048',
        ]);

        $ticketPath = $request->file('ticket')->store('tickets', 'private');

        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        $venta = Venta::create([
            'comprador_id' => Auth::id(),
            'ticket' => $ticketPath,
            'estado' => 'pendiente',
            'total' => $total,
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