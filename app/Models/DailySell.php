<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailySell extends Model
{
    use HasFactory;

    public function dailySellItmes()
    {
        return $this->hasMany('App\Models\DailySellItem');
    }
}
