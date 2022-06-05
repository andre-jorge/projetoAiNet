<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bilhetes extends Model
{  
    use HasFactory;
    protected $table = 'bilhetes';

    public function Cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    public function Recibo()
    {
        return $this->belongsTo(Recibo::class, 'recibo_id', 'id');
    }

    public function Sessao()
    {
        return $this->belongsTo(Sessao::class, 'sessao_id', 'id');
    }

    public function Lugares()
    {
        return $this->belongsTo(Lugares::class, 'lugar_id', 'id');
    }

    
    protected $fillable = [ 'recibo_id','cliente_id', 'sessao_id','lugar_id','preco_sem_iva',
        'estado'];
}