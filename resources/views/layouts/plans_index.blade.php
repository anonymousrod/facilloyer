{{-- @php
    $agent = auth()->user()->agent_immobiliers->first();
@endphp

@extends('layouts.master_dash')
@section('title', 'Abonnement')
@section('content')


    <link rel="stylesheet" href="{{ asset('assets/css/plans-premium.css') }}">
    <div class="container-xxl py-5" >
        <div class="container">
            <h2 class="premium-title">Choisissez un Plan d’Abonnement</h2>

            @if (session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            <div class="row g-4 justify-content-center">
                @foreach ($plans as $plan)
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                        <div class="card plans-glass-bg shadow-lg h-100 border-0">
                            <div class="card-header text-center">
                                <h5 class="mb-0">{{ $plan->nom }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <span class="badge px-4 py-2">
                                        {{ number_format($plan->prix, 0, ',', ' ') }} FCFA
                                    </span>
                                    <p class="text-muted mt-2 mb-0">Durée : <strong>{{ $plan->duree }} jours</strong></p>
                                </div>
                                <hr>
                                <p class="text-center small">
                                    {{ $plan->description }}
                                </p>
                            </div>
                            <div class="card-footer text-center border-0">
                                <button class="btn w-100"
                                    onclick="launchKkiapay('{{ $plan->id }}', '{{ $plan->nom }}', '{{ $plan->prix }}')">
                                    <i class="bi bi-lightning-charge-fill me-2"></i>Choisir ce plan
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



@endsection --}}
@php
    $agent = auth()->user()->agent_immobiliers->first();
@endphp
@extends('layouts.master_dash')
@section('title', 'Abonnement')
@section('content')

    <style>
        :root {
            --primary: #2E7D32;
            --primary-dark: #256628;
            --accent: #E63C33;
            --text-color: #222;
            --text-muted: #555;
            --bg-light: #fff;
            --shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            --radius: 1.2rem;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --text-color: #fff;
                --text-muted: #ccc;
                --bg-light: #1e1e1e;
                --shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            }
        }

        /* Titre principal */
        .premium-title {
            font-weight: 700;
            text-align: center;
            color: #28a745;
            /* Vert Bootstrap vif */
            margin-bottom: 2.5rem;
        }

        /* Container central */
        .plans-container {
            max-width: 1100px;
            margin: auto;
        }

        /* Card */
        .plan-card {
            background: var(--bg-light);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            padding: 2rem 1.8rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .plan-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
        }

        .plan-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .plan-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .plan-price {
            background: var(--primary);
            color: #fff;
            font-size: 1.2rem;
            font-weight: 700;
            padding: 0.6rem 1.6rem;
            border-radius: 50px;
            margin: 1rem 0;
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
        }

        .plan-duration {
            font-size: 1rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        .plan-description {
            font-size: 0.95rem;
            color: var(--text-color);
            text-align: center;
            line-height: 1.5;
            flex-grow: 1;
            margin-bottom: 1.5rem;
        }

        /* Bouton */
        .plan-btn {
            background: var(--primary);
            color: #fff;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 0.9rem;
            border: none;
            border-radius: 50px;
            width: 100%;
            transition: background 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
        }

        .plan-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Badge "Populaire" */
        .ribbon {
            position: absolute;
            top: 1rem;
            right: -0.6rem;
            background: var(--accent);
            color: white;
            padding: 0.3rem 1rem;
            font-size: 0.85rem;
            font-weight: 600;
            border-bottom-left-radius: 1rem;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 576px) {
            .plan-card {
                padding: 1.5rem 1.2rem;
            }
        }
    </style>

    <div class="container-xxl py-5">
        <div class="plans-container">
            <h2 class="premium-title">Choisissez un Plan d’Abonnement</h2>
            @if (session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            <div class="row g-4 justify-content-center">
                @foreach ($plans as $plan)
                    <div class="col-md-6 col-lg-4 d-flex">
                        <div class="plan-card position-relative w-100">
                            @if ($plan->is_popular)
                                <div class="ribbon">Populaire</div>
                            @endif
                            <div class="plan-header">
                                <h5 class="plan-title">{{ $plan->nom }}</h5>
                                <div class="plan-price">{{ number_format($plan->prix, 0, ',', ' ') }} FCFA</div>
                                <p class="plan-duration">Durée : <strong>{{ $plan->duree }} jours</strong></p>
                            </div>
                            <p class="plan-description">{{ $plan->description }}</p>
                            <button class="plan-btn"
                                onclick="launchKkiapay('{{ $plan->id }}', '{{ $plan->nom }}', '{{ $plan->prix }}')">
                                <i class="bi bi-lightning-charge-fill me-2"></i>Choisir ce plan
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script src="https://cdn.kkiapay.me/k.js"></script>
    <script>
        const agentId = "{{ $agent->id }}";
        //const agentPhone = "{{ $agent->telephone_agence ?? '97000000' }}";
        const agentEmail = "{{ auth()->user()->email }}";
        //const agentName = "{{ auth()->user()->nom }}";
        //const agentFirstName = "{{ auth()->user()->prenoms }}";
        const agenceName = "{{ auth()->user()->agent_immobiliers->first()->nom_agence ?? 'Mon Agence' }}";

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
                //name: selectedPlanName,
                email: agentEmail,
                //phone: agentPhone,
                // firstname: "",
                // lastname: "",
                // Utilisation du nom de l'agence pour plus de clarté
                name: agenceName,
                data: "Abonnement " + selectedPlanNamze,
                theme: "#166534"
            });

            addSuccessListener(function(response) {
                const transactionId = response.transactionId;
                fetch("{{ url('/api/abonnement/success') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            agent_id: agentId,
                            plan_id: selectedPlanId,
                            transaction_id: transactionId
                        })
                    })
                    .then(res => res.json())
                    .then(() => {
                        alert("Abonnement activé avec succès !");
                        window.location.href = "{{ route('dashboard') }}";
                    })
                    .catch(() => {
                        alert("Paiement effectué mais une erreur est survenue. Contactez le support.");
                    });
            });

            addFailedListener(function() {
                alert("Le paiement a échoué. Veuillez réessayer.");
            });
        }
    </script>
@endsection
