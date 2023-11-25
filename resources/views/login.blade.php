<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>نظام ادارة المبيعات | تسجيل الدخول</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="نظام ادارة المبيعات (مالك علي)">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.ico')}}"> --}}

    <!-- CSS
	============================================ -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/vendor/bootstrap.min.css')}}">

    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="assets/css/vendor/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/vendor/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/vendor/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/vendor/cryptocurrency-icons.css')}}">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/plugins/plugins.css')}}">

    <!-- Helper CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/helper.css')}}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    {{-- my custome style --}}
    <link rel="stylesheet" href="{{asset('assets/css/my-style.css')}}">

</head>

<body dir="rtl">

    <div class="main-wrapper">

        <!-- Content Body Start -->
        <div class="content-body m-0 p-0">

            <div class="login-register-wrap" style="background: #7ec4dc">

                
                <div class="row">

                    <div class="d-flex align-self-center justify-content-center order-2 order-lg-1 col-lg-5 col-12">
                        <div class="login-register-form-wrap">

                            <div class="content">
                                <h1>تسجيل الدخول</h1>
                                <p>ادخل اسم المستخدم و كلمة السر الخاصة بك</p>
                            </div>

                            <div class="login-register-form">

                                
                            @if ($message = Session::get('warning'))

                            <div class="alert alert-dark bg-white text-danger" role="alert">
                               
                                <button class="close text-danger" data-dismiss="alert"><i class="zmdi zmdi-close"></i></button>

                                <strong>{{$message}}</strong> 
                            </div>
                        
                            @endif

                                <form action=" {{route('checkLogin')}} " method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-12 mb-20"><input class="form-control" type="text" placeholder="اسم المستخدم" name="username"></div>
                                        <div class="col-12 mb-20"><input class="form-control" type="password" placeholder="كلمة المرور" name="password"></div>
                                     
                                       
                                        <div class="col-12 mt-10"><button class="button button-dark button-outline">تسجيل الدخول </button></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="login-register-bg order-1 order-lg-2 col-lg-7 col-12">
                        <div class="content">
                            <h1>تسجيل الدخول</h1>
                            <p>ادخل اسم المستخدم و كلمة السر الخاصة بك</p>

                        </div>
                    </div>

                </div>
            </div>

        </div><!-- Content Body End -->

    </div>

    <!-- JS
============================================ -->

 <!-- Global Vendor, plugins & Activation JS -->
 <script src="{{asset('assets/js/vendor/modernizr-3.6.0.min.js')}}"></script>
 <script src="{{asset('assets/js/vendor/jquery-3.3.1.min.js')}}"></script>
 <script src="{{asset('assets/js/vendor/popper.min.js')}}"></script>
 <script src="{{asset('assets/js/vendor/bootstrap.min.js')}}"></script>
 <!--Plugins JS-->
 <script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
 <script src="{{asset('assets/js/plugins/tippy4.min.js.js')}}"></script>
 <!--Main JS-->
 <script src="{{asset('assets/js/main.js')}}"></script>

</body>

</html>