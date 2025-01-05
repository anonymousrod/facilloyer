@extends('layouts.master_dash')

@section('content')
<style>
        /* Container pour le formulaire */
.container {
    background-color: #fff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    max-width: 900px;
    margin-top: 50px;
}

/* Titre du formulaire */
h1 {
    font-size: 28px;
    font-weight: 600;
    color: #333;
    margin-bottom: 30px;
    text-transform: uppercase;
    letter-spacing: 2px;
}

/* Styles des champs de formulaire */
.form-group {
    margin-bottom: 20px;
}

.form-label {
    font-size: 16px;
    font-weight: 500;
    color: #333;
    margin-bottom: 8px;
    display: block;
    text-transform: uppercase;
}

/* Champs de texte et textarea */
.form-control {
    border-radius: 12px;
    padding: 15px;
    border: 2px solid #ddd;
    font-size: 16px;
    font-weight: 400;
    width: 100%;
    background-color: #f7f9fc;
    color: #444;
    transition: all 0.3s ease;
}



/* Message d'erreur */
.invalid-feedback {
    color: #e74c3c;
    font-size: 14px;
    margin-top: 8px;
}

/* Bouton de soumission */
.btn-primary {
    background-color: #6c63ff;
    border: none;
    color: #fff;
    font-size: 18px;
    font-weight: 600;
    padding: 15px 30px;
    border-radius: 50px;
    width: 100%;
    text-transform: uppercase;
    letter-spacing: 2px;
    transition: background-color 0.3s ease;
}

/* Effet hover sur le bouton */
.btn-primary:hover {
    background-color: #5a52cc;
}

/* Style pour le bouton d'icône uniquement */
.btn-lg {
    font-size: 20px;
    padding: 10px 20px;
    border-radius: 50%;
}

/* Animation pour l'apparition du formulaire */
@keyframes fadeInForm {
    0% { opacity: 0; transform: translateY(50px); }
    100% { opacity: 1; transform: translateY(0); }
}

.container {
    animation: fadeInForm 1s ease-out forwards;
}

/* Responsivité mobile */
@media (max-width: 768px) {
    .container {
        padding: 20px;
        margin-top: 30px;
    }

    h1 {
        font-size: 24px;
        text-align: center;
    }

    .btn-primary {
        font-size: 16px;
        padding: 12px 24px;
    }

    .form-control {
        font-size: 14px;
        padding: 12px;
    }

    .form-label {
        font-size: 14px;
    }
}

</style>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Demande maintenance</h1>

    <!-- Formulaire pour soumettre une demande -->
    <form action="{{ route('demandes.store') }}" method="POST">
        @csrf

        <!-- Libellé -->
        <div class="form-group mb-4">
            <label for="libelle" class="form-label">Libellé</label>
            <input 
                type="text" 
                id="libelle" 
                name="libelle" 
                class="form-control @error('libelle') is-invalid @enderror" 
                placeholder="Entrez un libellé (ex: Fuite d'eau dans la salle de bain)" 
                value="{{ old('libelle') }}" 
                required
            >
            @error('libelle')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Description -->
        <div class="form-group mb-4">
            <label for="description" class="form-label">Description</label>
            <textarea 
                id="description" 
                name="description" 
                rows="5" 
                class="form-control @error('description') is-invalid @enderror" 
                placeholder="Décrivez le problème en détail..." 
                required
            >{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Bouton de soumission -->
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary btn-lg">
                Soumettre la demande
            </button>
        </div>
    </form>
</div>
@endsection
