<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filme extends Model
{
    use HasFactory;

    //LIGAÇÃO GENEROS COM FILMES OK
    public function Generos()
    {
        return $this->belongsTo(Genero::class, 'genero_code', 'code');
    }

    //LIGAÇÃO FILMES COM SESSOES OK
    public function Sessao(){
        return $this->hasMany(Sessao::class,'filme_id','id');
    }




    // public function FilmeGenero()
    // {
    //     return $this->belongsTo(Genero::class, 'code', 'code');
    // }
    protected $fillable = [
        'titulo', 'genero_code', 'cartaz_url', 'ano', 'sumario',
        'trailer_url'];




}

    
    

