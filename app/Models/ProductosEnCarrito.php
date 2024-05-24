<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosEnCarrito extends Model
{
    protected $table = 'productos_en_carrito';
    protected $primaryKey = 'id_productos_en_carrito';

    protected $fillable = [
        'id_carrito',
        'id_producto',
        'cantidad_producto',
        'costo_total',
    ];

    public function carrito()
    {
        return $this->belongsTo(Carritos::class, 'id_carrito', 'id_carritos');
    }

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'id_producto', 'id_productos');
    }
    public static function addProductToCart($idCarrito, $idProducto, $cantidadProducto)
    {
        return self::create([
            'id_carrito' => $idCarrito,
            'id_producto' => $idProducto,
            'cantidad_producto' => $cantidadProducto,
            // Calcula o proporciona el costo total aquí si es necesario
        ]);
    }
    public static function decreaseProductQuantity($idCarrito, $idProducto, $cantidadDecremento)
    {
        $productoEnCarrito = self::where('id_carrito', $idCarrito)
            ->where('id_producto', $idProducto)
            ->first();

        if ($productoEnCarrito) {
            $productoEnCarrito->cantidad_producto -= $cantidadDecremento;
            // Aseguramos que la cantidad no sea negativa
            $productoEnCarrito->cantidad_producto = max($productoEnCarrito->cantidad_producto, 0);
            // Actualizamos el costo total si es necesario
            // $productoEnCarrito->costo_total = $productoEnCarrito->producto->precio * $productoEnCarrito->cantidad_producto;
            $productoEnCarrito->save();
        }

        return $productoEnCarrito;
    }
    public static function increaseProductQuantity($idCarrito, $idProducto, $cantidadIncremento)
    {
        $productoEnCarrito = self::where('id_carrito', $idCarrito)
            ->where('id_producto', $idProducto)
            ->first();

        if ($productoEnCarrito) {
            $productoEnCarrito->cantidad_producto += $cantidadIncremento;
            // Actualizamos el costo total si es necesario
            // $productoEnCarrito->costo_total = $productoEnCarrito->producto->precio * $productoEnCarrito->cantidad_producto;
            $productoEnCarrito->save();
        }

        return $productoEnCarrito;
    }
}
