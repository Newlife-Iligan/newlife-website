<?php

namespace App\Http\Controllers;

use App\Models\NlFinance;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

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

    public function downloadForm(Request $request,$id)
    {
        $data = NlFinance::find($id);
        if(!$data)
        {
            return response()->json(['Not found.'],404);
        }

        $filename = 'finance_' . $data->form_type . '_' . now()->format('Ymd_His') . '.pdf';

        $html = view('finance.print.cv_form', compact('data'))->render();

        $pdf = Browsershot::html($html)
            ->setNodeBinary(config('browsershot.node_binary', 'node'))
            ->setNpmBinary(config('browsershot.npm_binary', 'npm'))
            ->format('A4')
            ->margins(10, 10, 10, 10)
            ->showBackground()
            ->pdf();

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
