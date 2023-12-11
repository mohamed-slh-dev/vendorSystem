<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyShort extends Model
{
    use HasFactory;


    public function dailySell()
    {
        return $this->belongsTo('App\Models\DailySell');
    }

    public function shipment()
    {
        return $this->belongsTo('App\Models\Shipment');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

}
