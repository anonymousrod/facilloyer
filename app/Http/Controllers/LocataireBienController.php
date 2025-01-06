<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Locataire;
use App\Models\LocataireBien;
use Illuminate\Http\Request;

class LocataireBienController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function showAssignPage($id)
    {
        // Récupérer le bien concerné
        $bien = Bien::findOrFail($id);

        // Debug : Vérifions si le bien est bien trouvé
        if (!$bien) {
            dd("Le bien avec l'ID $id n'existe pas.");
        }


        // Récupérer les locataires non encore assignés
        $locataires = Locataire::whereDoesntHave('locataireBiens', function ($query) use ($id) {
            $query->where('bien_id', $id);
        })->get();

        // Debug : Vérifions si des locataires sont récupérés
        if ($locataires->isEmpty()) {
            dd("Aucun locataire non assigné trouvé.");
        }

        return view('layouts.assign-locataire', [
            'bien' => $bien,
            'locataires' => $locataires,
        ]);
    }


    public function assignLocataire(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'locataire_id' => 'required|exists:locataires,id',
        ]);

        // Vérifier si le locataire est déjà assigné à ce bien
        $isAssigned = LocataireBien::where('locataire_id', $request->locataire_id)
            ->where('bien_id', $id)
            ->exists();

        if ($isAssigned) {
            return redirect()->back()->with('error', 'Ce locataire est déjà assigné à ce bien.');
        }

        // Ajouter l'assignation dans la table
        LocataireBien::create([
            'locataire_id' => $request->locataire_id,
            'bien_id' => $id,
        ]);

        return redirect()->route('biens.show', $id)->with('success', 'Locataire assigné avec succès.');
    }

    public function unassignLocataire($bienId)
    {
        $locataireBien = LocataireBien::where('bien_id', $bienId)->first();

        if ($locataireBien) {
            $locataireBien->delete();

            return redirect()->route('biens.show', $bienId)
                ->with('success', 'Le locataire a été désassigné avec succès.');
        }

        return redirect()->route('biens.show', $bienId)
            ->with('error', 'Aucun locataire n\'est assigné à ce bien.');
    }



    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
