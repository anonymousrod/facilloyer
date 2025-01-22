<?php

namespace App\Http\Controllers;

use App\Models\ArticleContratBail;
use App\Models\Bien;
use App\Models\ContratsDeBail;
use App\Models\Locataire;
use App\Models\LocataireBien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agent_online = Auth::user()->agent_immobiliers->first()->id;
        // Récupère les biens de l'agent connecté
        $biens = Bien::where('agent_immobilier_id', $agent_online)->get();

        // Retourne la vue avec les biens
        return view('layouts.liste_bien', compact('biens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('layouts.add_bien_by_agent');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //
        $request->validate([
            'name_bien' => 'required|string|max:255',
            'name_proprietaire' => 'required|string|max:255',
            'proprietaire_numéro' => 'required|string|max:20',
            'adresse_bien' => 'required|string|max:255',
            'type_bien' => 'required|string|max:255',
            'nombre_de_piece' => 'required|integer|min:1',
            'nombre_de_salon' => 'required|integer|min:1',
            'nombre_de_cuisine' => 'required|integer|min:1',
            'nbr_chambres' => 'nullable|integer|min:0',
            'nbr_salles_de_bain' => 'nullable|integer|min:0',
            'superficie' => 'required|numeric|min:1',
            'loyer_mensuel' => 'required|numeric|min:0',
            'statut_bien' => 'required|string|max:255',
            'photo_bien' => 'nullable|image|max:2048',
            'photo2_bien' => 'nullable|image|max:2048',
            'photo3_bien' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);
        $storage = '/storage/';
        $data = $request->all();

        // Ajout de l'agent_immobilier_id basé sur l'utilisateur connecté
        $data['agent_immobilier_id'] = Auth::user()->agent_immobiliers->first()->id;


        if ($request->hasFile('photo_bien')) {
            $data['photo_bien'] = $storage . $request->file('photo_bien')->store('photos_biens', 'public');
        }
        if ($request->hasFile('photo2_bien')) {
            $data['photo2_bien'] = $storage . $request->file('photo2_bien')->store('photos_biens', 'public');
        }
        if ($request->hasFile('photo3_bien')) {
            $data['photo3_bien'] = $storage . $request->file('photo3_bien')->store('photos_biens', 'public');
        }

        Bien::create($data);

        return redirect()->back()->with('success', 'Bien ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $bien_id, ?string $agent_id = null)
    {
        if (Auth::user()->id_role == 2) {
            $articles = ArticleContratBail::where('agent_immobilier_id', $agent_id)->get();
        }
        if (Auth::user()->id_role == 3) {

            $agent_connecter = Auth::user()->agent_immobiliers->first()->id;
            $articles = ArticleContratBail::where('agent_immobilier_id', $agent_connecter)->get();

        }
        $bien = Bien::findOrFail($bien_id);

        // Vérifier si un locataire est assigné à ce bien
        $locataireAssigné = LocataireBien::where('bien_id', $bien_id)->with('locataire')->first();
        // Selectionner les contrat de bail relier au bien

        $contrat = ContratsDeBail::where('bien_id', $bien->id)
            ->where('locataire_id', $locataireAssigné?->locataire->id)
            ->first();



        return view('layouts.bien_detail', [
            'bien' => $bien,
            'locataireAssigné' => $locataireAssigné,
            'contrat' => $contrat,
            'articles' => $articles,
        ]);
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Récupérer les informations du bien à modifier
        $bien = Bien::findOrFail($id);
        return view('layouts.add_bien_by_agent', compact('bien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // Valider les données
        $request->validate([
            'name_bien' => 'required|string|max:255',
            'name_proprietaire' => 'required|string|max:255',
            'proprietaire_numéro' => 'required|string|max:20',
            'statut_bien' => 'required|in:Disponible,Loué,Vendu',
            'nombre_de_piece' => 'required|integer',
            'nbr_chambres' => 'nullable|integer',
            'nbr_salles_de_bain' => 'nullable|integer',
            'nombre_de_salon' => 'required|integer|min:1',
            'nombre_de_cuisine' => 'required|integer|min:1',
            'superficie' => 'required|numeric',
            'loyer_mensuel' => 'required|numeric',
            'type_bien' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'adresse_bien' => 'required|string|max:255',
            'photo_bien' => 'nullable|image|max:1024',
            'photo2_bien' => 'nullable|image|max:1024',
            'photo3_bien' => 'nullable|image|max:1024',
        ]);


        // Trouver le bien existant
        $bien = Bien::findOrFail($id);

        // Mettre à jour les données simples
        $bien->name_bien = $request->name_bien;
        $bien->name_proprietaire = $request->name_proprietaire;
        $bien->proprietaire_numéro = $request->proprietaire_numéro;
        $bien->statut_bien = $request->statut_bien;
        $bien->nombre_de_piece = $request->nombre_de_piece;
        $bien->nombre_de_salon = $request->nombre_de_salon;
        $bien->nombre_de_cuisine = $request->nombre_de_cuisine;
        $bien->nbr_chambres = $request->nbr_chambres;
        $bien->nbr_salles_de_bain = $request->nbr_salles_de_bain;
        $bien->superficie = $request->superficie;
        $bien->loyer_mensuel = $request->loyer_mensuel;
        $bien->type_bien = $request->type_bien;
        $bien->description = $request->description;
        $bien->adresse_bien = $request->adresse_bien;

        $storage = '/storage/';

        // Mettre à jour les fichiers uniquement si de nouveaux fichiers sont soumis
        if ($request->hasFile('photo_bien')) {
            $photoBienPath = $request->file('photo_bien')->store('photos_biens', 'public');
            $bien->photo_bien = $storage . $photoBienPath;
        }
        // Mettre à jour les fichiers uniquement si de nouveaux fichiers sont soumis
        if ($request->hasFile('photo2_bien')) {
            $photoBienPath = $request->file('photo2_bien')->store('photos_biens', 'public');
            $bien->photo2_bien = $storage . $photoBienPath;
        }
        // Mettre à jour les fichiers uniquement si de nouveaux fichiers sont soumis
        if ($request->hasFile('photo3_bien')) {
            $photoBienPath = $request->file('photo3_bien')->store('photos_biens', 'public');
            $bien->photo3_bien = $storage . $photoBienPath;
        }
        // Sauvegarder les modifications
        $bien->save();

        return redirect()->route('biens.show', $bien->id)->with('success', 'Les informations du bien ont été mises à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bien = Bien::findOrFail($id);

        // Vérifier si un locataire est assigné
        $locataireAssigné = LocataireBien::where('bien_id', $id)->exists();

        if ($locataireAssigné) {
            return redirect()->route('biens.show', $id)
                ->with('error', 'Ce bien ne peut pas être supprimé tant qu’il est assigné à un locataire.');
        }

        // Supprimer le bien
        $bien->delete();

        return redirect()->route('biens.index')
            ->with('success', 'Bien supprimé avec succès.');
    }
}
