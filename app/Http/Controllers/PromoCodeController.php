<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\UsedPromoxCodeExport;
use Maatwebsite\Excel\Facades\Excel;

class PromoCodeController extends Controller
{
    public function exportUsedPromoCode()
    {
        return Excel::download(new UsedPromoxCodeExport, 'usedPrmoCodes.xlsx');
    }
}
