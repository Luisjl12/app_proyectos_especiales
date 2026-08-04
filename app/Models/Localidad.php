<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Localidad extends Model
{
    use HasFactory; 

    protected $table = 'localidades';

    protected $fillable = 
    [
        'nombre_localidad'
    ]; 

    public function municipio(): BelongsTo
    {
        return $this ->belongsTo(Municipio::class); 
    }
}
