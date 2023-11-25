<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentItemSell extends Model
{
    use HasFactory;

    public function shipmentItem()
    {
        return $this->belongsTo('App\Models\ShipmentItemSell');
    }
}
