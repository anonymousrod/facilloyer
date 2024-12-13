@extends('layouts.master_dash')
@section('title', 'Modifier le Profil')
@section('content')
<div class="container-xxl">
    <div class="row justify-content-center">
        <div class="col-12">
        <div class="page-wrapper">

<!-- Page Content-->
<!-- <div class="page-content"> -->
    <div class="container-xxl">
        <!-- la premiere bare avec le profil et tout ce qui est est haut  -->
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 align-self-center mb-3 mb-lg-0">
                                <div class="d-flex align-items-center flex-row flex-wrap">
                                    <div class="position-relative me-3">
                                        <img src="assets/images/users/avatar-7.jpg" alt="" height="120" class="rounded-circle">
                                        <a href="#" class="thumb-md justify-content-center d-flex align-items-center bg-primary text-white rounded-circle position-absolute end-0 bottom-0 border border-3 border-card-bg">
                                            <i class="fas fa-camera"></i>
                                        </a>
                                    </div>
                                    <div class="">
                                        <h5 class="fw-semibold fs-22 mb-1">Rosa Dodson</h5>                                                        
                                        <p class="mb-0 text-muted fw-medium">UI/UX Designer, USA</p>                                                        
                                    </div>
                                </div>                                                
                            </div><!--end col-->
                            
                            <div class="col-lg-4 ms-auto align-self-center">
                                <div class="d-flex justify-content-center">
                                    <div class="border-dashed rounded border-theme-color p-2 me-2 flex-grow-1 flex-basis-0">
                                        <h5 class="fw-semibold fs-22 mb-1">75</h5>
                                        <p class="text-muted mb-0 fw-medium">Projects</p>
                                    </div>
                                    <div class="border-dashed rounded border-theme-color p-2 me-2 flex-grow-1 flex-basis-0">
                                        <h5 class="fw-semibold fs-22 mb-1">68%</h5>
                                        <p class="text-muted mb-0 fw-medium">Success Rate</p>
                                    </div>
                                    <div class="border-dashed rounded border-theme-color p-2 me-2 flex-grow-1 flex-basis-0">
                                        <h5 class="fw-semibold fs-22 mb-1">$8620</h5>
                                        <p class="text-muted mb-0 fw-medium">Earning</p>
                                    </div>
                                </div>                                          
                            </div><!--end col-->
                            <div class="col-lg-4 align-self-center">
                                <div class="row row-cols-2">
                                    <div class="col text-end">
                                        <div id="complete" class="apex-charts"></div>
                                    </div>  
                                    <div class="col align-self-center">
                                        <button type="button" class="btn btn-primary  d-inline-block">Follow</button> 
                                        <button type="button" class="btn btn-light  d-inline-block">Hire Me</button>  
                                    </div>
                                </div>                                   
                            </div><!--end col-->
                        </div><!--end row-->               
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->                                  
        </div><!--end row-->

        <div class="row justify-content-center">

            <!-- section de la partie ou je veux mettre les infos de l'agence immo  -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">                      
                                <h4 class="card-title">Personal Information</h4>                      
                            </div><!--end col-->
                            <div class="col-auto">                      
                                <a href="#" class="float-end text-muted d-inline-flex text-decoration-underline"><i class="iconoir-edit-pencil fs-18 me-1"></i>Edit</a>                      
                            </div><!--end col-->
                        </div>  <!--end row-->                                  
                    </div><!--end card-header-->
                    <div class="card-body pt-0">
                        <p class="text-muted fw-medium mb-3">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                        <ul class="list-unstyled mb-0">                                        
                            <li class=""><i class="las la-birthday-cake me-2 text-secondary fs-22 align-middle"></i> <b> Birth Date </b> : 06 June 1989</li>
                            <li class="mt-2"><i class="las la-briefcase me-2 text-secondary fs-22 align-middle"></i> <b> Position </b> : Full Stack Developer</li>
                            <li class="mt-2"><i class="las la-university me-2 text-secondary fs-22 align-middle"></i> <b> Education </b> : Stanford Univercity</li>
                            <li class="mt-2"><i class="las la-language me-2 text-secondary fs-22 align-middle"></i> <b> Languages </b> : English, French, Spanish</li>
                            <li class="mt-2"><i class="las la-phone me-2 text-secondary fs-22 align-middle"></i> <b> Phone </b> : +91 23456 78910</li>
                            <li class="mt-2"><i class="las la-envelope text-secondary fs-22 align-middle me-2"></i> <b> Email </b> : mannat.theme@gmail.com</li>
                        </ul> 
                        <div class="row justify-content-center mt-4">
                            <div class="col-auto text-end border-end">
                                <span class="thumb-md justify-content-center d-flex align-items-center bg-blue text-white rounded-circle ms-auto mb-1">
                                    <i class="fab fa-facebook-f"></i>
                                </span>
                                <p class="mb-0 fw-semibold">Facebook</p>
                                <h4 class="m-0 fw-bold">25k <span class="text-muted fs-12 fw-normal">Followers</span></h4>
                            </div><!--end col-->
                            <div class="col-auto">
                                <span class="thumb-md justify-content-center d-flex align-items-center bg-black text-white rounded-circle mb-1">
                                    <i class="fab fa-x-twitter"></i>
                                </span>
                                <p class="mb-0 fw-semibold">Twitter</p>
                                <h4 class="m-0 fw-bold">58k <span class="text-muted fs-12 fw-normal">Followers</span></h4>
                            </div><!--end col-->
                        </div><!--end row-->       
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col--> 
            <div class="col-md-8">
                <ul class="nav nav-tabs mb-3" role="tablist">                                   
                    <li class="nav-item">
                        <a class="nav-link fw-medium" data-bs-toggle="tab" href="#settings" role="tab" aria-selected="true">Clik ici pour modifier ou completer vos informations</a>
                    </li>
                </ul>
                <!-- Section pour le formulaire de modification des donnée -->
                <div class="tab-content">                                               
                    <div class="tab-pane p-1" id="settings" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">                      
                                        <h4 class="card-title">Personal Information</h4>                      
                                    </div><!--end col-->                                                       
                                </div>  <!--end row-->                                  
                            </div><!--end card-header-->
                            @include('profile.partials.update-profile-information-form')
                                            
                        </div><!--end card-->

                        <!-- section pour modifier le password -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Change Password</h4>
                            </div><!--end card-header-->
                             @include('profile.partials.update-password-form')
                        </div><!--end card-->
                       
                    </div>
                </div> 
            </div> <!--end col-->                                                       
        </div><!--end row-->

                          
    </div><!-- container -->
    


    <!--end footer-->
</div>

@endsection
