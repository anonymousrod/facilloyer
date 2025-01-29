@extends('layouts.master_dash')

@section('content')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-lg rounded-4 animate__animated animate__fadeIn" style="max-width: 600px;">
        <!-- En-tête de la carte -->
        <div class="card-header text-center bg-gradient-primary text-white py-4 rounded-top-4">
            <h3 class="fw-bold">💳 Effectuer un Paiement</h3>
            <p class="mb-0 text-light">Payez votre loyer en toute simplicité et sécurité</p>
        </div>
        
        <!-- Corps de la carte -->
        <div class="card-body p-5">
            <form id="paymentForm">
                @csrf
                <!-- Champ pour saisir le montant -->
                <div class="form-group mb-4">
                    <label for="montant" class="form-label fw-bold fs-5">
                        PAIEMENT VIA KKIPAY <span class="text-danger">*</span> :
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-secondary">
                            <i class="fas fa-money-bill-wave"></i>
                        </span>
                        <input 
                            type="number" 
                            id="montant" 
                            name="montant" 
                            class="form-control form-control-lg rounded-end" 
                            placeholder="Exemple : 20000 (en FCFA)" 
                            required 
                            min="1"
                        >
                    </div>
                    <small class="text-muted">Saisissez le montant que vous voudrez payez dans le loyer restant.</small>
                </div>

                <!-- Méthodes de paiement -->
                <div class="form-group mb-4">
                    <label class="form-label fw-bold fs-5">
                        Méthodes de Paiement Disponibles :
                    </label>
                    <div class="d-flex justify-content-around gap-3 mt-3">
                        <div class="text-center">
                            <img 
                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/35/MTN_Logo.svg/512px-MTN_Logo.svg.png" 
                                alt="MTN MoMo" 
                                class="img-fluid" 
                                style="max-height: 50px;" 
                                title="MTN MoMo">
                            <p class="mt-2 mb-0 small text-secondary">MTN MoMo</p>
                        </div>
                        <div class="text-center">
                            <img 
                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/Moov_Logo.svg/512px-Moov_Logo.svg.png" 
                                alt="Moov Money" 
                                class="img-fluid" 
                                style="max-height: 50px;" 
                                title="Moov Money">
                            <p class="mt-2 mb-0 small text-secondary">Moov Money</p>
                        </div>
                        <div class="text-center">
                            <img 
                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_2021.svg/512px-Visa_2021.svg.png" 
                                alt="Visa" 
                                class="img-fluid" 
                                style="max-height: 50px;" 
                                title="Visa">
                            <p class="mt-2 mb-0 small text-secondary">Carte Visa</p>
                        </div>
                        <div class="text-center">
                            <img 
                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/512px-Mastercard-logo.svg.png" 
                                alt="Mastercard" 
                                class="img-fluid" 
                                style="max-height: 50px;" 
                                title="Mastercard">
                            <p class="mt-2 mb-0 small text-secondary">Mastercard</p>
                        </div>
                    </div>
                </div>

                <!-- Bouton de paiement -->
                <div class="d-grid">
                    <button 
                        type="button" 
                        id="payButton" 
                        class="btn btn-primary btn-lg fw-bold shadow-lg d-flex align-items-center justify-content-center gap-2 rounded-pill"
                        style="background: linear-gradient(90deg, #1E88E5, #FFA726); border: none; transition: transform 0.3s, box-shadow 0.3s;"
                        >
                        
                        <i class="fas fa-credit-card"></i> Payer Maintenant
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Ajout de styles et animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<!-- Script Kkiapay -->
<script src="https://cdn.kkiapay.me/k.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const montantInput = document.getElementById('montant');
        const payButton = document.getElementById('payButton');

        // Animation sur le bouton au survol
        payButton.addEventListener('mouseover', () => {
            payButton.classList.add('animate__pulse');
        });
        payButton.addEventListener('mouseleave', () => {
            payButton.classList.remove('animate__pulse');
        });

        // Ajouter un écouteur d'événement pour ouvrir le widget Kkiapay au clic sur le bouton
        payButton.addEventListener('click', function () {
            const montant = parseFloat(montantInput.value) || 0;
            if (montant <= 0) {
                alert("Veuillez saisir un montant valide !");
                return;
            }
            if (montant > 10000000) { // Exemple : Limite arbitraire
                alert("Le montant dépasse la limite autorisée !");
                return;
            }

            // Initialiser le widget Kkiapay
            openKkiapayWidget({
                amount: montant, // Kkiapay attend le montant en centimes
                sandbox: true, // Mode test activé
                key: 'ef4bf4407fe711efbca255daf9c4feeb', // Remplacez par votre clé publique Kkiapay
                theme: '#1E88E5', // Couleur du thème du widget
                callback:"{{ route('payments.callback')}}", // Redirection après un paiement réussi
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
