<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Producto;

Route::get('/', function () {
    return view('index');
});

// Redireccionar según el rol del usuario
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = Auth::user();
    
    return match ($user->role) {
        'gerente' => redirect()->route('gerente.dashboard'),
        'empleado' => redirect()->route('empleado.dashboard'),
        default => redirect()->route('cliente.dashboard'),
    };
})->name('dashboard');

// Rutas de dashboards
Route::middleware('auth')->group(function () {
    Route::get('/empleado', function () {
        $productos = Producto::all();
        return view('empleado', compact('productos'));
    })->name('empleado.dashboard');

    Route::get('/cliente', [ProductoController::class, 'clienteIndex'])->name('cliente.dashboard');
});

// Rutas del perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas del gerente (usando el middleware de roles)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/gerente', [UserController::class, 'dashboard'])->name('gerente.dashboard');

    // Rutas CRUD de usuarios
    Route::prefix('gerente/usuarios')->name('gerente.usuarios.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
});

// Rutas CRUD de productos
Route::middleware('auth')->group(function () {
    Route::resource('productos', ProductoController::class);
});

// Cargar las rutas de autenticación
require __DIR__.'/auth.php';
