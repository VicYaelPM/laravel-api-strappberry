<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarritosController;
use App\Http\Controllers\Api\CategoriaProductoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductosController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductosEnCarritoController;

Route::get('/products', [ProductosController::class, 'index']);
Route::get('/products/{id}', [ProductosController::class, 'show']);
Route::post('/products', [ProductosController::class, 'store']);
Route::put('/products/{id}', [ProductosController::class, 'update']);
Route::delete('/products/{id_productos}', [ProductosController::class, 'destroy']);
Route::get('/products/category/{id}', [ProductosController::class, 'buscarPorCategoria']);

Route::get('/productsInCart/{id_carrito}', [ProductosEnCarritoController::class, 'productosPorCarrito']);
Route::post('/productsInCart', [ProductosEnCarritoController::class, 'agregarProducto']);
Route::post('/productsInCart/disminuirCantidad', [ProductosEnCarritoController::class, 'disminuirCantidad']);
Route::post('/productsInCart/aumentarCantidad', [ProductosEnCarritoController::class, 'aumentarCantidad']);

Route::get('/carritos', [CarritosController::class, 'index']);
Route::get('/carritos/{id}', [CarritosController::class, 'show']);
Route::post('/carritos', [CarritosController::class, 'store']);
Route::put('/carritos/{id}', [CarritosController::class, 'update']);
Route::delete('/carritos/{id}', [CarritosController::class, 'destroy']);

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users/byEmail', [UserController::class, 'getUserByEmail']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::get('/users/{id}/carritos', [UserController::class, 'userCarritos']);

Route::get('/categoria_productos', [CategoriaProductoController::class, 'index']);
Route::post('/categoria_productos', [CategoriaProductoController::class, 'store']);
Route::get('/categoria_productos/{id}', [CategoriaProductoController::class, 'show']);
Route::put('/categoria_productos/{id}', [CategoriaProductoController::class, 'update']);
Route::delete('/categoria_productos/{id}', [CategoriaProductoController::class, 'destroy']);


Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
