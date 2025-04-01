<?php

namespace Modules\Cards\Exports;

use App\Order;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientsExport implements FromArray, WithHeadings
{
    protected $clients;

    public function headings(): array
    {
        return [
            'card',
            'client_name',
            'client_email',
            'client_phone',
            'client_address',
            'client_city',
            'created',
            'points',
            'movments'
        ];
    }

    public function __construct(array $clients)
    {
        $this->clients = $clients;
    }

    public function array(): array
    {
        return $this->clients;
    }
}
