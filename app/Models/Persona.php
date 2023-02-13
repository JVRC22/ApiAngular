<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';
    protected $fillable = ['nombre', 'ap_paterno', 'ap_materno', 'sexo', 'f_nac'];
    protected $hidden = ['created_at', 'updated_at'];
}
