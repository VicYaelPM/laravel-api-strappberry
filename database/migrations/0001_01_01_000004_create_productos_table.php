<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_productos');
            $table->string('nombre', 100)->nullable();
            $table->float('precio')->nullable();
            $table->string('descripcion', 200)->nullable();
            $table->unsignedBigInteger('id_categoria')->nullable();
            $table->float('precio_con_descuento')->nullable();
            $table->float('peso')->nullable();
            $table->tinyInteger('estatus')->nullable();
            $table->timestamps();

            $table->foreign('id_categoria')
                ->references('id_categoria_productos')
                ->on('categoria_productos');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
