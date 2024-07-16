<?php

namespace App\Exports;

use App\Models\Shipment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ShipmentsExport implements FromView
{
    public function view(): View
    {
        return view(
            'excel-page',
            [
                'shipments' => Shipment::all()
            ]
        );
    }
}
