<section>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Informations du profil</h4>
        </div>
        <div class="card-body pt-0">
            <!-- Afficher les erreurs globales -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulaire -->
            <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('patch')

                <!-- Champ name (Nom) -->
                <!-- <div class="form-group mb-3 row">
                    <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label" for="name">Nom</label>
                    <div class="col-lg-9 col-xl-8">
                        <input class="form-control" id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name">
                    </div>
                </div> -->

                <!-- Champ email -->
                <div class="form-group mb-3 row">
                    <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label" for="email">Adresse Email</label>
                    <div class="col-lg-9 col-xl-8">
                        <div class="input-group">
                            <span class="input-group-text"><i class="las la-at"></i></span>
                            <input class="form-control" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="form-group row">
                    <div class="col-lg-9 col-xl-8 offset-lg-3">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        <button type="reset" class="btn btn-danger">{{ __('Cancel') }}</button>
                    </div>
                </div>

                <!-- Message de succès -->
                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-success">
                        {{ __('Saved.') }}
                    </p>
                @endif
            </form>
        </div>
    </div>
</section>
