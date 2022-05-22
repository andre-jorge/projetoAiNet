<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salas extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome'];

    public function salas()
    {
        return $this->hasMany(Sessao::class);
        //1departamento tem varios docentes
        //docentes relacionados com departamentos
        //departamento é opcional define a chave estrangeira
        //abreviatura opcial define a primary key
    }

}
