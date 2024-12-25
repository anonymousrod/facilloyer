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
        // Récupérer les locataires avec leurs relations
        $locataires = Locataire::with('user')->get();
        

        // Activer les images distantes
        Pdf::setOptions(['isRemoteEnabled' => true]);

        // Charger la vue pour le PDF
        $pdf = Pdf::loadView('exports.locataires_pdf', compact('locataires'));

        // Retourner le fichier PDF téléchargé
        return $pdf->download('locataires.pdf');
    }
}
