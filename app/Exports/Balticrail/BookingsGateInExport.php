<?php

namespace App\Exports\Balticrail;

use App\Models\Balticrail\Bookings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class BookingsGateInExport implements FromQuery
{
    use Exportable;

    public function __construct(int $id)
    {
        $this->id = $id;
    }


    public function query()
    {
        return Bookings::query()->where('id', $this->id);
    }
}
