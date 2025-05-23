@extends('layouts.master_dash')

@section('content')
<div class="container py-5 animate-slide-in">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card custom-card border-0">
                <div class="card-header text-white text-center py-4 custom-header">
                    <h3 class="mb-0">🛠 Créer une demande de maintenance</h3>
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
                            <button type="submit" class="btn custom-btn px-5 py-2">
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
<style>
    :root {
        --green-main: #012B1B;
        --green-accent: #01875f;
        --gray-light: #f3f6f9;
        --gray-dark: #222;
        --white: #ffffff;
    }

    body {
        background: var(--gray-light);
    }

    .animate-slide-in {
        animation: slideIn 0.6s ease forwards;
    }

    @keyframes slideIn {
        from {
            transform: translateX(-60px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .custom-card {
        background: linear-gradient(135deg, #ffffff, #e7f1ed);
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .custom-header {
        background: linear-gradient(135deg, var(--green-main), var(--green-accent));
        border-radius: 20px 20px 0 0;
        box-shadow: inset 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .custom-input {
        border: none;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        background-color: #f9f9f9;
        box-shadow: inset 2px 2px 6px rgba(0,0,0,0.05), inset -2px -2px 6px rgba(255,255,255,0.8);
        transition: all 0.2s ease-in-out;
    }

    .custom-input:focus {
        background-color: #ffffff;
        box-shadow: 0 0 0 2px var(--green-accent), inset 1px 1px 5px rgba(0,0,0,0.1);
        outline: none;
    }

    .custom-btn {
        background-color: var(--green-main);
        color: var(--white);
        border-radius: 30px;
        font-weight: bold;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .custom-btn:hover {
        background-color: var(--green-accent);
        transform: scale(1.03);
    }

    .alert ul {
        padding-left: 20px;
    }

    @media screen and (max-width: 576px) {
        .custom-card {
            padding: 1rem;
        }
    }
    
</style>
@endsection
