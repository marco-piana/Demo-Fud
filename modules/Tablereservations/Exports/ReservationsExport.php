<?php

namespace Modules\Tablereservations\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Contacts\Models\Field;

class ReservationsExport implements FromArray, WithHeadings
{
    protected $reservations;

    public function headings(): array
    {
        $headings= [
            'Reservation Code',
            'Name',
            'Phone',
            'Date',
            'Time',
            'Status',
            'Table',
            'Created At',
            'Updated At',
            'Relative Time',
        ];
        return $headings;   
    }

    public function __construct(array $reservations)
    {
        $this->reservations = $reservations;
    }

    public function array(): array
    {
        return $this->reservations;
    }
}
