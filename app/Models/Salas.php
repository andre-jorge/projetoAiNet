<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salas extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome','costum'];

    //LIGAÇÃO SESSOES COM SALA OK
    public function Sessao(){
        return $this->hasMany(Sessao::class,'sala_id','id');
    }

}
