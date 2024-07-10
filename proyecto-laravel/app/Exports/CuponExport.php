<?php

namespace App\Exports;

use App\Models\Cupon;
use Maatwebsite\Excel\Concerns\FromCollection;

class CuponExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cupon::all();
    }
}
