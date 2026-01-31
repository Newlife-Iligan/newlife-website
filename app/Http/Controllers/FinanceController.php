<?php

namespace App\Http\Controllers;

use App\Models\NlFinance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

        $token = env('BROWSERLESS_API_TOKEN');
        $printUrl = url("/finance/print/{$id}");

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->timeout(60)
            ->post("https://production-sfo.browserless.io/chrome/pdf?token={$token}", [
                'url' => $printUrl,
                'options' => [
                    'format' => 'A4',
                    'printBackground' => true,
                    'margin' => [
                        'top' => '10mm',
                        'right' => '10mm',
                        'bottom' => '10mm',
                        'left' => '10mm',
                    ],
                ],
            ]);

        if ($response->failed()) {
            return response()->json(['PDF generation failed.'], 500);
        }

        return response($response->body(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
