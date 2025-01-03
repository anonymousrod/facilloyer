<?php

namespace App\Http\Controllers;

use App\Models\ContratDeBailLocataire;
use App\Models\ContratDeBail;
use App\Models\Paiement;
use App\Models\Bien;
use App\Models\AgentImmobilier;
use App\Models\LocataireBien;
use App\Models\Locataire;
use App\Models\User;
use App\Notifications\SendLocataireLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class LocataireController extends Controller
{

    public function showInformations($id)
    {
        // Correction du nom de la relation
        $locataire = Locataire::with([
            'user',
            'agent_immobilier',
            'paiements.bien',
            'contrat_de_bail_locataires.contrats_de_bail.bien'
        ])->findOrFail($id);
        
        // Statistiques des paiements
        $statsPaiements = [
            'total_paye' => $locataire->paiements->sum('montant'),
            'montant_restant' => $locataire->paiements->sum('montant_restant'),
            'montant_total_periode' => $locataire->paiements->sum('montant_total_periode'),
            'derniers_paiements' => $locataire->paiements
                ->sortByDesc('date')
                ->take(5)
        ];

        // Historique des biens loués avec leurs contrats
        $biensLoues = $locataire->contrat_de_bail_locataires->map(function($contrat) {
            return [
                'bien' => $contrat->contrats_de_bail->bien ?? null,
                'contrat' => [
                    'date_debut' => $contrat->date_debut,
                    'periode_paiement' => $contrat->periode_paiement,
                    'loyer_mensuel' => $contrat->contrats_de_bail->loyer_mensuel ?? 0,
                    'depot_garantie' => $contrat->contrats_de_bail->depot_de_garantie ?? 0
                ]
            ];
        });

        return view('locataire.locainformations', compact(
            'locataire',
            'statsPaiements',
            'biensLoues'
        ));
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
        // $locataire = Auth::user()->locataires->first();

        // if (!$locataire) {
        //     abort(404, 'Aucun locataire associé à cet utilisateur.');
        // }

        // return view('locataire.edit', compact('locataire'));
    }

    /**
     * Met à jour les informations du locataire connecté.
     */
    public function update(Request $request, $id)
    {
        // Validation des données, y compris le fichier
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'date_naissance' => 'required|date',
            'genre' => 'required|string|max:10',
            'revenu_mensuel' => 'required|numeric',
            'nombre_personne_foyer' => 'required|numeric',
            'statut_matrimoniale' => 'required|string|max:20',
            'statut_professionnel' => 'required|string|max:255',
            'garant' => 'nullable|string|max:255',
            'photo_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $locataire = Locataire::findOrFail($id);
        $user = Auth::user();

        // Mise à jour des informations
        $locataire->nom = $request->input('nom');
        $locataire->prenom = $request->input('prenom');
        $locataire->adresse = $request->input('adresse');
        $locataire->telephone = $request->input('telephone');
        $locataire->date_naissance = $request->input('date_naissance');
        $locataire->genre = $request->input('genre');
        $locataire->revenu_mensuel = $request->input('revenu_mensuel');
        $locataire->nombre_personne_foyer = $request->input('nombre_personne_foyer');
        $locataire->statut_matrimoniale = $request->input('statut_matrimoniale');
        $locataire->statut_professionnel = $request->input('statut_professionnel');
        $locataire->garant = $request->input('garant');

        // Gestion de l'image (si un fichier est téléchargé)
        if ($request->hasFile('photo_profil')) {
            // Supprimer l'ancienne image si elle existe
            if ($locataire->photo_profil && file_exists(public_path('images/profils/' . $locataire->photo_profil))) {
                unlink(public_path('images/profils/' . $locataire->photo_profil));
            }

            // Sauvegarder la nouvelle image
            $imageName = time() . '.' . $request->photo_profil->extension();
            $request->photo_profil->move(public_path('images/profils'), $imageName);
            $locataire->photo_profil = $imageName;
        }


        // Sauvegarde des modifications
        $locataire->save();

        return redirect()->route('locataire.show', $user)->with('success', 'Les informations ont été mises à jour avec succès.');
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
   
public function showAgentInfo($locataireId)
    {
        // Vérifiez si le locataire existe
        $locataire = Locataire::find($locataireId);
        if (!$locataire) {
            abort(404, 'Locataire non trouvé.');
        }
    
        // Vérifiez si un agent est lié au locataire
        $agent = $locataire->agent_immobilier; // Assurez-vous que cette relation est correcte
        if (!$agent) {
            return back()->withErrors('Aucun agent immobilier associé à ce locataire.');
        }
    
        // Retournez la vue avec les données nécessaires
        return view('locataire.agentinfo', compact('agent', 'locataire'));
    }
    

}
