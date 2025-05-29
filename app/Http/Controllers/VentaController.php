<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VentaController extends Controller
{
    /**
     * Mostrar todas las ventas (solo para gerente).
     */
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewAny', Venta::class);

        $ventas = Venta::with(['comprador', 'productos'])->get();
        return view('gerente_ventas', compact('ventas'));
    }

    /**
     * Mostrar los detalles de una venta específica.
     */
    public function show(string $id)
    {
        $venta = Venta::with(['comprador', 'productos'])->findOrFail($id);
        $this->authorize('view', $venta);

        return view('ventas_show', compact('venta')); // Vista corregida
    }

    /**
     * Validar una venta pendiente (solo gerente).
     */
    public function validar(Request $request, Venta $venta)
    {
        // Autorización: solo gerente puede validar
        $this->authorize('validar', $venta);

        if ($venta->estado !== 'pendiente') {
            return back()->with('error', 'La venta ya fue procesada.');
        }

        $venta->estado = 'completada';
        $venta->save();

        return back()->with('success', 'La venta ha sido validada exitosamente.');
    }

    /**
     * Descargar el ticket bancario asociado a la venta (privado).
     */
    public function descargarTicket(Venta $venta)
    {
        $this->authorize('view', $venta);

        if ($venta->ticket && Storage::disk('private')->exists($venta->ticket)) {
            return Storage::disk('private')->download($venta->ticket);
        }

        return back()->with('error', 'El ticket no está disponible.');
    }
    public function ventasDelVendedor()
{
    $user = auth()->user();

    // Busca ventas en las que al menos uno de los productos fue creado por el vendedor
    $ventas = Venta::with(['comprador', 'productos'])
        ->get()
        ->filter(function ($venta) use ($user) {
            return $venta->productos->contains(function ($producto) use ($user) {
                return $producto->vendedor_id === $user->id;
            });
        });

    return view('vendedor_ventas', compact('ventas'));
}


    // Métodos no implementados
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}