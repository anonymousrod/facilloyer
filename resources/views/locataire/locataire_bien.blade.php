@extends('layouts.master_dash')

@section('title', 'Biens et Contrat de Bail')

@section('content')

<div class="card shadow-lg mb-5 rounded-4 border-0 bg-glass" data-aos="fade-up">
    <div class="card-header py-4 border-bottom d-flex justify-content-between align-items-center">
        <h2 class="mb-0 fw-bold gradient-title fs-3">
            <i class="bi bi-house-door-fill me-2 text-success"></i> Vos biens loués
        </h2>
    </div>

    <div class="card-body">
        @if ($biensLoues->isEmpty())
            <div class="text-center py-5" data-aos="zoom-in">
                <i class="bi bi-exclamation-circle display-3 text-muted mb-3"></i>
                <p class="text-muted fs-5">Aucun bien loué n'a encore été assigné.</p>
            </div>
        @else
            {{-- Table Desktop --}}
            <div class="table-responsive d-none d-md-block" data-aos="fade-up">
                <table class="table align-middle table-hover shadow-sm rounded-4 overflow-hidden">
                    <thead class="table-light text-muted small text-uppercase">
                        <tr>
                            <th>Bien</th>
                            <th>Adresse</th>
                            <th>Loyer mensuel</th>
                            <th class="text-center">Contrat/Bien</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($biensLoues as $bien)
                            <tr>
                                <td class="fw-semibold">{{ $bien->name_bien }}</td>
                                <td>{{ \Illuminate\Support\Str::words($bien->adresse_bien, 3, '...') }}</td>
                                <td class="text-success fw-bold">
                                    {{ number_format($bien->loyer_mensuel, 2, ',', ' ') }} FCFA
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('biens.show', ['bien_id' => $bien->id, 'agent_id' => $locataire->agent_immobilier->id ?? null]) }}"
                                       class="btn btn-outline-success btn-sm px-3 py-1">
                                        <i class="bi bi-eye-fill me-1"></i> Contrat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Version --}}
            <div class="d-md-none">
                @foreach ($biensLoues as $bien)
                    <div class="card mb-3 shadow-sm rounded-3 p-3 bg-glass" data-aos="fade-up">
                        <p><strong>Bien :</strong> {{ $bien->name_bien }}</p>
                        <p><strong>Adresse :</strong> {{ \Illuminate\Support\Str::words($bien->adresse_bien, 3, '...') }}</p>
                        <p><strong>Loyer :</strong>
                            <span class="text-success fw-bold">{{ number_format($bien->loyer_mensuel, 2, ',', ' ') }} €</span>
                        </p>
                        <div class="text-end">
                            <a href="{{ route('biens.show', ['bien_id' => $bien->id, 'agent_id' => $locataire->agent_immobilier->id ?? null]) }}"
                               class="btn btn-outline-success btn-sm">
                                <i class="bi bi-eye-fill me-1"></i> Contrat
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection

