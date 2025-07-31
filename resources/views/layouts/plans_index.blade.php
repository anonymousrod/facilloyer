@php
    $agent = auth()->user()->agent_immobiliers->first();
@endphp

@extends('layouts.master_dash')
@section('title', 'Abonnement')
@section('content')

    <div class="container-xxl py-5">
        <div class="container">
            <h2 class="mb-5 text-center fw-bold">Choisissez un Plan d’Abonnement</h2>

            @if (session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            <div class="row g-4">
                @foreach ($plans as $plan)
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm h-100 border-0">
                            <div class="card-header bg-white text-center">
                                <h5 class="fw-bold text-primary mb-0">{{ $plan->nom }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <span class="badge bg-success fs-5 px-3 py-2">
                                        {{ number_format($plan->prix, 0, ',', ' ') }} FCFA
                                    </span>
                                    <p class="text-muted mt-2 mb-0">Durée : <strong>{{ $plan->duree }} jours</strong></p>
                                </div>
                                <hr>
                                <p class="text-center text-muted small">
                                    {{ $plan->description }}
                                </p>
                            </div>
                            <div class="card-footer bg-white text-center">
                                <button class="btn btn-outline-primary w-100"
                                    onclick="launchKkiapay('{{ $plan->id }}', '{{ $plan->nom }}', '{{ $plan->prix }}')">
                                    Choisir ce plan
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script src="https://cdn.kkiapay.me/k.js"></script>

    <script>
        const agentId = "{{ $agent->id }}";
        const agentPhone = "{{ $agent->telephone_agence ?? '97000000' }}";
        const agentEmail = "{{ auth()->user()->email }}";
        const agentName = "{{ auth()->user()->nom }}";
        const agentFirstName = "{{ auth()->user()->prenoms }}";

        let selectedPlanId = null;
        let selectedPlanName = null;
        let selectedPlanPrice = null;

        function launchKkiapay(planId, planName, planPrice) {
            selectedPlanId = planId;
            selectedPlanName = planName;
            selectedPlanPrice = planPrice;

            openKkiapayWidget({
                amount: selectedPlanPrice,
                key: "{{ env('KKIAPAY_PUBLIC_KEY') }}",
                sandbox: true,
                name: selectedPlanName,
                email: agentEmail,
                phone: agentPhone,
                firstname: agentFirstName,
                lastname: agentName,
                data: "Abonnement " + selectedPlanName,
                theme: "#E63C33"
            });

            addSuccessListener(function(response) {
                console.log("Paiement réussi", response);

                const transactionId = response.transactionId;

                // Appel AJAX vers la route API Laravel
                fetch("{{ url('/api/abonnement/success') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        // "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        agent_id: agentId,
                        plan_id: selectedPlanId,
                        transaction_id: transactionId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log("Serveur:", data);
                    alert("Abonnement activé avec succès !");
                    window.location.href = "{{ route('dashboard') }}";
                })
                .catch(error => {
                    console.error("Erreur lors de l'enregistrement :", error);
                    alert("Paiement effectué mais une erreur est survenue. Contactez le support.");
                });
            });

            addFailedListener(function(error) {
                console.error("Erreur de paiement :", error);
                alert("Le paiement a échoué. Veuillez réessayer.");
            });
        }
    </script>



@endsection
