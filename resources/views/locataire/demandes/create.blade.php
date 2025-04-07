@extends('layouts.master_dash')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4 rounded-top">
                    <h3 class="card-title mb-0">Créer une demande de maintenance</h3>
                </div>
                <div class="card-body p-4">
                    <!-- Afficher les erreurs de validation -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Formulaire de demande de maintenance -->
                    <form action="{{ route('locataire.demandes.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="bien_id" class="form-label fw-bold">Sélectionner un bien actuellement occupé</label>
                            <select name="bien_id" id="bien_id" class="form-control shadow-sm rounded" required>
                                <option value="">Choisir un bien</option>
                                @foreach ($biens as $bien)
                                    <option value="{{ $bien->id }}" {{ old('bien_id') == $bien->id ? 'selected' : '' }}>
                                        {{ $bien->name_bien }} / {{ $bien->adresse_bien }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label for="description" class="form-label fw-bold">Description de la demande</label>
                            <textarea 
                                name="description" 
                                id="description" 
                                class="form-control shadow-sm rounded" 
                                rows="4" 
                                placeholder="Décrivez la demande de maintenance ici..." 
                                required>{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group mb-4">
                            <label for="statut" class="form-label fw-bold">Statut</label>
                            <select name="statut" id="statut" class="form-control shadow-sm rounded" required>
                                <option value="en attente" {{ old('statut') == 'en attente' ? 'selected' : '' }}>En attente</option>
                                <!-- <option value="en cours" {{ old('statut') == 'en cours' ? 'selected' : '' }}>En cours</option> -->
                                <!-- <option value="terminée" {{ old('statut') == 'terminée' ? 'selected' : '' }}>Terminé</option> -->
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5 py-2 shadow">
                                Envoyer la demande
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f5f5f5;
    }

    .card {
        background: linear-gradient(145deg, #ffffff, #e6e6e6);
        border-radius: 15px;
        box-shadow: 10px 10px 20px #d9d9d9, -10px -10px 20px #ffffff;
    }

    .card-header {
        box-shadow: inset 5px 5px 10px #c8c8c8, inset -5px -5px 10px #ffffff;
    }

    .form-control {
        border: none;
        box-shadow: inset 5px 5px 10px #d1d1d1, inset -5px -5px 10px #ffffff;
        transition: all 0.3s ease-in-out;
    }

    .form-control:focus {
        border: none;
        outline: none;
        box-shadow: inset 1px 1px 5px #d1d1d1, inset -1px -1px 5px #ffffff, 0 0 5px #1e88e5;
    }

    button {
        border: none;
        border-radius: 25px;
        box-shadow: 5px 5px 15px #d1d1d1, -5px -5px 15px #ffffff;
        transition: all 0.3s ease-in-out;
    }

    button:hover {
        box-shadow: 5px 5px 15px #b0b0b0, -5px -5px 15px #ffffff;
        background-color: #1565c0;
    }
</style>
@endsection
