@extends('layouts.master_dash')
@section('title', 'Nouveau Paiement')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Nouveau Paiement</h4>
                </div>
                <div class="card-body">
                <form action="/paiements" method="POST">
                    @csrf
                    <input type="text" name="locataire_id" placeholder="Locataire ID">
                    <input type="text" name="bien_id" placeholder="Bien ID">
                    <input type="number" name="montant" placeholder="Montant payé">
                    <input type="number" name="montant_total_periode" placeholder="Montant total de la période">
                    <input type="text" name="mode_paiement" placeholder="Mode de paiement">
                    <input type="date" name="date" placeholder="Date du paiement">
                    <button type="submit">Créer Paiement</button>
                </form>

                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const contratSelect = document.getElementById('contrat-select');
        const loyerMensuelInput = document.getElementById('loyer-mensuel');

        // Écoute les changements dans le menu déroulant
        contratSelect.addEventListener('change', function () {
            const selectedOption = contratSelect.options[contratSelect.selectedIndex];
            const loyerMensuel = selectedOption.getAttribute('data-loyer');

            // Affiche le montant du loyer dans le champ "Loyer mensuel"
            loyerMensuelInput.value = loyerMensuel ? parseFloat(loyerMensuel).toFixed(2) : '';
        });
    });
</script>
@endsection

@endsection