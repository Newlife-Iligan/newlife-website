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

        $browsershot = Browsershot::html($html)
            ->setNodeBinary(env('NODE_BINARY', 'node'))
            ->setNpmBinary(env('NPM_BINARY', 'npm'))
            ->format('A4')
            ->margins(10, 10, 10, 10)
            ->showBackground();

        if ($chromePath = env('CHROME_PATH')) {
            $browsershot->setChromePath($chromePath);
        }

        $pdf = $browsershot->pdf();

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
