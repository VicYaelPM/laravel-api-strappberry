<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_productos';

    protected $fillable = [
        'nombre',
        'precio',
        'descripcion',
        'id_categoria',
        'precio_con_descuento',
        'peso',
        'estatus',
        'imagen'
    ];

    // Relación con la categoría de productos
    public function categoria()
    {
        return $this->belongsTo(CategoriaProducto::class, 'id_categoria_productos');
    }
}
