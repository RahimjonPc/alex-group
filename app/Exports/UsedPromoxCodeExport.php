<?php

namespace App\Exports;

use App\Models\PromoCode;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsedPromoxCodeExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function headings(): array
    {
        return [
            'Пользователь',
            'Промокод'
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return PromoCode::where('status', PromoCode::USED);
    }

    public function map($promocode): array
    {
        return [
            $promocode->user->name,
            $promocode->code,
        ];
    }
}
