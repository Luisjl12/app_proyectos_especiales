<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Corde extends Model
{
    use HasFactory; 

    protected $table = 'cordes';
    
    protected $fillable=[
        'clave_corde', 
        'nombre_corde', 
    ]; 

    public function planteles(): HasMany
    {
        return $this->hasMany(Plantel::class); 
    }
}
