<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\UsedPromoxCodeExport;
use App\Exports\NewPromoCodeExport;
use Maatwebsite\Excel\Facades\Excel;

class PromoCodeController extends Controller
{
    public function exportUsedPromoCode()
    {
        return Excel::download(new UsedPromoxCodeExport, 'usedPrmoCodes.xlsx');
    }

    public function exportNewPromoCode()
    {
        return Excel::download(new NewPromoCodeExport, 'newPromoCodes.xlsx');
    }
}
