<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carritos extends Model
{
    use HasFactory;

    protected $table = 'carritos';
    protected $primaryKey = 'id_carritos';
    public $timestamps = false;

    protected $fillable = ['id_user', 'costo_total'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
