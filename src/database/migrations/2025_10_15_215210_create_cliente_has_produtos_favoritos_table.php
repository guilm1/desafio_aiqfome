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
        Schema::create('cliente_has_produtos_favoritos', function (Blueprint $table) {
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('produto_externo_id');
            $table->timestamps();
            $table->foreign('cliente_id')->references('id')->on('cliente')->onDelete('cascade');
            $table->unique(['cliente_id', 'produto_externo_id'], 'unique_cliente_produto');
            $table->index('produto_externo_id', 'idx_produto_externo_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente_has_produtos_favoritos');
    }
};
