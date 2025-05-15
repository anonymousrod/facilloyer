<head>
    {{-- head register --}}
    <!-- Autres balises head... -->
    {{-- <script>
        // À placer ABSOLUMENT en premier dans le <head>
        (function() {
            // 1. Vérifie le thème stocké
            const savedTheme = localStorage.getItem('data-bs-theme');

            // 2. Applique IMMÉDIATEMENT le thème avant tout rendu
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute("data-bs-theme", "dark");
                document.head.insertAdjacentHTML('beforeend',
                    '<style>html:not([data-bs-theme="dark"]){visibility:hidden}</style>');
            }
        })();
    </script> --}}
    <script>
        // =============================================
        // SOLUTION COMPLÈTE POUR LE THÈME SOMBRE/CLAIR
        // =============================================

        // 1. APPLICATION IMMÉDIATE DU THÈME (ANTI-FLASH)
        (function() {
            'use strict';

            // Récupère le thème stocké ou utilise 'light' par défaut
            const savedTheme = localStorage.getItem('data-bs-theme') || 'light';

            // Applique immédiatement le thème au document
            document.documentElement.setAttribute('data-bs-theme', savedTheme);

            // Cache brièvement le contenu si mode sombre pour éviter le flash
            if (savedTheme === 'dark') {
                const antiFlashStyle = document.createElement('style');
                antiFlashStyle.textContent = 'html:not([data-bs-theme="dark"]){visibility:hidden}';
                document.head.appendChild(antiFlashStyle);

                // Supprime le style une fois le DOM chargé
                document.addEventListener('DOMContentLoaded', () => {
                    antiFlashStyle.remove();
                }, {
                    once: true
                });
            }
        })();
    </script>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta content="{{ config('app.name') }}" name="description" />
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

    {{-- <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }} "> --}}


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

    <title>@yield('title', config('app.name'))</title>

    {{-- c'est pour les tables --}}


    {{-- <meta charset="utf-8" /> --}}
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}
    {{-- <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" /> --}}
    {{-- <meta content="" name="author" /> --}}
    {{-- <meta http-equiv="X-UA-Compatible" content="IE=edge" /> --}}

    <!-- App favicon -->
    {{-- <link rel="shortcut icon" href="assets/images/favicon.ico"> --}}


    <link href=" {{ asset('assets/libs/simple-datatables/style.css') }} " rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href=" {{ asset('assets/css/bootstrap.min.css') }} " rel="stylesheet" type="text/css" />
    <link href=" {{ asset('assets/css/icons.min.css') }} " rel="stylesheet" type="text/css" />
    <link href=" {{ asset('assets/css/app.min.css') }} " rel="stylesheet" type="text/css" />

    {{-- autre template css --}}
    <!-- Custom Css -->
    {{-- <link rel="stylesheet" href=" {{ asset('assets/css/main.css') }}  ">
    <link rel="stylesheet" href=" {{ asset('assets/css/color_skins.css')}}  "> --}}

</head>
