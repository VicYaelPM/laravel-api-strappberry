<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaProducto extends Model
{
    use HasFactory;

    protected $table = 'categoria_productos';
    protected $primaryKey = 'id_categoria_productos';
    protected $fillable = ['nombre', 'descripcion'];

    // Relación con productos
    public function productos()
    {
        return $this->hasMany(Productos::class, 'id_categoria');
    }
}
