<?php

namespace App\Http\Controllers;

use App\Models\Locataire;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportListePDF extends Controller
{
    //
    public function exportPdf()
    {
        $locataires = Locataire::with('user')->get();

        $options = [
            'isRemoteEnabled' => true,
            'isPhpEnabled' => true,
            'defaultFont' => 'sans-serif',
            'chroot' => [
                public_path(),
                storage_path('app/public')
            ]
        ];

        // Configurer PDF avec les options
        $pdf = PDF::setOptions($options)
            ->loadView('exports.locataires_pdf', compact('locataires'));

        return $pdf->download('locataires.pdf');
    }

    
}


