<?php

namespace App\Imports;

use App\Models\PromoCode;
use Maatwebsite\Excel\Concerns\ToModel;

class PromoCodeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PromoCode([
            'code' => $row[0],
            'status' => PromoCode::NEW_CODE,
        ]);
    }
}
