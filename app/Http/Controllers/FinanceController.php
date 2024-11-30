<?php

namespace App\Http\Controllers;

use App\Models\NlFinance;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function printForm(Request $request,$id)
    {
        $data = NlFinance::find($id);
        if(!$data)
        {
            return response()->json(['Not found.'],404);
        }

        return view('finance.print.cv_form',compact('data'));
    }
}
