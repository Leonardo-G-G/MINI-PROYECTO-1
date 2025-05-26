<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreVentaRequest;


class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::all();
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        return view('ventas.create');
    }

    public function store(StoreVentaRequest $request)
{
    $ticketPath = $request->file('ticket')->store('tickets', 'private');

    Venta::create([
        'comprador_id' => auth()->id(),
        'producto_id' => $request->producto_id,
        'ticket' => $ticketPath,
        'estado' => 'pendiente',
    ]);

    return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
}

    public function show(string $id)
    {
        $venta = Venta::findOrFail($id);
        $this->authorize('view', $venta); // Solo gerente o vendedor dueño

        return view('ventas.show', compact('venta'));
    }

    public function edit(string $id) { }

    public function update(Request $request, string $id) { }

    public function destroy(string $id) { }

    public function validar(Request $request, Venta $venta)
    {
        $this->authorize('validar', $venta);
        $venta->estado = 'validada';
        $venta->save();

        return redirect()->route('ventas.index')->with('success', 'Venta validada correctamente.');
    }

    /**
     * Descargar ticket privado.
     */
    public function descargarTicket(Venta $venta)
    {
        $this->authorize('view', $venta); // Solo gerente o vendedor dueño
        return Storage::disk('private')->download($venta->ticket);
    }
}
