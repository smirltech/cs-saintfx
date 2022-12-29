<?php

namespace App\Traits;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

trait WithPrintToPdf
{
    // set code
    public function printToPdf(string $view, array $data, string $filename)
    {
        $pdf = PDF::loadView($view, $data)->output();
        return response()->streamDownload(static fn()=>print ($pdf), $filename);
    }

}
