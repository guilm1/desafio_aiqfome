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
        Schema::create('integracao_servicos_has_campos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('integracao_servicos_id')->constrained('integracao_servicos')->onDelete('cascade');
            $table->string('sigla', 100);
            $table->text('valor');
            $table->timestamps();
            $table->unique(['integracao_servicos_id', 'sigla']);
            $table->index('integracao_servicos_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integracao_servicos_has_campos');
    }
};
