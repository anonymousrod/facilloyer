{{-- <form method="POST" action="{{ route('passwordChangeFormSave') }}">
    @csrf --}}
{{--
    <div class="form-group">
        <label for="password">Nouveau mot de passe</label>
        <input type="password" name="password" id="password" class="form-control" required minlength="8">
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirmer le mot de passe</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required
            minlength="8">
    </div>

    <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
</form>

<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light"> --}}


<!-- Mirrored from mannatthemes.com/rizz/default/auth-recover-pw.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Nov 2024 21:52:10 GMT -->

<head>


    <meta charset="utf-8" />
    <title>Rizz | Rizz - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">


    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />

</head>


<!-- Top Bar Start -->

<body>
    <div class="container-xxl">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mx-auto">
                            <div class="card">
                                <div class="card-body p-0 bg-black auth-header-box rounded-top">
                                    <div class="text-center p-3">
                                        <a href="index.html" class="logo logo-admin">
                                            <img src="assets/images/logo-sm.png" height="50" alt="logo"
                                                class="auth-logo">
                                        </a>
                                        <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Changer mot de passe</h4>
                                        <p class="text-muted fw-medium mb-0">Entrer votre nouveau mot de passe</p>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <form class="my-4" method="POST" action="{{ route('passwordChangeFormSave') }}">
                                        @csrf
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="username">Nouveau mot de passe</label>
                                            <input type="password" name="password" id="password" class="form-control"
                                                required minlength="8">

                                            {{-- <input type="text" class="form-control" id="userEmail" name="Email"
                                                placeholder="Enter Email Address"> --}}
                                        </div><!--end form-group-->

                                        <div class="form-group mb-2">
                                            <label for="password_confirmation">Confirmer le mot de passe</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required
                                                minlength="8">
                                        </div>

                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid mt-3">
                                                    <button class="btn btn-primary" type="submit">Changer le mot de passe <i
                                                            class="fas fa-sign-in-alt ms-1"></i></button>
                                                </div>
                                            </div><!--end col-->
                                        </div> <!--end form-group-->
                                    </form><!--end form-->

                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-body-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!-- container -->
</body>
<!--end body-->

<!-- Mirrored from mannatthemes.com/rizz/default/auth-recover-pw.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Nov 2024 21:52:10 GMT -->

</html>
