<section>
<div class="container-xxl">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Mettre à jour le mot de passe</h4>
                </div>
                <div class="card-body pt-0">
                    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')

                        <div class="form-group mb-3 row">
                            <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label" for="update_password_current_password">Current Password</label>
                            <div class="col-lg-9 col-xl-8">
                                <input class="form-control" id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" placeholder="Password">
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label" for="update_password_password">New Password</label>
                            <div class="col-lg-9 col-xl-8">
                                <input class="form-control" id="update_password_password" name="password" type="password" autocomplete="new-password" placeholder="New Password">
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label" for="update_password_password_confirmation">Confirm Password</label>
                            <div class="col-lg-9 col-xl-8">
                                <input class="form-control" id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" placeholder="Re-Password">
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-9 col-xl-8 offset-lg-3">
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                <button type="button" class="btn btn-danger">{{ __('Cancel') }}</button>
                            </div>
                        </div>

                        @if (session('status') === 'password-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                                {{ __('Saved.') }}
                            </p>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</section>
