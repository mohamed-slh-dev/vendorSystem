<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailySellItem extends Model
{
    use HasFactory;

    public function dailySells()
    {
        return $this->hasMany('App\Models\ShipmentItemSell');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function shipment()
    {
        return $this->belongsTo('App\Models\Shipment');
    }
}
