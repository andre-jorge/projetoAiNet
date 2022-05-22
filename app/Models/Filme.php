<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filme extends Model
{
    use HasFactory;

    public function Sessoes()
    {
        return $this->hasMany(Sessao::class);
        //1departamento tem varios docentes
        //docentes relacionados com departamentos
        //departamento é opcional define a chave estrangeira
        //abreviatura opcial define a primary key
    }

    public function generos()
    {
        return $this->belongsTo(Genero::class, 'genero_code', 'code');
    }



    // public function FilmeGenero()
    // {
    //     return $this->belongsTo(Genero::class, 'code', 'code');
    // }
    protected $fillable = [
        'titulo', 'genero_code', 'cartaz_url', 'ano', 'sumario',
        'trailer_url'];

}

    
    

