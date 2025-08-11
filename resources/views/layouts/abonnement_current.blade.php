@extends('layouts.master_dash')
@section('title', 'Mon abonnement')


@section('content')
    <!-- Animate.css et FontAwesome déjà inclus dans le master -->
    <style>
        .abonnement-card {
            position: relative;
            /* background: #fff; */
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 rgba(40,167,69,0.10);
            border: none;
            overflow: hidden;
            margin-bottom: 2rem;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .abonnement-card:hover {
            box-shadow: 0 16px 40px 0 rgba(40,167,69,0.18);
            transform: translateY(-4px) scale(1.01);
        }
        .abonnement-ribbon {
            position: absolute;
            top: 0;
            right: 0;
            background: linear-gradient(90deg, #28a745 60%, #43e97b 100%);
            color: #fff;
            padding: 0.5rem 1.2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 0 0 0 18px;
            box-shadow: 0 2px 8px rgba(40,167,69,0.15);
            z-index: 2;
        }
        .abonnement-ribbon.expire {
            background: linear-gradient(90deg, #e11d48 60%, #f43f5e 100%);
        }
        .abonnement-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #28a745;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .abonnement-info {
            font-size: 1.08rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .abonnement-info i {
            color: #28a745;
        }
        .badge-abonnement {
            font-size: 1rem;
            padding: 0.4em 1em;
            border-radius: 1em;
            font-weight: 600;
        }
        .btn-abonnement {
            background: linear-gradient(90deg, #28a745 60%, #43e97b 100%);
            color: #fff;
            border: none;
            font-weight: 600;
            border-radius: 2em;
            padding: 0.7em 2em;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px rgba(40,167,69,0.10);
            transition: background 0.2s, box-shadow 0.2s;
        }
        .btn-abonnement:hover {
            background: linear-gradient(90deg, #218838 60%, #28a745 100%);
            box-shadow: 0 4px 16px rgba(40,167,69,0.18);
        }
        @media (max-width: 600px) {
            .abonnement-card { padding: 1.2rem 0.7rem 1.2rem 0.7rem; }
            .abonnement-title { font-size: 1.1rem; }
        }
    </style>
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card abonnement-card animate__animated animate__fadeInDown">
                    @if ($abonnement)
                        <div class="abonnement-ribbon animate__animated animate__fadeInRight">
                            {{ $abonnement->status === 'actif' ? 'Actif' : 'Expiré' }}
                        </div>
                        <div class="card-body animate__animated animate__fadeInUp">
                            <div class="abonnement-title mb-3">
                                <i class="fas fa-gem"></i>
                                {{ $abonnement->plan->nom }}
                            </div>
                            <div class="abonnement-info mb-0 text-truncate"><i class="fas fa-calendar-alt"></i> Début : {{ \Carbon\Carbon::parse($abonnement->date_debut)->format('d/m/Y') }}</div>
                            <div class="abonnement-info mb-0 text-truncate"><i class="fas fa-calendar-check"></i> Fin : {{ \Carbon\Carbon::parse($abonnement->date_fin)->format('d/m/Y') }}</div>
                            <div class="abonnement-info mb-0 text-truncate"><i class="fas fa-coins"></i> Montant : <span style="font-weight:600; color:#28a745;">{{ number_format($abonnement->plan->prix, 0, ',', ' ') }} FCFA</span></div>
                            <div class="abonnement-info mb-0 text-truncate"><i class="fas fa-info-circle"></i> Statut :
                                <span class="badge badge-abonnement {{ $abonnement->status === 'actif' ? 'bg-success' : 'bg-danger' }} ms-2">
                                    {{ $abonnement->status === 'actif' ? 'Actif' : 'Expiré' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                <a href="{{ route('plans_abonnement') }}" class="btn btn-abonnement shadow-sm">
                                    <i class="fas fa-sync-alt me-1"></i> Renouveler / Changer de plan
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="abonnement-ribbon expire animate__animated animate__fadeInRight">Aucun</div>
                        <div class="card-body animate__animated animate__fadeInUp text-center">
                            <div class="abonnement-title mb-3">
                                <i class="fas fa-gem" style="color:#e11d48;"></i>
                                Aucun abonnement actif
                            </div>
                            <div class="alert alert-warning text-center w-100 mb-3">
                                <i class="fas fa-exclamation-triangle me-2"></i> Aucun abonnement actif pour le moment.
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <a href="{{ route('plans.index') }}" class="btn btn-abonnement shadow-sm">
                                    <i class="fas fa-plus-circle me-1"></i> Souscrire à un plan
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
