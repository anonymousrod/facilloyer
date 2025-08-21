<?php

namespace App\Http\Controllers;

use App\Models\ContratDeBailLocataire;
use App\Models\ContratDeBail;
use App\Models\Paiement;
use App\Models\Bien;
use App\Models\AgentImmobilier;
use App\Notifications\SendLocataireLogin;
use App\Models\LocataireBien;
use App\Models\Locataire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class LocataireController extends Controller
{

    // Affiche les informations détaillées du locataire


   public function showInformations(Locataire $locataire)
{
    $paiementsDuMois = $locataire->paiements()
        ->whereMonth('date_paiement', now()->month)
        ->whereYear('date_paiement', now()->year)
        ->get();

    $user = Auth::user();
    $message = !$user->statut ? "Votre compte est en attente d'activation par l'administrateur." : null;

    return view('locataire.locashow', compact('locataire', 'paiementsDuMois', 'message'));
}

public function showlocatairebien(Locataire $locataire)
{
    return view('locataire.locataire_bien', compact('locataire'));
}





    // admin use pour afficher chaque les profil locataire
    public function showProfil(Locataire $locataire)
    {
        return view('admin.locataires.profil', compact('locataire'));
    }




    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agent_id = Auth::user()->agent_immobiliers->first()->id;
        //pour l'affichage des locataires
        $locataires = Locataire::where('agent_id', $agent_id)->get();
        return view('layouts.liste_locataire', compact('locataires'));
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
            // 'name' => $request->name,
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
    public function show($user)
    {
        $locataire = Auth::user()->locataires->first();

        if (!$locataire) {
            abort(404, 'Aucun locataire associé à cet utilisateur.');
        }

        // Rediriger vers la vue d'édition
        return view('locataire.edit', compact('locataire'));
    }


    /**
     * Affiche le formulaire pour modifier les informations du locataire connecté.
     */
    public function edit()
    {
        // Récupérer le locataire connecté
        $locataire = Auth::user()->locataires->first();

        if (!$locataire) {
            abort(404, 'Aucun locataire associé à cet utilisateur.');
        }

        return view('locataire.edit', compact('locataire'));
    }

    /**
     * Met à jour les informations du locataire connecté.
     */
    public function update(Request $request, $id)
    {
        // Validation des champs
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'date_naissance' => 'required|date',
            'genre' => 'required|in:Masculin,Féminin',
            'revenu_mensuel' => 'required|numeric|min:0',
            'nombre_personne_foyer' => 'required|integer|min:1',
            'statut_matrimoniale' => 'required|string|in:Célibataire,Marié(e),Divorcé(e),Veuf(ve)',
            'garant' => 'nullable|string|max:255',
            'photo_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2 MB pour la photo
        ]);

        try {
            // Récupération du locataire
            $locataire = Locataire::findOrFail($id);

            // Mise à jour des champs simples
            $locataire->nom = $request->nom;
            $locataire->prenom = $request->prenom;
            $locataire->adresse = $request->adresse;
            $locataire->telephone = $request->telephone;
            $locataire->date_naissance = $request->date_naissance;
            $locataire->genre = $request->genre;
            $locataire->revenu_mensuel = $request->revenu_mensuel;
            $locataire->nombre_personne_foyer = $request->nombre_personne_foyer;
            $locataire->statut_matrimoniale = $request->statut_matrimoniale;
            $locataire->garant = $request->garant;

            // Gestion de la photo de profil
            if ($request->hasFile('photo_profil')) {
                $photoProfilPath = $request->file('photo_profil')->store('photos_profil', 'public');
                $storage = '/storage/';
                $locataire->photo_profil = $storage . $photoProfilPath; // Met à jour la base de données
            }

            // Sauvegarder les modifications
            $locataire->save();

            // Mettre à jour le champ `name` de l'utilisateur
            $user = $locataire->user; // Si `le locataire` a une relation avec `User`
            $user->name = $request->nom . ' ' . $request->prenom; // Mettre à jour le nom complet
            $user->save(); // Sauvegarder les modifications de l'utilisateur


            // Retourner une réponse ou redirection
            return redirect()->route('locataire.locashow')->with('success', 'Vos informations ont été mises à jour avec succès.');
        } catch (\Exception $e) {
            // Gestion des erreurs
            return back()->with('error', 'Une erreur s\'est produite lors de la mise à jour. Veuillez réessayer.');
        }
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

    public function toggleStatus(Request $request, $id)
    {
        $locataire = Locataire::findOrFail($id);
        $locataire->user->statut = $request->statut;
        $locataire->user->save();

        return response()->json(['success' => true]);
    }

    public function agenceImmobiliereAssociee()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Vérifier si l'utilisateur est connecté et est un locataire
        if (!$user || !$user->locataires()->exists()) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas un locataire ou connecté.');
        }

        // Récupérer le locataire et l'agence immobilière associée
        $locataire = $user->locataires()->first();
        $agent = $locataire->agent_immobilier; // Vérifiez que cette relation existe

        // Vérifier si une agence est associée
        if (!$agent) {
            return redirect()->back()->with('error', 'Aucune agence immobilière associée.');
        }

        // Debug : Affichez les données pour confirmer
        // dd($agent);

        // Retourner la vue avec les données
        return view('locataire.agentinfo', compact('locataire', 'agent'));
    }




    public function updateEvaluation(Request $request, $id)
    {
        try {
            // Validation
            $request->validate([
                'evaluation' => 'required|numeric|min:1|max:5',
            ]);

            // Récupérer l'agent
            $agent = AgentImmobilier::find($id);
            if (!$agent) {
                return response()->json(['error' => 'Agent non trouvé.'], 404);
            }

            // Mise à jour de l'évaluation
            $agent->evaluation = $request->evaluation;
            $agent->save();

            // Répondre avec succès
            return response()->json([
                'success' => 'Évaluation mise à jour avec succès.',
                'evaluation' => $agent->evaluation,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function search(Request $request)
    {
        $query = $request->input('query'); // Texte de recherche
        $bienId = $request->input('bien_id'); // ID du bien

        // Locataires non assignés à ce bien
        $locataires = Locataire::where('agent_id', Auth::user()->agent_immobiliers->first()->id)
            ->whereDoesntHave('locataireBiens', function ($q) use ($bienId) {
                $q->where('bien_id', $bienId);
            })
            ->where(function ($q) use ($query) {
                $q->where('nom', 'like', "%$query%")
                    ->orWhere('prenom', 'like', "%$query%");
            })
            ->select('id', 'nom', 'prenom') // Ne retourner que les champs nécessaires
            ->get();

        return response()->json($locataires); // Retourner les résultats au format JSON
    }
}
