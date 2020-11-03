<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    public $timestamps = false;
    protected $table = 'evento';
    protected $fillable = [
        'nomeEvento', 'inicio', 'termino', 'endereco', 'cidade','estado','acessos','foto'
    ];
}
