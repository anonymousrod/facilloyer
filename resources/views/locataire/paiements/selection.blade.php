@extends('layouts.master_dash')

@section('content')
<h2>Sélectionnez un bien pour le paiement</h2>
<form action="{{ route('paiement.calcul') }}" method="POST">
    @csrf
    <label for="contrat_id">Choisir un bien :</label>
    <select name="contrat_id" required>
        @foreach($contrats as $contrat)
            <option value="{{ $contrat->id }}">{{ $contrat->contrats_de_bail->adresse_bien }} ({{ $contrat->contrats_de_bail->loyer_mensuel }} €/mois)</option>
        @endforeach
    </select>

    <label for="complement">Complément de loyer :</label>
    <input type="number" name="complement" min="0" step="0.01" placeholder="0.00">

    <button type="submit">Passer au paiement</button>
</form>
@endsection
