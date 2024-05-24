<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carritos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarritosController extends Controller
{
    public function index()
    {
        $carritos = Carritos::all();

        if ($carritos->isEmpty()) {
            $data = [
                'message' => 'No se encontraron carritos',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'carritos' => $carritos,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'nullable|exists:users,id',
            'costo_total' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->filled('id_user')) {
            $existingCarrito = Carritos::where('id_user', $request->id_user)->first();
            if ($existingCarrito) {
                $data = [
                    'message' => 'Carrito ya existe para este usuario',
                    'carrito_id' => $existingCarrito->id,
                    'status' => 200
                ];
                return response()->json($data, 200);
            }
        }

        $carrito = Carritos::create($request->all());

        if (!$carrito) {
            $data = [
                'message' => 'Error al crear el carrito',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'carrito' => $carrito,
            'status' => 201
        ];

        return response()->json($data, 201);
    }
    public function show($id)
    {
        $carrito = Carritos::find($id);

        if (!$carrito) {
            $data = [
                'message' => 'Carrito no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'carrito' => $carrito,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $carrito = Carritos::find($id);

        if (!$carrito) {
            $data = [
                'message' => 'Carrito no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'id_user' => 'nullable|exists:users,id',
            'costo_total' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $carrito->id_user = $request->id_user;
        $carrito->costo_total = $request->costo_total;

        $carrito->save();

        $data = [
            'message' => 'Carrito actualizado',
            'carrito' => $carrito,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $carrito = Carritos::find($id);

        if (!$carrito) {
            $data = [
                'message' => 'Carrito no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $carrito->delete();

        $data = [
            'message' => 'Carrito eliminado',
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
