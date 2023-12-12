<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>تقرير منصرفات الشحنات  -  {{$filter}}</title>
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

@php
    $sum = 0;
@endphp
<body dir="rtl">


<div class="col-lg-10 mx-auto" id="partnerreportdiv">
    <div class="card ">
        <div class="card-body invoice-head pt-0"> 
            <div class="row">
                <div class="col-12 text-center printimagediv">                                                
                   <h3>نظام المبيعات المخصص (مالك علي)</h3>                                          
                </div>
            </div>
            <div class="row p-3" style="border: 1px solid #b9b9b9;" >
               
              
                <div class="col-sm-3 text-center">
                    <span id="left-header">تقرير منصرفات الشحنات  <br> {{$filter}} </span>
                </div>
                <div class="col-sm-6 text-center mt-2">
                        
                    <h4> <span id="title-header ">تقرير منصرفات الشحنات </span>  </h4>
              
                </div>
                <div class="col-sm-3 text-center" id="p-date">
                    <span id="print-date">تاريخ الطباعة : {{date('Y/m/d')}}</span>
                </div>
            </div> 
          
        </div><!--end card-body-->

        <div class="row" id="btnss">

            <div class="col-sm-12 text-center">

                <button id="print-btn" class="btn btn-dark">
                   <i class="fa fa-print mx-1"></i> طباعة
                </button>

            </div>

        </div>

        <div class="card-body ">
   
            <hr>

            <div class="row">
                
                @foreach ($shipments as $shipment)
                    
              
                <div class="col-12 mb-30">
                    <div class="box">
                        <div class="box-head">
                            <h4 class="title"> منصرفات الشحنة - ({{$shipment->number}})</h4>
                            <h5> تاريخ الشحنة - ({{$shipment->date}}) </h5>
                        </div>
                        <div>
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th></th>
                                        <th>الشحن</th>
                                        <th>التخليص</th>
                                        <th>منصرفات الأردن</th>

                                        <th>منصرفات اخرى </th>

                                        <th style="width: 200px"> التفاصيل</th>
        
                                        <th> تاريخ الإضافة</th>
                
        
                                    </tr>
                                </thead>

                                @php
                                    $sum = 0;
                                @endphp

                                <tbody>

                                   
        
                                    @foreach ($shipment->otherTransactions as $exp)

                                    @php
                                        $sum += $exp->customs_price;
                                        $sum += $exp->others_price;
                                        $sum += $exp->delivery_price;
                                        $sum += $exp->jordan_price;


                                    @endphp
                                  
                                    <tr >
                                        <td style="width: 1%"></td>

                                        <td style="width: 5%"> {{ number_format($exp->delivery_price , 2, '.', ',')}} </td>

                                        <td style="width: 5%"> {{ number_format($exp->customs_price , 2, '.', ',')}} </td>

                                        <td style="width: 5%"> {{ number_format($exp->jordan_price , 2, '.', ',')}} </td>

                                        <td style="width: 5%"> {{ number_format($exp->others_price , 2, '.', ',')}}</td>
                                        
                                        <td style="width: 200px">{{$exp->desc}}</td>
                                        <td style="width: 10%">{{$exp->created_at}}</td>
                                       
                                    </tr>

                                    @endforeach

                                    <tr>
                                        <td style="font-weight : bold">المجموع</td>
                                        <td></td>
                                        <td style="font-weight : bold">
                                            @php
                                                echo  number_format($sum , 2, '.', ',')  ;
                                            @endphp
                                        </td>
                                        <td></td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @endforeach
                
          
            </div>

         
        </div>
    </div><!--end card-->
</div><!--end col-->


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

        $('#print-btn').click(function() {

        var div = document.getElementById('btnss');
            div.style.visibility = "hidden";
            div.style.display = "none";   

        var p = document.getElementById('partnerreportdiv');
        print(p);

        window.location.href = '/exp-report'; 

        });

    </script>

</body>
