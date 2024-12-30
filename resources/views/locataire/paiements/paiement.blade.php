@extends('layouts.master_dash')

@section('content')
<h2>Paiement</h2>
<p>Montant total pour la période : {{ number_format($montantTotal, 2) }} €</p>

<form action="{{ route('paiement.effectuer') }}" method="POST">
    @csrf
    <input type="hidden" name="contrat_id" value="{{ $contrat->id }}">

    <label for="montant_paye">Montant à payer :</label>
    <input type="number" name="montant_paye" min="0" step="0.01" required>

    <label for="description_paiement">Description du paiement :</label>
    <input type="text" name="description_paiement" placeholder="Exemple : Loyer de décembre 2024" required>

    <button type="submit">Effectuer le paiement</button>
</form>
@endsection
