<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductosEnCarrito;

class ProductosEnCarritoController extends Controller
{
    public function productosPorCarrito($idCarrito)
    {
        $productosEnCarrito = ProductosEnCarrito::where('id_carrito', $idCarrito)->with('producto')->get();

        if ($productosEnCarrito->isEmpty()) {
            return response()->json(['message' => 'No se encontraron productos en este carrito'], 404);
        }

        return response()->json($productosEnCarrito, 200);
    }

    public function agregarProducto(Request $request)
    {
        $request->validate([
            'id_carrito' => 'required|integer',
            'id_producto' => 'required|integer',
            'cantidad_producto' => 'required|integer|min:1',
        ]);
        $productoEnCarritoExistente = ProductosEnCarrito::where('id_carrito', $request->id_carrito)
            ->where('id_producto', $request->id_producto)
            ->first();

        if ($productoEnCarritoExistente) {
            $productoEnCarritoExistente->cantidad_producto += $request->cantidad_producto;
            $productoEnCarritoExistente->save();

            return response()->json($productoEnCarritoExistente, 200);
        } else {
            $productoEnCarritoNuevo = ProductosEnCarrito::create([
                'id_carrito' => $request->id_carrito,
                'id_producto' => $request->id_producto,
                'cantidad_producto' => $request->cantidad_producto,
            ]);

            return response()->json($productoEnCarritoNuevo, 201);
        }
    }


    public function aumentarCantidad(Request $request)
    {
        $request->validate([
            'id_carrito' => 'required|integer',
            'id_producto' => 'required|integer',
            'cantidad_incremento' => 'required|integer|min:1',
        ]);

        $productoEnCarrito = ProductosEnCarrito::increaseProductQuantity(
            $request->id_carrito,
            $request->id_producto,
            $request->cantidad_incremento
        );

        return response()->json($productoEnCarrito, 200);
    }

    public function disminuirCantidad(Request $request)
    {
        $request->validate([
            'id_carrito' => 'required|integer',
            'id_producto' => 'required|integer',
            'cantidad_decremento' => 'required|integer|min:1',
        ]);

        $productoEnCarrito = ProductosEnCarrito::decreaseProductQuantity(
            $request->id_carrito,
            $request->id_producto,
            $request->cantidad_decremento
        );

        return response()->json($productoEnCarrito, 200);
    }
}