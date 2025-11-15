<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;

class TicketsExport implements FromCollection
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query->get([
            'id', 'date', 'total_stake', 'total_odds', 'total_return', 'status'
        ]);
    }
}
