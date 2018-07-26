<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Database\Eloquent\Collection;

class ReportsServices implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;        
    }

    public function collection()
    {
        return $this->collection;
    }

    public function headings(): array
    {
        return [
            __('Order'),
            __('Started in'),
            __('Finished in'),
            __('User'),
            __('Plate'),
            __('Client'),
            __('Service Type'),
            __('Annotations'),
        ];
    }

    public function map($collection): array
    {
        return [
            $collection->order,
            $collection->started_in,            
            !empty($collection->finished_in) ? $collection->finished_in : '-',
            $collection->user->name,
            $collection->vehicle->plate,
            !empty($collection->client->name) ? $collection->client->name : '-',
            $collection->service_type->name,
            !empty($collection->annotations) ? $collection->annotations : '-',
        ];
    }
}
