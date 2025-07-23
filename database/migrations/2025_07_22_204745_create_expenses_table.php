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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id(); // ID
            $table->unsignedBigInteger('deputado_id');
            $table->integer('ano');
            $table->integer('mes');
            $table->string('tipo_despesa')->nullable();
            $table->string('fornecedor')->nullable();
            $table->string('cnpj_cpf')->nullable();
            $table->decimal('valor_documento', 10, 2)->default(0);
            $table->decimal('valor_glosa', 10, 2)->default(0);
            $table->decimal('valor_liquido', 10, 2)->default(0);
            $table->date('data_documento')->nullable();
            $table->string('url_documento')->nullable();
            $table->timestamps();
            $table->foreign('deputado_id')->references('id')->on('deputies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
