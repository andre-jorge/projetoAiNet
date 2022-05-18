<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessao extends Model
{
    //use HasFactory;
    protected $table = "sessoes";


    public function sessoes()
    {
        return $this->belongsToMany(
            Disciplina::class,
            'docentes_disciplinas',
            'docente_id',
            'disciplina_id'
        );
    }
}
