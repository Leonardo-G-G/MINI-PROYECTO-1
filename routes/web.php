<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\OrdenController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
        'gerente' => redirect()->route('gerente.dashboard'),
        'cliente' => redirect()->route('cliente.dashboard'),
        default => redirect()->route('cliente.dashboard'),
    };
})->name('dashboard');

// Rutas de dashboards por rol
Route::middleware(['auth'])->group(function () {
    Route::get('/cliente', [ProductoController::class, 'clienteIndex'])->name('cliente.dashboard');
    Route::get('/admin', [UserController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['auth', 'verified'])->get('/gerente/dashboard', [UserController::class, 'dashboard'])->name('gerente.dashboard');

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

// Rutas de gestión de usuarios para administrador
Route::middleware(['auth', 'verified'])->prefix('admin/usuarios')->name('admin.usuarios.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
});

// Rutas de gestión de categorías para administrador
Route::middleware(['auth', 'verified'])->prefix('admin/categorias')->name('admin.categorias.')->group(function () {
    Route::get('/', [CategoriaController::class, 'index'])->name('index');
    Route::get('/create', [CategoriaController::class, 'create'])->name('create');
    Route::post('/', [CategoriaController::class, 'store'])->name('store');
    Route::get('/{categoria}/edit', [CategoriaController::class, 'edit'])->name('edit');
    Route::put('/{categoria}', [CategoriaController::class, 'update'])->name('update');
    Route::delete('/{categoria}', [CategoriaController::class, 'destroy'])->name('destroy');
});

// Rutas de gestión de productos para administrador
Route::middleware(['auth', 'verified'])->prefix('admin/productos')->name('admin.productos.')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('index');
    Route::get('/create', [ProductoController::class, 'create'])->name('create');
    Route::post('/', [ProductoController::class, 'store'])->name('store');
    Route::get('/{producto}/edit', [ProductoController::class, 'edit'])->name('edit');
    Route::put('/{producto}', [ProductoController::class, 'update'])->name('update');
    Route::delete('/{producto}', [ProductoController::class, 'destroy'])->name('destroy');
});

// Rutas para cliente
Route::middleware(['auth', 'verified'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/dashboard', [ProductoController::class, 'clienteIndex'])->name('dashboard');

    // Órdenes del cliente
    Route::prefix('ordenes')->name('ordenes.')->group(function () {
        Route::get('/', [OrdenController::class, 'index'])->name('index'); // Mostrar todas las órdenes
        Route::post('/store', [OrdenController::class, 'store'])->name('store'); // Crear nueva orden
        Route::get('/{orden}', [OrdenController::class, 'show'])->name('show'); // Ver detalle de una orden
        Route::get('/cliente/ordenes/{orden}', [OrdenController::class, 'show'])->name('cliente.ordenes.show');

    });
});

// Rutas CRUD de productos
Route::middleware('auth')->group(function () {
    Route::resource('productos', ProductoController::class);
});

// Rutas de autenticación
require __DIR__.'/auth.php';
