@extends('layouts.master_dash')
@section('title', 'Paiement du Loyer')
@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <div class="card shadow-sm rounded-4 border">
                

                <div class="card-body px-4 py-5">
                    <form id="payment-form" novalidate>
                        @csrf

                        <div class="mb-4">
                            <label for="montant" class="form-label fw-semibold">Montant que vous souhaitez payer dans votre total restant (FCFA)</label>
                            <input 
                                type="number" min="100" step="100" 
                                class="form-control form-control-lg rounded-pill"
                                id="montant" name="montant" 
                                value="{{ old('montant', $gestionPeriode->montant_restant_periode ?? '') }}" 
                                required
                                aria-describedby="montantHelp"
                                placeholder="Entrez le montant à payer" />
                            <div id="montantHelp" class="form-text text-muted">
                                Minimum 1000 FCFA
                            </div>
                        </div>

                        <div class="text-center mb-4 small text-secondary fst-italic">
                            En enpuyant payez, Je confirme vouloir payer ce montant sans possiblité de réclamation
                        </div>

                        <button 
                            type="button" 
                            class="btn btn-primary btn-lg w-100 rounded-pill fw-semibold"
                            onclick="launchKkiapay()"
                            id="pay-button"
                        >
                            <i class="fas fa-credit-card me-2"></i> Payer avec Kkiapay
                        </button>

                        <div id="payment-feedback" class="mt-3 d-none alert" role="alert"></div>
                    </form>
                </div>

                <div class="card-footer d-flex justify-content-center gap-4 flex-wrap">
                    <!-- Logos chargés depuis internet -->
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRh7rNIKTPXUAxBPLhSCMjhk7plEilRV986gw&s" alt="MTN Mobile Money" title="MTN Mobile Money" class="img-fluid" style="height: 36px;">
                    <img src="https://play-lh.googleusercontent.com/abIwBzGTucbPNRDtFaovqR8bl39QznwWN6gCmBovKhNTLip0j6SmejSjAlTzg37BeE0" alt="Moov Money" title="Moov Money" class="img-fluid" style="height: 36px;">
                    <img src="https://www.ubagroup.com/nigeria/wp-content/uploads/sites/3/2018/10/visa-logo-300x300.jpg" alt="Visa" title="Visa" class="img-fluid" style="height: 36px;">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Mastercard_2019_logo.svg/120px-Mastercard_2019_logo.svg.png" alt="Mastercard" title="Mastercard" class="img-fluid" style="height: 36px;">
                    <img src="https://pbs.twimg.com/profile_images/646404903934431232/XjeK14Sz_400x400.jpg" alt="Ecgt" title="Ecgt" class="img-fluid" style="height: 36px;">
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.kkiapay.me/k.js"></script>
<script>
    const locataireId = "{{ $locataire->id ?? '' }}";
    const bienId = "{{ $bien->id ?? '' }}";
    const userEmail = "{{ auth()->user()->email ?? '' }}";
    const userName = "{{ auth()->user()->nom ?? 'Locataire' }}";
    const publicKey = "{{ env('KKIAPAY_PUBLIC_KEY') }}";

    const feedbackEl = document.getElementById('payment-feedback');
    const payBtn = document.getElementById('pay-button');

    function showFeedback(message, type = 'success') {
        feedbackEl.textContent = message;
        feedbackEl.className = '';
        feedbackEl.classList.add('alert', `alert-${type}`, 'rounded-3');
        feedbackEl.classList.remove('d-none');
    }

    function launchKkiapay() {
        const montantInput = document.getElementById('montant');
        const montant = parseInt(montantInput.value);

        feedbackEl.classList.add('d-none');
        feedbackEl.textContent = '';

        if (isNaN(montant) || montant < 1000) {
            showFeedback('Le montant minimum est de 1000 FCFA', 'danger');
            montantInput.focus();
            return;
        }

        payBtn.disabled = true;
        payBtn.textContent = 'Chargement...';

        openKkiapayWidget({
            amount: montant,
            key: publicKey,
            sandbox: true,
            email: userEmail,
            data: `Paiement loyer locataire ${locataireId}`,
            theme: "#0d6efd",
            firstName: userName
        });

        addSuccessListener(function(response) {
            const transactionId = response.transactionId;

            fetch("{{ route('paiement.kkiapay.success') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    locataire_id: locataireId,
                    bien_id: bienId,
                    montant: montant,
                    transaction_id: transactionId
                })
            })
            .then(res => res.json())
            .then(data => {
                showFeedback('Paiement enregistré avec succès ! Redirection en cours...', 'success');
                setTimeout(() => {
                    window.location.href = "{{ route('dashboard') }}";
                }, 2000);
            })
            .catch(err => {
                showFeedback('Paiement effectué mais erreur lors de l’enregistrement.', 'warning');
                console.error(err);
                payBtn.disabled = false;
                payBtn.innerHTML = '<i class="fas fa-credit-card me-2"></i> Payer avec Kkiapay';
            });
        });

        addFailedListener(function(error) {
            showFeedback('Le paiement a échoué, veuillez réessayer.', 'danger');
            console.error(error);
            payBtn.disabled = false;
            payBtn.innerHTML = '<i class="fas fa-credit-card me-2"></i> Payer avec Kkiapay';
        });
    }
</script>

@endsection
