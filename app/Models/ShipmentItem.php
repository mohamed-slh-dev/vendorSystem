<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentItem extends Model
{
    use HasFactory;

    public function shipment()
    {
        return $this->belongsTo('App\Models\Shipment');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function itemSells()
    {
        return $this->hasMany('App\Models\ShipmentItemSell');
    }
}
