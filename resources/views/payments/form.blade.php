@extends('layouts.master_dash')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header text-center bg-primary text-white">
            <h4>Effectuer un paiement</h4>
        </div>
        <div class="card-body">
            <form id="paymentForm">
                @csrf
                <!-- Champ pour saisir le montant -->
                <div class="form-group">
                    <label for="montant">Montant à payer :</label>
                    <input 
                        type="number" 
                        id="montant" 
                        name="montant" 
                        class="form-control" 
                        placeholder="Saisissez le montant" 
                        required 
                        min="1"
                    >
                </div>

                <!-- Bouton de paiement -->
                <button 
                    type="button" 
                    id="payButton" 
                    class="btn btn-primary btn-block mt-4"
                >
                    Payer maintenant
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Script Kkiapay -->
<script src="https://cdn.kkiapay.me/k.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const montantInput = document.getElementById('montant');
        const payButton = document.getElementById('payButton');

        // Ajouter un écouteur d'événement pour ouvrir le widget Kkiapay au clic sur le bouton
        payButton.addEventListener('click', function () {
            const montant = parseFloat(montantInput.value) || 0;

            if (montant <= 0) {
                alert("Veuillez saisir un montant valide !");
                return;
            }

            // Initialiser le widget Kkiapay
            openKkiapayWidget({
                amount: montant, // Kkiapay attend le montant en centimes
                sandbox: true, // Mode test activé
                key: 'ef4bf4407fe711efbca255daf9c4feeb', // Remplacez par votre clé publique Kkiapay
                theme: '#1E88E5', // Couleur du thème du widget
                callback: 'dashboard', // Redirection après un paiement réussi
                data: 'Paiement pour un locataire', // Informations supplémentaires sur la transaction
            });
        });

        // Ajouter des écouteurs pour capturer le succès ou l'échec du paiement
        addSuccessListener(response => {
            console.log('Paiement réussi:', response);
            alert('Paiement effectué avec succès !');
        });

        addFailedListener(error => {
            console.log('Échec du paiement:', error);
            alert('Le paiement a échoué. Veuillez réessayer.');
        });
    });
</script>
@endsection
