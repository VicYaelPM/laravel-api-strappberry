<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('productos_en_carrito', function (Blueprint $table) {
            $table->id('id_productos_en_carrito');
            $table->unsignedBigInteger('id_carrito');
            $table->unsignedBigInteger('id_producto');
            $table->integer('cantidad_producto')->nullable();
            $table->float('costo_total')->nullable();
            $table->timestamps();

            $table->foreign('id_carrito')->references('id_carritos')->on('carritos')->onDelete('NO ACTION')->onUpdate('NO ACTION');
            $table->foreign('id_producto')->references('id_productos')->on('productos')->onDelete('NO ACTION')->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_en_carritos');
    }
};
