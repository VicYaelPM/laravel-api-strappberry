<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoriaProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaProductoController extends Controller
{
    public function index()
    {
        $categorias = CategoriaProducto::all();

        if ($categorias->isEmpty()) {
            $data = [
                'message' => 'No se encontraron categorías de productos',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'categorias' => $categorias,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:60',
            'descripcion' => 'nullable|max:300',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $categoria = CategoriaProducto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        if (!$categoria) {
            $data = [
                'message' => 'Error al crear la categoría de productos',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'categoria' => $categoria,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $categoria = CategoriaProducto::find($id);

        if (!$categoria) {
            $data = [
                'message' => 'Categoría de productos no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'categoria' => $categoria,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $categoria = CategoriaProducto::find($id);

        if (!$categoria) {
            $data = [
                'message' => 'Categoría de productos no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:60',
            'descripcion' => 'nullable|max:300',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();

        $data = [
            'message' => 'Categoría de productos actualizada',
            'categoria' => $categoria,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $categoria = CategoriaProducto::find($id);

        if (!$categoria) {
            $data = [
                'message' => 'Categoría de productos no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $categoria->delete();

        $data = [
            'message' => 'Categoría de productos eliminada',
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
