<?php

namespace App\Http\Controllers;

use App\Models\AgentImmobilier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentImmobilierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Vérifier si l'agent immobilier existe déjà dans la base de données
        $agentImmobilier = AgentImmobilier::where('user_id', Auth::user()->id)->first();

        return view('layouts.agence_info', compact('agentImmobilier'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nom_agence' => 'required|string|max:255',
            'nom_admin' => 'required|string|max:255',
            'prenom_admin' => 'required|string|max:255',
            'telephone_agence' => 'required|string|max:20',
            'annee_experience' => 'required|integer|min:0',
            'adresse_agence' => 'required|string',
            'territoire_couvert' => 'required|string',
            'nombre_bien_disponible' => 'required|integer|min:0',
        ]);


        // Ajouter `user_id` aux données du formulaire
        $request->merge(['user_id' => Auth::user()->id]);

        // Créer l'agent immobilier avec toutes les données, y compris `user_id`
        AgentImmobilier::create($request->all());
        return redirect()->route('agent_immobilier.create')->with('success', 'Vos information on bien été enregistrer.');
        // AgentImmobilier::create([
        //     dd(Auth::user()),
        //     'user_id' => auth()->id, // Associer l'agent à l'utilisateur connecté
        //     'nom_agence' => $request->nom_agence,
        //     'nom_admin' => $request->nom_admin,
        //     'prenom_admin' => $request->prenom_admin,
        //     'telephone_agence' => $request->telephone_agence,
        //     'annee_experience' => $request->annee_experience,
        //     'adresse_agence' => $request->adresse_agence,
        //     'territoire_couvert' => $request->territoire_couvert,
        //     'nombre_bien_disponible' => $request->nombre_bien_disponible,
        // ]);

        // return redirect()->route('agence_info.create')->with('success', 'Agent immobilier ajouté avec succès.');
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
        $request->validate([
            'nom_agence' => 'required|string|max:255',
            'nom_admin' => 'required|string|max:255',
            'prenom_admin' => 'required|string|max:255',
            'telephone_agence' => 'required|string|max:20',
            'annee_experience' => 'required|integer|min:0',
            'adresse_agence' => 'required|string',
            'territoire_couvert' => 'required|string',
            'nombre_bien_disponible' => 'required|integer|min:0',
        ]);

        $agent = AgentImmobilier::findOrFail($id);
        $agent->update($request->all());

        return redirect()->route('agent_immobilier.create')->with('success', 'Les informations de l\'agent immobilier ont été mises à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
}
