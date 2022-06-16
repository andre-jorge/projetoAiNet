<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salas extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = false;
    protected $softDelete = true;

    protected $fillable = [
        'nome','custom'];

    protected $casts = [
            'custom' => 'array',
        ];

    //LIGAÇÃO SESSOES COM SALA OK
    public function Sessao(){
        return $this->hasMany(Sessao::class,'sala_id','id');
    }

    public function Lugares()
    {
    return $this->hasMany(Lugares::class,'sala_id','id');
    }

}
