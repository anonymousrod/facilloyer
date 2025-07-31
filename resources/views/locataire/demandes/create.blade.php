@extends('layouts.master_dash')

@section('content')
<div class="container py-5 animate-slide-in">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card custom-card border-0">
                <div class="card-header text-white text-center py-4 custom-header">
                    <h3 class="mb-0 fw-bold text-success">🛠 Créer une demande de maintenance</h3>
                </div>
                <div class="card-body p-4">

                    {{-- Erreurs de validation --}}
                    @if ($errors->any())
                        <div class="alert alert-danger shadow-sm">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Formulaire --}}
                    <form action="{{ route('locataire.demandes.store') }}" method="POST">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="bien_id" class="form-label fw-semibold">🏠 Bien occupé</label>
                            <select name="bien_id" id="bien_id" class="form-control custom-input" required>
                                <option value="">-- Choisir un bien --</option>
                                @foreach ($biens as $bien)
                                    <option value="{{ $bien->id }}" {{ old('bien_id') == $bien->id ? 'selected' : '' }}>
                                        {{ $bien->name_bien }} / {{ $bien->adresse_bien }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label for="description" class="form-label fw-semibold">📝 Description</label>
                            <textarea 
                                name="description" 
                                id="description" 
                                rows="4" 
                                class="form-control custom-input" 
                                placeholder="Décrivez la demande ici..." 
                                required>{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group mb-4">
                            <label for="statut" class="form-label fw-semibold">📌 Statut initial</label>
                            <select name="statut" id="statut" class="form-control custom-input" required>
                                <option value="en attente" {{ old('statut') == 'en attente' ? 'selected' : '' }}>En attente</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-outline-secondary custom-btn px-5 py-2 ">
                                📤 Envoyer
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Styles --}}

@endsection
