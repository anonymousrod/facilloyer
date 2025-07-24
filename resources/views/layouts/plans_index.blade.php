@extends('layouts.master_dash')
@section('title', 'Mon profil')
@section('content')
    {{-- @if ($message)
        <div class="alert alert-warning text-center fade show" role="alert">
            <h5 class="text-warning mb-0">{{ $message }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif --}}
    <div class="container-xxl py-4">
        <div class="container">
            <h2 class="mb-4">Choisissez un Plan</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row">
                @foreach ($plans as $plan)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-header text-center font-weight-bold">
                                {{ $plan->nom }}
                            </div>
                            <div class="card-body">
                                <p><strong>Prix :</strong> {{ $plan->prix }} FCFA</p>
                                <p><strong>Durée :</strong> {{ $plan->duree }} jours</p>
                                <p>{{ $plan->description }}</p>
                            </div>
                            <div class="card-footer text-center">
                                <form action="{{ route('plans.subscribe', $plan->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-primary">Choisir ce plan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
