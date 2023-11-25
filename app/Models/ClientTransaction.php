<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientTransaction extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
}
