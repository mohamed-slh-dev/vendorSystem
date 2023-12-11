
@if (empty(session('name')))     
<script>
    window.location.href = '/'; //login route           
</script>
@endif

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>نظام ادارة المبيعات</title>
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


        <!-- Header Section Start -->
        <div class="header-section">
            <div class="container-fluid">
                <div class="row justify-content-between align-items-center">

                    <!-- Header Logo (Header Left) Start -->
                    <div class="header-logo col-auto">
                        <a href="{{route('dashboard')}}">
                            <h3 class="text-bold"> نظام المبيعات المخصص</h3>
                          
                        </a>
                    </div><!-- Header Logo (Header Left) End -->

                    <!-- Header Right Start -->
                    <div class="header-right flex-grow-1 col-auto">
                        <div class="row justify-content-between align-items-center">

                            <!-- Side Header Toggle & Search Start -->
                            <div class="col-auto">
                                <div class="row align-items-center">

                                    <!--Side Header Toggle-->
                                    <div class="col-auto"><button class="side-header-toggle"><i class="zmdi zmdi-menu"></i></button></div>

                                   

                                </div>
                            </div><!-- Side Header Toggle & Search End -->

                            <!-- Header Notifications Area Start -->
                            <div class="col-auto">

                                <ul class="header-notification-area">
                                    <!--User-->
                                    <li class="adomx-dropdown col-auto">
                                        <a class="toggle" href="#">
                                            <span class="user">
                                        <span class="avatar">
                                            <img src="assets/images/avatar/avatar-1.jpg" alt="">
                                            <span class="status"></span>
                                            </span>
                                            <span class="name"> {{session()->get('name')}} </span>
                                            </span>
                                        </a>

                                        <!-- Dropdown -->
                                        <div class="adomx-dropdown-menu dropdown-menu-user">
                                            <div class="head">
                                                <h5 class="name"><a href="#"> {{session()->get('name')}} </a></h5>
                                                <a class="mail" href="#">{{session()->get('username')}}</a>
                                            </div>
                                            <div class="body">
                                                <ul>
                                                    
                                                    <li><a href="{{route('logout')}}"><i class="zmdi zmdi-lock-open"></i>تسجيل الخروج</a></li>
                                                </ul>
                                               
                                            </div>
                                        </div>

                                    </li>

                                </ul>

                            </div><!-- Header Notifications Area End -->

                        </div>
                    </div><!-- Header Right End -->

                </div>
            </div>
        </div><!-- Header Section End -->
        <!-- Side Header Start -->
        <div class="side-header show">
            <button class="side-header-close"><i class="zmdi zmdi-close"></i></button>
            <!-- Side Header Inner Start -->
            <div class="side-header-inner custom-scroll">

                <nav class="side-header-menu" id="side-header-menu">
                    <ul>

                        @if (session()->get('user_id') == 1)
                           
                        <li><a href="{{route('dashboard')}}"><i class="ti-home"></i> <span>الرئيسية</span></a></li>

                        <li><a href="{{route('products')}}"><i class="fa fa-cubes"></i> <span>البيان</span></a></li>

                        <li><a href="{{route('shipments')}}"><i class="fa fa-tasks"></i> <span>الإرساليات</span></a></li>

                        {{-- <li><a href="{{route('notes')}}"><i class="fa fa-sticky-note"></i> <span>دفتر الملاحظات</span></a></li> --}}

                        <li><a href="{{route('dailySells')}}"><i class="fa fa-sticky-note"></i> <span> المبيعات اليومية</span></a></li>

                         <li><a href="{{route('dailyShorts')}}"><i class="fa fa-ban"></i> <span> نواقص المبيعات اليومية</span></a></li>

                         <li><a href="{{route('expReport')}}"><i class="fa fa-file-pdf-o"></i> <span>تقارير المنصرفات </span></a></li>


                        <li><a href="{{route('currency')}}"><i class="fa fa-usd"></i> <span>العملة</span></a></li>


                        <li><a href="{{route('users')}}"><i class="fa fa-users"></i> <span>المستخدمين</span></a></li>

                        <hr style="display: flex; width:100%; border: 1px solid">

                        
                        <li><a href="{{route('transactions')}}"><i class="fa fa-exchange"></i> <span>العهد</span></a></li>

                        @else
                            
                        
                        <li><a href="{{route('shipments')}}"><i class="fa fa-tasks"></i> <span>الإرساليات</span></a></li>

                        {{-- <li><a href="{{route('notes')}}"><i class="fa fa-sticky-note"></i> <span>دفتر الملاحظات</span></a></li> --}}

                        <li><a href="{{route('dailySells')}}"><i class="fa fa-sticky-note"></i> <span> المبيعات اليومية</span></a></li>

                        
                        @endif
                       

                      


                    </ul>
                </nav>

            </div><!-- Side Header Inner End -->
        </div><!-- Side Header End -->

        <!-- Content Body Start -->
        <div class="content-body">

            <!-- Page Headings Start -->
            <div class="row justify-content-between align-items-center mb-10">

               
                <!-- Page Heading Start -->
                <div class="col-12 col-lg-auto mb-20">
                    <div class="page-heading">
                        <h3 class="title"> @yield('title')</h3>
                    </div>
                </div><!-- Page Heading End -->

            </div><!-- Page Headings End -->

            @include('alerts.alerts')
            
            @yield('content')

        </div><!-- Content Body End -->

        <!-- Footer Section Start -->
        <div class="footer-section">
            <div class="container-fluid">

                <div class="footer-copyright text-center">
                    <p class="text-body-light">2023 &copy; <a href="#">Developed by Mohamed Salah</a></p>
                </div>

            </div>
        </div><!-- Footer Section End -->

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

   
    <script>

        $('.fraction-commas').keyup(function() {
    
    
        //get the id number of button || remove all non=numeric things
        var value = $(this).val();
        value = value.replace(/\D/g,'');
    
        // put commas back again
        var commas = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    
    
        //copy the new val
        $(this).val(commas);
    
        });
    
    </script>
    

    @yield('scripts')

</body>

</html>