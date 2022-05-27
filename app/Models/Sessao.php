<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessao extends Model
{
    //use HasFactory;
    protected $table = "sessoes";

    //LIGAÇÃO FILMES COM SESSOES OK
    public function Filmes()
    {
        return $this->belongsTo(Filme::class, 'filme_id', 'id');
    }

    //LIGAÇÃO SALAS COM SESSOES OK
    public function Salas()
    {
    return $this->belongsTo(Salas::class,'sala_id','id');
    }


    protected $fillable = [
        'filme_id', 'sala_id', 'data', 'horario_inicio'];
}
