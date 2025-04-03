<?php

namespace App\Http\Controllers;

use App\Models\ArticleContratBail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
