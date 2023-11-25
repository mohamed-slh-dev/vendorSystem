@extends('layouts.app')

@section('title', 'الرئيسية')

@section('content')
    
<div class="row">

     <!-- Top Report Start -->
     <div class="col-xlg-3 col-md-6 col-12 mb-30">
        <div class="top-report">

            <!-- Head -->
            <div class="head">
                <h4>الإرساليات </h4>
                <a href="#" class="view text-primary"><i class="fa fa-tasks"></i></a>
            </div>

            <!-- Content -->
            <div class="content">
                <h5>  عدد  الإرساليات الكلي</h5>
                <h2> {{$shipments->count()}}  </h2>
            </div>

            <!-- Footer -->
            <div class="footer">
                <div class="progess">
                    <div class="progess-bar" style="width: 92%;"></div>
                </div>
            </div>

        </div>
    </div><!-- Top Report End -->

     <!-- Top Report Start -->
     <div class="col-xlg-3 col-md-6 col-12 mb-30">
        <div class="top-report">

            <!-- Head -->
            <div class="head">
                <h4> المبيعات اليومية </h4>
                <a href="#" class="view text-danger"><i class="fa fa-sticky-note"></i></a>
            </div>

            <!-- Content -->
            <div class="content">
                <h5>عدد المبيعات اليومية الكلي</h5>
                <h2> {{$daily_sells->count()}} </h2>
            </div>

            <!-- Footer -->
            <div class="footer">
                <div class="progess">
                    <div class="progess-bar" style="width: 92%;"></div>
                </div>
            </div>

        </div>
    </div><!-- Top Report End -->



    @if (session()->get('user_id') == 1)


    <!-- Top Report Start -->
    <div class="col-xlg-3 col-md-6 col-12 mb-30">
        <div class="top-report">

            <!-- Head -->
            <div class="head">
                <h4 class="text-success">  له </h4>
                <a href="#" class="view text-success"><i class="zmdi zmdi-arrow-right-top"></i></a>
            </div>

            <!-- Content -->
            <div class="content">

                <h2 class=" text-success"> {{$income}} <small>SAR</small></h2>
          
            </div>

            <!-- Footer -->
            <div class="footer">
                <div class="progess">
                    <div class="progess-bar" style="width: 100%;"></div>
                </div>
            </div>

        </div>
    </div><!-- Top Report End -->


     <!-- Top Report Start -->
     <div class="col-xlg-3 col-md-6 col-12 mb-30">
        <div class="top-report">

            <!-- Head -->
            <div class="head">
                <h4 class="text-danger"> عليه</h4>
                <a href="#" class="view text-danger"><i class="zmdi zmdi-arrow-left-bottom"></i></a>
            </div>

            <!-- Content -->
            <div class="content">
               
                <h2 class=" text-danger"> {{$outcome}} <small>SAR</small></h2>
                
            </div>

            <!-- Footer -->
            <div class="footer">
                <div class="progess">
                    <div class="progess-bar"  style="width: 100%; background : linear-gradient(to right, #db1010 0%, #ee8787 100%)"></div>
                </div>
            </div>


            

        </div>
    </div><!-- Top Report End -->


    
     <!-- Top Report Start -->
     <div class=" col-md-12 col-12 mb-30">
        <div class="top-report">

            <!-- Head -->
            <div class="head">
                <h4 class="text-primary"> المجموع</h4>
                <a href="#" class="view text-primary"><i class="zmdi zmdi-check"></i></a>
            </div>

            <!-- Content -->
            <div class="content">
                 
                <h2 class=" text-primary"> {{$outcome - $income}} <small>SAR</small></h2>
             
            </div>

            <!-- Footer -->
            <div class="footer">
                <div class="progess">
                    <div class="progess-bar"  style="width: 100%; background : linear-gradient(to right, #1080db 0%, #87d9ee 100%)"></div>
                </div>
            </div>

        </div>
    </div><!-- Top Report End -->


    @else


    @endif

     
</div>
@endsection