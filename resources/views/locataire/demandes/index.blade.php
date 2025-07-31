@extends('layouts.master_dash')

@section('content')

<div class="container py-5">

  <!-- Titre + bouton -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <h2 class="fw-bold m-0">🔧 Maintenance & Suivi</h2>
    <a href="{{ route('locataire.demandes.create') }}" class="btn btn-primary">
      ➕ Nouvelle demande
    </a>
  </div>

  <!-- Filtres -->
  <div class="mb-4 d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
    <button class="btn btn-outline-secondary">🔄 Tout</button>
    <button class="btn btn-outline-warning">⏳ En attente</button>
    <button class="btn btn-outline-info">🔧 En cours</button>
    <button class="btn btn-outline-secondary">✔️ Terminée</button>
    
  </div>

  <!-- Contenu -->
  @if ($demandes->isEmpty())
    <div class="text-center text-muted py-5">
      💡 Aucune demande enregistrée.
    </div>
  @else
    <div class="row">
      @foreach ($demandes as $demande)
        @php
          $statut = strtolower($demande->statut);
          $couleur = match($statut) {
            'en attente' => 'warning',
            'en cours' => 'info',
            'validée', 'terminée' => 'success',
            default => 'secondary'
          };

          $icone = match($statut) {
            'en attente' => '⏳',
            'en cours' => '🔧',
            'validée' => '✅',
            'terminée' => '✔️',
            default => '❔'
          };
        @endphp

        <div class="col-12 col-sm-6 col-md-4 mb-4">
          <div class="card shadow-sm rounded-4 h-100 border-0">
            <div class="card-body d-flex flex-column">
              <h5 class="fw-bold mb-2">
                🏠 Bien : {{ $demande->bien->name_bien }}
              </h5>
              <p class="text-muted mb-3">
                {{ $demande->description }}
              </p>
              <div class="mt-auto d-flex justify-content-between align-items-center">
                <span class="badge bg-{{ $couleur }} rounded-pill">
                  {{ $icone }} {{ ucfirst($demande->statut) }}
                </span>
                
              </div>
            </div>
          </div>
        </div>

      @endforeach
    </div>
  @endif

</div>

@endsection
