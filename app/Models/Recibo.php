<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{  
    protected $table = 'recibos';

    public function Cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }
    protected $fillable = [
        'cliente_id', 'data', 'preco_total_sem_iva', 'iva', 'preco_total_com_iva',
        'nif','tipo_pagamento','ref_pagamento'];

}