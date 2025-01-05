<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Str;
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
        // Récupération des agents immobiliers avec leurs utilisateurs
        $agents = AgentImmobilier::with('user')->get();
    
        // Retourne la vue avec les données
        return view('admin.agents.index', compact('agents'));
    }
    
    // Méthode pour changer le statut de l'utilisateur lié
 public function toggleStatus(Request $request, $id)
    {
        try {
            $agent = User::findOrFail($id); // Vérifie si l'utilisateur existe
            $agent->statut = $request->statut ? 1 : 0; // Met à jour le statut
            $agent->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès.',
                'statut' => $agent->statut ? 'Activé' : 'Désactivé',
            ]);
        } catch (\Exception $e) {
            // Retourne une erreur JSON
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            ], 500);
        }
    }
public function updateStatus($id)
    {
        $agent = AgentImmobilier::withTrashed()->findOrFail($id);
    
        // Si l'agent est déjà désactivé (soft delete), on le réactive
        if ($agent->deleted_at) {
            $agent->restore();
            return redirect()->back()->with('success', 'L\'agent a été activé.');
        } else {
            // Sinon, on le désactive (soft delete)
            $agent->delete();
            return redirect()->back()->with('success', 'L\'agent a été désactivé.');
        }
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
            'photo_profil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'carte_identite_pdf' => 'required|mimes:pdf|max:2048',
            'rccm_pdf' => 'required|mimes:pdf|max:2048',
        ]);

        // Gestion des fichiers uploadés
        $photoProfilPath = $request->file('photo_profil')->store('photos_profil', 'public');
        $carteIdentitePath = $request->file('carte_identite_pdf')->store('cartes_identite', 'public');
        $rccmPath = $request->file('rccm_pdf')->store('rccm', 'public');
        $storage = '/storage/';

        // Ajouter `user_id` aux données du formulaire
        // $request->merge([
        //     'user_id' => Auth::user()->id,
        //     'photo_profil' => $photoProfilPath,
        //     // 'carte_identite_pdf' =>$carteIdentitePath,
        //     // 'rccm_pdf' =>$rccmPath,
        // ]);
        // dd($request->all());
        // Créer l'agent immobilier avec toutes les données, y compris `user_id`

        // AgentImmobilier::create($request->all());
        AgentImmobilier::create([
            // dd(Auth::user()),
            'user_id' => Auth::user()->id, // Associer l'agent à l'utilisateur connecté
            'nom_agence' => $request->nom_agence,
            'nom_admin' => $request->nom_admin,
            'prenom_admin' => $request->prenom_admin,
            'telephone_agence' => $request->telephone_agence,
            'annee_experience' => $request->annee_experience,
            'adresse_agence' => $request->adresse_agence,
            'territoire_couvert' => $request->territoire_couvert,
            'nombre_bien_disponible' => $request->nombre_bien_disponible,
            'photo_profil' => $storage . $photoProfilPath,
            'carte_identite_pdf' => $storage . $carteIdentitePath,
            'rccm_pdf' => $storage . $rccmPath,

        ]);

        return redirect()->route('agent_immobilier.create')->with('success', 'Vos information on bien été enregistrer.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Récupérer l'agent immobilier avec ses relations
        $agent = AgentImmobilier::with(['user', 'biens',])->findOrFail($id);
    
        // Retourner la vue avec les données de l'agent
        return view('admin.agents.show', compact('agent'));
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
        $agent = AgentImmobilier::findOrFail($id);
        $request->validate([
            'nom_agence' => 'required|string|max:255',
            'nom_admin' => 'required|string|max:255',
            'prenom_admin' => 'required|string|max:255',
            'telephone_agence' => 'required|string|max:20',
            'annee_experience' => 'required|integer|min:0',
            'adresse_agence' => 'required|string',
            'territoire_couvert' => 'required|string',
            'nombre_bien_disponible' => 'required|integer|min:0',
            'photo_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'carte_identite_pdf' => 'nullable|mimes:pdf|max:2048',
            'rccm_pdf' => 'nullable|mimes:pdf|max:2048',
        ]);

        $storage = '/storage/';

        // Mettre à jour les fichiers uniquement si de nouveaux fichiers sont soumis
        if ($request->hasFile('photo_profil')) {
            $photoProfilPath = $request->file('photo_profil')->store('photos_profil', 'public');
            $agent->photo_profil = $storage . $photoProfilPath;
        }

        if ($request->hasFile('carte_identite_pdf')) {
            $carteIdentitePath = $request->file('carte_identite_pdf')->store('cartes_identite', 'public');
            $agent->carte_identite_pdf = $storage . $carteIdentitePath;
        }

        if ($request->hasFile('rccm_pdf')) {
            $rccmPath = $request->file('rccm_pdf')->store('rccm', 'public');
            $agent->rccm_pdf = $storage . $rccmPath;
        }

        // Mettre à jour les autres champs
        $agent->nom_agence = $request->nom_agence;
        $agent->nom_admin = $request->nom_admin;
        $agent->prenom_admin = $request->prenom_admin;
        $agent->telephone_agence = $request->telephone_agence;
        $agent->annee_experience = $request->annee_experience;
        $agent->adresse_agence = $request->adresse_agence;
        $agent->territoire_couvert = $request->territoire_couvert;
        $agent->nombre_bien_disponible = $request->nombre_bien_disponible;
        
        // Sauvegarder les modifications
        $agent->save();

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
