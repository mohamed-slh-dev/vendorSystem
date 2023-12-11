<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function shipmentItmes()
    {
        return $this->hasMany('App\Models\ShipmentItem');
    }

    public function notes()
    {
        return $this->hasMany('App\Models\Note');
    }

    public function dailySellItems()
    {
        return $this->hasMany('App\Models\DailySellItem');
    }

    public function dailyShorts()
    {
        return $this->hasMany('App\Models\DailyShort');
    }
}
