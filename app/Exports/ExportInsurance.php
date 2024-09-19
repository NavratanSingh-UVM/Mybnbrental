<?php

namespace App\Exports;
use App\Models\Insurance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class ExportInsurance implements FromCollection,WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($insurances)
    {
        $this->insurances = $insurances;
     }
    public function collection()
    {
        return $this->insurances;
    }
    public function headings(): array
    {
        return [
            'Id',
            'Insurance name',
            'Property name',
            'Payment date',
            'Start date',
            'End date',
            'check in',
            'check out',
            'Details',
        ];
    }
}
