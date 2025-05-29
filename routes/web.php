<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\EstadisticaController;
use App\Models\Producto;

// Página principal
Route::get('/', function () {
    return view('index');
});

// Redireccionar según el rol del usuario
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = Auth::user();

    return match ($user->role) {
        'administrador' => redirect()->route('admin.dashboard'),
        'gerente'       => redirect()->route('gerente.dashboard'),
        'cliente'       => $user->tipo_cliente === 'vendedor'
                            ? redirect()->route('cliente.vendedor.dashboard')
                            : redirect()->route('cliente.comprador.dashboard'),
        default => redirect()->route('login')->with('error', 'Rol no autorizado.'),
    };
})->name('dashboard');

// Dashboard administrador
Route::middleware(['auth', 'verified'])->get('/admin', [UserController::class, 'adminDashboard'])->name('admin.dashboard');

// Dashboard gerente
Route::middleware(['auth', 'verified'])->get('/gerente/dashboard', [UserController::class, 'gerenteDashboard'])->name('gerente.dashboard');

// Dashboard cliente comprador (usa ProductoController@index para buscador y filtro)
Route::middleware(['auth', 'verified'])->get('/cliente/comprador', [ProductoController::class, 'index'])->name('cliente.comprador.dashboard');

// Dashboard cliente vendedor
Route::middleware(['auth', 'verified'])->get('/cliente/vendedor', function () {
    $productos = Auth::user()->productos;
    return view('cliente_vendedor', compact('productos'));
})->name('cliente.vendedor.dashboard');

// Rutas de estadísticas (solo administrador)
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/estadisticas', [EstadisticaController::class, 'index'])->name('estadisticas');
});

// Rutas del carrito
Route::prefix('carrito')->middleware(['auth', 'verified'])->name('carrito.')->group(function () {
    Route::get('/', [CarritoController::class, 'index'])->name('index');
    Route::post('/agregar/{id}', [CarritoController::class, 'agregar'])->name('agregar');
    Route::delete('/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('eliminar');
    Route::post('/vaciar', [CarritoController::class, 'vaciar'])->name('vaciar');
    Route::post('/finalizar', [CarritoController::class, 'finalizarCompra'])->name('finalizar');
    Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');

});
Route::get('/debug/limpiar-carrito', function () {
    session()->forget('carrito');
    return 'Carrito limpio correctamente';
});

// Rutas de gestión de categorías (gerente)
Route::middleware(['auth', 'verified'])->prefix('gerente/categorias')->name('gerente.categorias.')->group(function () {
    Route::get('/', [CategoriaController::class, 'index'])->name('index');
    Route::get('/{categoria}/edit', [CategoriaController::class, 'edit'])->name('edit');
    Route::put('/{categoria}', [CategoriaController::class, 'update'])->name('update');
});

// Rutas de gestión de productos (gerente)
Route::middleware(['auth', 'verified'])->prefix('gerente/productos')->name('gerente.productos.')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('index');
    Route::get('/{producto}/edit', [ProductoController::class, 'edit'])->name('edit');
    Route::put('/{producto}', [ProductoController::class, 'update'])->name('update');
});

// Rutas de gestión de usuarios (administrador)
Route::middleware(['auth', 'verified'])->prefix('admin/usuarios')->name('admin.usuarios.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
});

// Rutas de gestión de categorías (administrador)
Route::middleware(['auth', 'verified'])->prefix('admin/categorias')->name('admin.categorias.')->group(function () {
    Route::get('/', [CategoriaController::class, 'index'])->name('index');
    Route::get('/create', [CategoriaController::class, 'create'])->name('create');
    Route::post('/', [CategoriaController::class, 'store'])->name('store');
    Route::get('/{categoria}/edit', [CategoriaController::class, 'edit'])->name('edit');
    Route::put('/{categoria}', [CategoriaController::class, 'update'])->name('update');
    Route::delete('/{categoria}', [CategoriaController::class, 'destroy'])->name('destroy');
});

// Rutas de gestión de productos (administrador)
Route::middleware(['auth', 'verified'])->prefix('admin/productos')->name('admin.productos.')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('index');
    Route::get('/create', [ProductoController::class, 'create'])->name('create');
    Route::post('/', [ProductoController::class, 'store'])->name('store');
    Route::get('/{producto}/edit', [ProductoController::class, 'edit'])->name('edit');
    Route::put('/{producto}', [ProductoController::class, 'update'])->name('update');
    Route::delete('/{producto}', [ProductoController::class, 'destroy'])->name('destroy');
});

// Rutas CRUD de productos generales (opcional)
Route::middleware('auth')->group(function () {
    Route::resource('productos', ProductoController::class);
});

Route::middleware(['auth', 'verified'])->prefix('gerente/usuarios')->name('gerente.usuarios.')->group(function () {
    Route::get('/{user}/edit', [UserController::class, 'editCliente'])->name('edit');
    Route::put('/{user}', [UserController::class, 'updateCliente'])->name('update');
});

// Rutas de ventas
Route::middleware(['auth', 'verified'])->prefix('ventas')->name('ventas.')->group(function () {
    Route::get('/{venta}', [VentaController::class, 'show'])->name('show');
    Route::post('/{venta}/validar', [VentaController::class, 'validar'])->name('validar');
    Route::get('/{venta}/ticket', [VentaController::class, 'descargarTicket'])->name('descargar');
});

// Rutas de productos para cliente vendedor
Route::middleware(['auth', 'verified'])->prefix('vendedor/productos')->name('vendedor.productos.')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('index');
    Route::get('/create', [ProductoController::class, 'create'])->name('create');
    Route::post('/', [ProductoController::class, 'store'])->name('store');
    Route::get('/{producto}/edit', [ProductoController::class, 'edit'])->name('edit');
    Route::put('/{producto}', [ProductoController::class, 'update'])->name('update');
    Route::delete('/{producto}', [ProductoController::class, 'destroy'])->name('destroy');
});

// ventas
Route::get('/vendedor/ventas', [VentaController::class, 'ventasDelVendedor'])
    ->name('vendedor.ventas')
    ->middleware(['auth']);


Route::middleware(['auth', 'verified'])->get('/gerente/ventas', [VentaController::class, 'index'])->name('ventas.index');

// Rutas de autenticación
require __DIR__ . '/auth.php';
