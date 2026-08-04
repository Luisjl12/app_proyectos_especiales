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
            $table->string('telefono_plantel')->nullable(); 
            $table->string('correo_institucional')->nullable(); 
            
            //Accesibilidad
            $table->boolean('accesibilidad_rampas')->default(false); 
            $table->boolean('accesibilidad_banos_adaptados')->default(false); 
            $table->boolean('accesibilidad_senaletica_braile')->default(false); 
            $table->text('accesibilidad_otros')->nullable(); 

            //Total de alumnos y maestros
            $table->integer('total_alumnos')->nullable(); 
            $table->integer('total_docentes')->nullable(); 
            $table->integer('total_adiministrativos')->nullable(); 
            
            //Latitud y longitud 
            $table->decimal('latitud', 10, 8)->nullable(); 
            $table->decimal('longitud', 11, 8)->nullable();
            
            //Estatus
            $table->enum('estatus_plantel', ['Activo', 'Inactivo', 'En revision'])->default('En revision'); 
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
