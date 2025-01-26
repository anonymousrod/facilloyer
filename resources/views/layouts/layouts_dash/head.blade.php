<head>
    {{-- head register --}}
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta content="FACILOYER" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->



    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }} " />

    <!-- App css -->
    <link href=" {{ asset('assets/css/bootstrap.min.css') }} " rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }} " rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }} " rel="stylesheet" type="text/css" />

    {{-- head login --}}
    {{-- <meta charset="utf-8" /> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" /> --}}
    {{-- <meta content="" name="author" /> --}}
    {{-- <meta http-equiv="X-UA-Compatible" content="IE=edge" /> --}}

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">


    <!-- App css -->
    {{-- <link href=" {{asset('assets/css/bootstrap.min.css')}} " rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{asset('assets/css/icons.min.css')}} " rel="stylesheet" type="text/css" /> --}}

    {{-- head dashboard --}}
    {{-- <meta charset="utf-8" /> --}}
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}
    {{-- <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" /> --}}
    {{-- <meta content="" name="author" /> --}}
    {{-- <meta http-equiv="X-UA-Compatible" content="IE=edge" /> --}}
    {{-- gestion de calandar script  --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }} ">



    <link rel="stylesheet" href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }} ">

    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }} " rel="stylesheet" type="text/css" />

    <title>@yield('title', 'Faciloyer')</title>

    {{-- c'est pour les tables --}}


    {{-- <meta charset="utf-8" /> --}}
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}
    {{-- <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" /> --}}
    {{-- <meta content="" name="author" /> --}}
    {{-- <meta http-equiv="X-UA-Compatible" content="IE=edge" /> --}}

    <!-- App favicon -->
    {{-- <link rel="shortcut icon" href="assets/images/favicon.ico"> --}}


    <link href="assets/libs/simple-datatables/style.css" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />

    {{-- autre template css --}}
    <!-- Custom Css -->
    {{-- <link rel="stylesheet" href=" {{ asset('assets/css/main.css') }}  ">
    <link rel="stylesheet" href=" {{ asset('assets/css/color_skins.css')}}  "> --}}

</head>
