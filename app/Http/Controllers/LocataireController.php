<?php

namespace App\Http\Controllers;

use App\Models\Locataire;
use App\Models\User;
use App\Notifications\SendLocataireLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class LocataireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //pour l'affichage des locataires

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.add_locataire_by_agent');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            // 'email' => 'required|email|unique:users,email',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        ]);

        // Générer un mot de passe aléatoire
        $randomPassword = Str::random(8);

        // Ajouter le locataire dans la table users
        $tenant = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($randomPassword),
            'id_role' => 2, // Rôle "Locataire"
            'statut' => true,
            'must_change_password' => true,
        ]);

        // Ajouter l'id du locataire creer dans la table locataire (user_id) ainsi que l'agent_id qui est authentifier
        $agentImmobilier = Auth::user()->agent_immobiliers;
        // dd($agentImmobilier);

        Locataire::create([
            'user_id' => $tenant->id,
            'agent_id' => $agentImmobilier->first()->id
        ]);



        // Envoyer l'email avec les informations de connexion
        $tenant->notify(new SendLocataireLogin($randomPassword));

        return redirect()->back()->with('success', 'Le locataire a été ajouté et un email a été envoyé avec ses informations de connexion.');
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

    // Affiche le formulaire pour changer le mot de passe
    public function showChangePasswordForm()
    {
        return view('auth.passwords_change');
    }

    // Change le mot de passe
    public function changePassword(Request $request)
    {
        // Validation des entrées
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        // Récupérer l'utilisateur actuellement connecté
        $user = Auth::user();

        // Mise à jour du mot de passe
        $user->password = Hash::make($request->password);
        $user->must_change_password = false;  // Le locataire n'a plus à changer son mot de passe
        $user->save();

        return redirect()->route('dashboard')->with('message', 'Votre mot de passe a été modifié avec succès.');
    }
}
