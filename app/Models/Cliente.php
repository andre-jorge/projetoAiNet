<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{  
    use HasFactory;
    protected $table = 'clientes';

    public function User()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

}