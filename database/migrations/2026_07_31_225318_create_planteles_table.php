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
        Schema::create('planteles', function (Blueprint $table) {
            $table->id();
            $table->string('cct'); 
            $table->integer('numero_edificios')->nullable(); 
            $table->string('nombre_escuela')->nullable(); 

            //Llaves foraneas
            $table->foreignId('municipio_id')->constrained('municipios')->cascadeOnDelete(); 
            $table->foreignId('localiades_id')->constrained('localidades')->cascadeOnDelete();
            $table->foreignId('corde_id')->constrained('corde')->cascadeOnDelete();

            //Domicilios
            $table->string('turno')->nullable();
            $table->string('nivel_educativo')->nullable(); 
            $table->string('sostenimiento')->nullable(); 
            $table->string('domicilio_calle_numero')->nullable();  
            $table->string('domicilio_colonia')->nullable(); 
            $table->string('domicilio_cp')->nullable(); 

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planteles');
    }
};
