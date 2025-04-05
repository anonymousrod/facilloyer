<?php

namespace App\Http\Controllers;

use App\Models\ArticleContratBail;
use App\Models\ContratsDeBail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleContratBailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = ArticleContratBail::where('agent_immobilier_id', Auth::user()->agent_immobiliers->first()->id)->get();
        return view('layouts.liste_article_contrat_bail', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.add_article_contrat_bail');
    }
    public function create_specifique($contratId)
    {
        $contrat = ContratsDeBail::findOrFail($contratId);
        return view('layouts.add_article_contrat_bail_specifique', compact('contrat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre_article' => 'required|string|max:255',
            'contenu_article' => 'required|string',
        ]);

        // Créer l'article en utilisant l'ID de l'agent connecté
        ArticleContratBail::create([
            'agent_immobilier_id' => Auth::user()->agent_immobiliers->first()->id,
            'titre_article' => $request->titre_article,
            'contenu_article' => $request->contenu_article,
        ]);

        return redirect()->route('article.create')->with('success', 'Article ajouté avec succès.');
    }

    // public function ajouterArticleSpecifique(Request $request, $contratId)
    // {
    //     $contrat = ContratsDeBail::findOrFail($contratId);

    //     $request->validate([
    //         'titre_article' => 'required|string|max:255',
    //         'contenu_article' => 'required|string',
    //     ]);

    //     $contrat->articles()->attach(null, [
    //         'titre_article' => $request->titre_article,
    //         'contenu_article' => $request->contenu_article
    //     ]);
    //     dd($contrat->articles());
    //     return redirect()->route('biens.show', ['bien_id' =>$contrat->bien->id]  )->with('success', 'Article ajouté avec succès.');
    // }

    // public function ajouterArticleSpecifique(Request $request, $contratId)
    // {
    //     $contrat = ContratsDeBail::findOrFail($contratId);

    //     // Validation des champs
    //     $request->validate([
    //         'titre_article' => 'required|string|max:255',
    //         'contenu_article' => 'required|string',
    //     ]);

    //     // 🔥 Créer un nouvel article spécifique
    //     $article = ArticleContratBail::create([
    //         'agent_immobilier_id' => Auth::user()->agent_immobiliers->first()->id,
    //         'titre_article' => $request->titre_article,
    //         'contenu_article' => $request->contenu_article
    //     ]);

    //     // 🔗 Attacher l'article au contrat avec les données pivot
    //     $contrat->articles()->attach($article->id, [
    //         'titre_article' => $article->titre_article,
    //         'contenu_article' => $article->contenu_article
    //     ]);

    //     return redirect()->route('biens.show', ['bien_id' => $contrat->bien->id])
    //         ->with('success', 'Article ajouté avec succès.');
    // }


    // public function ajouterArticleSpecifique(Request $request, $contratId)
    // {
    //     $contrat = ContratsDeBail::findOrFail($contratId);

    //     // Validation des champs
    //     $request->validate([
    //         'titre_article' => 'required|string|max:255',
    //         'contenu_article' => 'required|string',
    //     ]);

    //     // Ajouter directement à la table pivot sans passer par ArticleContratBail
    //     $contrat->articles()->attach(null, [
    //         'titre_article' => $request->titre_article,
    //         'contenu_article' => $request->contenu_article,
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);

    //     return redirect()->route('biens.show', ['bien_id' => $contrat->bien->id])
    //         ->with('success', 'Article spécifique ajouté au contrat.');
    // }

    // public function ajouterArticleSpecifique(Request $request, $contratId)
    // {
    //     $contrat = ContratsDeBail::findOrFail($contratId);

    //     // Validation des champs
    //     $request->validate([
    //         'titre_article' => 'required|string|max:255',
    //         'contenu_article' => 'required|string',
    //     ]);

    //     // Ajouter l'article directement dans la table pivot sans passer par ArticleContratBail
    //     $contrat->articles()->attach([
    //         'article_source_id' => null, // Aucun article par défaut
    //         'titre_article' => $request->titre_article,
    //         'contenu_article' => $request->contenu_article,
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);

    //     return redirect()->route('biens.show', ['bien_id' => $contrat->bien->id])
    //         ->with('success', 'Article spécifique ajouté au contrat.');
    // }

    public function ajouterArticleSpecifique(Request $request, $contratId)
    {
        $contrat = ContratsDeBail::findOrFail($contratId);

        // Validation des champs
        $request->validate([
            'titre_article' => 'required|string|max:255',
            'contenu_article' => 'required|string',
        ]);

        // Ajouter directement à la table pivot sans passer par ArticleContratBail
        DB::table('contrat_de_bail_article')->insert([
            'contrat_de_bail_id' => $contrat->id,
            'article_source_id' => null, // Pas d'article par défaut
            'titre_article' => $request->titre_article,
            'contenu_article' => $request->contenu_article,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('biens.show', ['bien_id' => $contrat->bien->id])
            ->with('success', 'Article spécifique ajouté au contrat.');
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $articles = ArticleContratBail::findOrFail($id);
        return view('layouts.add_article_contrat_bail', compact('articles'));
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
        $article = ArticleContratBail::findOrFail($id);

        // Vérifie s'il est utilisé dans un contrat existant
        $isUsedInContracts = DB::table('contrat_de_bail_article')
            ->where('article_source_id', $article->id)
            ->exists();

        // S'il est utilisé, on bloque la mise à jour
        if ($isUsedInContracts) {
            return redirect()->back()->with('error', "Impossible de modifier cet article car il est utilisé dans des contrats existants.");
        }

        $request->validate([
            // 'agent_immobilier_id' => 'required|exists:agent_immobilier,id',
            'titre_article' => 'required|string|max:255',
            'contenu_article' => 'required|string',
        ]);

        $article->update($request->all());

        return redirect()->route('article.show', $article->id)->with('success', 'Article modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     $article = ArticleContratBail::findOrFail($id);

    //     $article->delete();

    //     return redirect()->route('article.index')->with('success', 'Article supprimé avec succès.');
    // }
    public function destroy($id)
    {
        try {
            $article = ArticleContratBail::findOrFail($id);
            $article->delete();

            return back()->with('success', 'Article supprimé avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
