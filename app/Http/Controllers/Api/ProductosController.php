<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductosController extends Controller
{
    public function index()
    {
        $productos = Productos::with('categoria')->get();

        if ($productos->isEmpty()) {
            $data = [
                'message' => 'No se encontraron productos',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'productos' => $productos,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'precio' => 'required',
            'descripcion' => 'required',
            'id_categoria' => 'required|exists:categoria_productos,id_categoria_productos',
            'peso' => 'required',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('imagenes', 'public');
        }

        $producto = Productos::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'id_categoria' => $request->id_categoria,
            'precio_con_descuento' => $request->precio_con_descuento,
            'peso' => $request->peso,
            'estatus' => $request->estatus,
            'imagen' => $imagenPath,
        ]);

        if (!$producto) {
            $data = [
                'message' => 'Error al crear el producto',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'producto' => $producto,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $producto = Productos::with('categoria')->find($id);

        if (!$producto) {
            $data = [
                'message' => 'Productos no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'producto' => $producto,
            'categoria' => $producto->categoria,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id_productos)
    {
        $producto = Productos::find($id_productos);

        if (!$producto) {
            $data = [
                'message' => 'Productos no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $producto->delete();

        $data = [
            'message' => 'Productos eliminado',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $producto = Productos::find($id);

        if (!$producto) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'precio' => 'required',
            'descripcion' => 'required',
            'id_categoria' => 'required|exists:categoria_productos,id_categoria_productos',
            'peso' => 'required',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->hasFile('imagen')) {
            // Eliminar la imagen antigua si existe
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $producto->imagen = $request->file('imagen')->store('imagenes', 'public');
        }

        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->id_categoria = $request->id_categoria;
        $producto->precio_con_descuento = $request->precio_con_descuento;
        $producto->peso = $request->peso;
        $producto->estatus = $request->estatus;

        $producto->save();

        $data = [
            'message' => 'Producto actualizado',
            'producto' => $producto,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
    public function buscarPorCategoria($id_categoria)
    {
        $productos = Productos::with('categoria')->where('id_categoria', $id_categoria)->get();

        if ($productos->isEmpty()) {
            $data = [
                'message' => 'No se encontraron productos para esta categoría',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'productos' => $productos,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
