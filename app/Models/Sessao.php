<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessao extends Model
{
    //use HasFactory;
    protected $table = "sessoes";


    public function FilmeSessoes()
    {
        //Docente tem um Departamento
        //aqui se define o relacionamento
        return $this->belongsTo(Filme::class);
        //departamento é opcional define a chave estrangeira
        //abreviatura opcial define a primary key
    }

    public function salas()
    {
    return $this->belongsTo(Salas::class);
    }


}
