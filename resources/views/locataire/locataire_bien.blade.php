@extends('layouts.master_dash')
@section('title', 'BIEN ET CONTRAT DE BAIL')
@section('content')
    <div class="card shadow-sm mb-4 rounded-3 border-0">
        <div class="card-header bg-light py-3 border-bottom">
            <h4 class="mb-0 text-secondary">Biens Loués</h4>
        </div>
        <div class="card-body">
            @if ($biensLoues->isEmpty())
                <p class="text-muted">Aucun bien loué n'a été assigné.</p>
            @else
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Bien</th>
                            <th>Adresse</th>
                            <th>Loyer mensuel</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($biensLoues as $bien)
                            <tr>
                                <td>{{ $bien->name_bien }}</td>
                                <td>{{ \Illuminate\Support\Str::words($bien->adresse_bien, 1, '...') }}</td>
                                <td>{{ number_format($bien->loyer_mensuel, 2, ',', ' ') }} €</td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('biens.show', ['bien_id' => $bien->id, 'agent_id' => $locataire->agent_immobilier->id ?? null]) }}" class="btn btn-outline-primary">
                                        <span class="bi bi-info-circle-fill"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection