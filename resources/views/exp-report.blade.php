@extends('layouts.app')

@section('title', 'تقارير المنصرفات')

@section('content')


<div class="row">

        <div class="col-sm-6 mb-4">

            <form class="row" action="{{route('expensesReport')}}" method="POST">

                @csrf

                <input type="hidden" name="type" value="by_date" id="">

                <div class="col-sm-12 mb-3 text-center">
                    <h4>ابحث بالتاريخ</h4>
                </div>
            
                <div class="col-sm-2"></div>

                <div class="col-sm-8 mb-3 text-center">
                    <input type="date" required  name="date_from" class="form-control mb-4" id="">
                    
                    <input type="date" required  name="date_to" class="form-control" id="">

                </div>

                <div class="col-sm-2"></div>
            
            
                <div class="col-sm-12 mb-4 text-center">
                <button class="btn btn-success">بحث</button>
                </div>

            </form>
        </div>


        <div class="col-sm-6 mb-4">

            <form class="row"  action="{{route('expensesReport')}}" method="POST">

                @csrf

                <input type="hidden" name="type" value="by_number" id="">

                <div class="col-sm-12 mb-3 text-center">
                    <h4>ابحث برقم الشحنة</h4>
                </div>
            
                <div class="col-sm-2"></div>

                <div class="col-sm-8 mb-3 text-center">
                    <input type="number" required min="0"  name="number_from" class="form-control mb-4" id="">
                    
                    <input type="number" required min="0"  name="number_to" class="form-control" id="">

                </div>

                <div class="col-sm-2"></div>
            
            
                <div class="col-sm-12 mb-4 text-center">
                <button class="btn btn-success">بحث</button>
                </div>

            </form>
        </div>

</div>


@endsection