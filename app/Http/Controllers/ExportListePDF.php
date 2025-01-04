<?php

namespace App\Http\Controllers;

use App\Models\Locataire;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class ExportListePDF extends Controller
{
    //
    public function exportPdf()
    {
        $agent_id = FacadesAuth::user()->agent_immobiliers->first()->id;
        //pour l'affichage des locataires
        $locataires = Locataire::where('agent_id', $agent_id)->get();
        // return view('layouts.liste_locataire', compact('locataires'));
        // $locataires = Locataire::with('user')->get();

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


