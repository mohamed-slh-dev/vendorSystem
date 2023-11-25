<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    public function shipmentItmes()
    {
        return $this->hasMany('App\Models\ShipmentItem');
    }

    public function otherTransactions()
    {
        return $this->hasMany('App\Models\OtherTransaction');
    }

    public function dailySellItmes()
    {
        return $this->hasMany('App\Models\DailySellItem');
    }
}
