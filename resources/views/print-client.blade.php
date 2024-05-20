<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>كشف الحساب  -  {{$client->name}}</title>
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


                <div class="col-sm-2">
                    <span id="left-header">#</span>
                </div>
                <div class="col-sm-8 text-center mt-2">

                    <h4> <span id="title-header ">كشف الحساب  </h4>

                </div>
                <div class="col-sm-2" id="p-date">
                    <span id="print-date">تاريخ الطباعة : {{date('Y/m/d')}}</span>
                </div>



            </div>

        </div><!--end card-body-->

        <div class="row" id="btnss">

            <div class="col-sm-12 text-center">

                <button id="print-btn" class="btn btn-dark">
                    <i class="fa fa-print mx-1"></i>  طباعة
                </button>

            </div>

        </div>


        <div class="card-body ">

            <hr>

            <div class="row">



                <div class="col-12 mb-30">
                    <div class="box">
                        <div class="box-head text-center">
                            <h4 class="title"> كشف الحساب -  <span>{{$client->name}}</span> </h4>
                        </div>
                        <div>
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>

                                        <th>تاريخ العملية</th>
                                        <th>التفاصيل</th>
                                        <th>عليه</th>
                                        <th>له</th>
                                        <th>الرصيد</th>

                                    </tr>
                                </thead>



                                <tbody>

                                   @php
                                       $sum_income = 0;
                                       $sum_outcome = 0;
                                       $dynamic_total = 0;
                                   @endphp

                                @foreach ($client->transactions->sortBy('date') as $trans)

                                @if ($trans->type == 'عليه')

                                    @php

                                        $sum_outcome += $trans->price;
                                        $dynamic_total += $trans->price;

                                    @endphp

                                @else

                                    @php

                                        $dynamic_total -= $trans->price;
                                        $sum_income += $trans->price;

                                    @endphp

                                @endif


                                    <tr >
                                        <td style="width: 25%">
                                            <h4>{{$trans->date}}</h4>

                                        </td>



                                        <td style="width: 25%">
                                            <h4>{{$trans->desc}}</h4>
                                        </td>


                                            @if ($trans->type ==  'عليه')

                                            <td style="width: 25%">
                                                <h4>
                                                    {{ number_format($trans->price , 2, '.', ',')}}
                                                </h4>

                                            </td>

                                            <td></td>
                                            @else
                                            <td></td>
                                            <td style="width: 25%">
                                                <h4>
                                                    {{ number_format($trans->price , 2, '.', ',')}}
                                                </h4>

                                            </td>
                                            @endif


                                        <td style="width: 25%">
                                            <h4>
                                                {{ number_format($dynamic_total , 2, '.', ',')}}
                                            </h4>

                                        </td>



                                    </tr>

                                    @endforeach



                                    <tr style="border-top: solid black;">
                                        <td style="font-weight : bold">إجمالي العمليات</td>
                                        <td></td>
                                        <td style="font-weight : bold">
                                            <h4>
                                                 @php
                                                echo   number_format($sum_outcome , 2, '.', ',') ;
                                                @endphp
                                            </h4>

                                        </td>

                                        <td style="font-weight : bold">
                                            <h4>
                                                 @php
                                                echo  number_format($sum_income , 2, '.', ',') ;
                                                @endphp
                                            </h4>

                                        </td>
                                        <td></td>

                                    </tr>

                                    <tr>
                                        <td style="font-weight : bold">الإجمالي </td>
                                        <td></td>
                                        <td>

                                        </td>

                                        <td></td>

                                             <td style="font-weight : bold">
                                                <h4>
                                                    {{ number_format($client->total , 2, '.', ',')}}

                                                </h4>
                                             </td>



                                    </tr>



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



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

            window.location.href = '/transactions';

        });


    </script>

</body>
