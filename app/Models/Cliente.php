<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{  
    use HasFactory, SoftDeletes;
    protected $table = 'clientes';
    public $timestamps = true;


    public function User()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
    
    protected $fillable = [
        'id','nif','tipo_pagamento','ref_pagamento'];

    protected $casts = [
            'custom' => 'array',
        ];
}