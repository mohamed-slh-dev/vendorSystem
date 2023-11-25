@extends('layouts.app')

@section('title', 'المبيعات اليومية')

@section('content')


<div class="row">


    <div class="col-12 mb-4">
        <form class="row" action="{{route('searchDailyValue')}}" method="POST">

            @csrf
            <div class="col-sm-12 mb-3 text-center">
                <h4>ابحث بالتاريخ</h4>
            </div>
        
            <div class="col-sm-5"></div>

            <div class="col-sm-2 mb-3 text-center">
                <input type="date" required  name="date_from" class="form-control mb-4" id="">
                
                <input type="date" required  name="date_to" class="form-control" id="">

            </div>

            <div class="col-sm-5"></div>
        
        
            <div class="col-sm-12 mb-4 text-center">
               <button class="btn btn-success">بحث</button>
            </div>

        </form>
    </div>
  

    @foreach ($daily_sells as $daily)
        
   
    <div class="col-12">
        <hr>
    </div>

        <!--Table Head Dark Start-->
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head row">

                    <div class="col-sm-4">
                         <h4 class="title">جدول المبيعات اليومية </h4>
                         <h4> {{$daily->client}} -  {{$daily->date}} </h4>
                    </div>

                    <div class="col sm-4">

                        <button class="btn button-warning" data-toggle="modal" data-target="#edit-daily-{{$daily->id}}"> تعديل المبيعات </button>


                    </div>


                    <div class="col sm-4">
                        
                        <button class="btn button-primary" data-toggle="modal" data-target="#add-to-daily-{{$daily->id}}">اضافة مبيعات لليومية </button>

                    </div>

                   
                </div>
                <div style="overflow-x: auto">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>

                                <th> رقم الشحنة </th>

                                <th> البيان</th>

                                <th> الكمية</th>
                                <th> التالف</th>
                                <th> المبيعات</th>
                                <th> التفاصيل</th>
                               


                            </tr>
                        </thead>
                        <tbody>

                            
                           
                            @foreach ($daily->dailySellItmes->sortBy('product_id')->groupBy('product_id') as $product => $item)
                                @php
                                     $i = 0;
                                    $sum_quantity = 0;
                                    $sum_damaged = 0;

                                    $sum_sells = 0;

                                    $desc = '';

                                @endphp

                                @foreach ($item as $it)
                                    
                                @php
                                $sum_quantity += $item[$i]['quantity'];

                                $sum_damaged += $item[$i]['sum_damaged'];

                                $sum_sells += $item[$i]['quantity'] * $item[$i]['price'];

                                $desc .= '-    من الشحنة رقم  ( ' . $item[$i]['shipment']->number . ' ) الكمية  ( ' . $item[$i]['quantity'] . ' ) السعر  ( '. $item[$i]['price']  .' ) <br> ';
                                @endphp

                                    @php
                                    $i++;
                                    @endphp
                                @endforeach

                                    <tr>

                                    
                                        <td>{{$item[0]['shipment']->number}}</td>
                                        <td>{{$item[0]['product']->name}}</td>
                                        <td>{{$sum_quantity}}</td>

                                        <td>{{$item[0]['damaged'] }}</td>
                                        <td>{{$sum_sells}}</td>

                                        <td>
                                            @php

                                                echo $desc;

                                            @endphp
                                            
                                        </td>

                                   

                                    </tr>

                               
                           

                           

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--Table Head Dark End-->

        @endforeach



        
</div>





@foreach ($daily_sells as $daily)
    


<div class="modal fade" id="add-to-daily-{{$daily->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة مبيعات لليومية</h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form action="{{route('addDailySell')}}" method="POST">

                @csrf
                <div class="row">

                    <input type="hidden" name="type" value="exist" id="">
                    
                    <input type="hidden" name="id" value="{{$daily->id}}" id="">
                   

                    <div class="col-sm-4 mb-20">
                        <label for="number"> رقم الشحنة</label>
                       
                        <select class="form-control" name="ship_id[]" id="">

                            @foreach ($shipments->sortBy("number") as $ship)
                                
                            <option value="{{$ship->id}}">{{$ship->number}}</option>

                            @endforeach
                        </select>
                    </div>


                    <div class="col-sm-4 mb-20">
                        <label for="name"> البيان</label>
                        <select class="form-control" name="b_name[]" id="">
                            @foreach ($products->sortBy("name") as $prod)

                            <option value="{{$prod->id}}">{{$prod->name}}</option>
                                
                            @endforeach
                        </select>
                    </div>


                    <div class="col-sm-4 mb-20">
                        <label for="selling_quantity"> الكمية المباعة</label>
                        <input type="number" required id="selling_quantity[]" min="0" name="selling_quantity[]" class="form-control" >
                    </div>

                    <div class="col-sm-4 mb-20">
                        <label for="damaged"> التالف</label>
                        <input type="number" id="damaged" name="damaged[]" min="0" value="0" class="form-control" >
                    </div>



                    <div class="col-sm-4 mb-20">
                        <label for="number"> السعر</label>
                        <input type="number" id="quantity" name="price[]" class="form-control" min="0" required step=".001" >                    
                    </div>

                  

                    <div class="text-center col-12">

                        <hr  style="width: 99% ; color: solid black">

                    </div>

                    <div id="newinput2" class="col-12 row mr-2"></div>

                </div>

                <div class="col-12 text-center">

                    <button id="rowAdder2" type="button" class="btn btn-dark">
                        <span class="bi bi-plus-square-dotted">
                        </span> إضافة بيان
                    </button>

                </div>
                   
             
            </div>
            <div class="modal-footer">
                <button  class="button button-danger" data-dismiss="modal">إلغاء</button>
                <button class="button button-primary">حفظ </button>
            </div>
        </form>
        </div>
    </div>
</div>

@endforeach




@foreach ($daily_sells as $daily)
    


<div class="modal fade" id="edit-daily-{{$daily->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل مبيعات لليومية</h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form action="{{route('editDailySell')}}" method="POST">

                <input type="hidden" name="daily_sell_id" value="{{$daily->id}}" id="">
                @csrf
                <div class="row">

                    @foreach ($daily->dailySellItmes->sortBy('product_id') as $item)
                        
                   
                    
                    <input type="hidden" name="id[]" value="{{$item->id}}" id="">
                   

                    <div class="col-sm-4 mb-20">
                        <label for="number"> رقم الشحنة</label>
                       
                        <select class="form-control" name="ship_id[]"  id="">

                            <option value="{{$item->shipment->id}}">{{$item->shipment->number}}</option>

                            @foreach ($shipments->sortBy("number") as $ship)
                                
                            <option value="{{$ship->id}}">{{$ship->number}}</option>

                            @endforeach
                        </select>
                    </div>


                    <div class="col-sm-4 mb-20">
                        <label for="name"> البيان</label>
                        <select class="form-control" name="b_name[]" id="">

                            <option value="{{$item->product->id}}">{{$item->product->name}}</option>

                            @foreach ($products->sortBy("name") as $prod)

                            <option value="{{$prod->id}}">{{$prod->name}}</option>
                                
                            @endforeach
                        </select>
                    </div>


                    <div class="col-sm-4 mb-20">
                        <label for="selling_quantity"> الكمية المباعة</label>
                        <input type="number" required id="selling_quantity[]" value="{{$item->quantity}}" min="0" name="selling_quantity[]" class="form-control" >
                    </div>

                    <div class="col-sm-4 mb-20">
                        <label for="damaged"> التالف</label>
                        <input type="number" id="damaged" name="damaged[]" min="0" value="{{$item->damaged}}" class="form-control" >
                    </div>



                    <div class="col-sm-4 mb-20">
                        <label for="number"> السعر</label>
                        <input type="number" id="quantity" name="price[]" value="{{$item->price}}" class="form-control" min="0" required step=".001" >                    
                    </div>

                    <div class="col-sm-4 mb-20">
                        <label > حذف</label>
                       <a href="{{route('deleteDailySell',$item->id)}}">
                           <button type="button"  class="btn btn-danger">حذف  </button>
                        </a>                    
                    </div>

                   <div class="text-center col-12">

                        <hr  style="width: 99% ; color: solid black">

                    </div>

                    @endforeach

                   


                </div>
                   
             
            </div>
            <div class="modal-footer">
                <button  class="button button-danger" data-dismiss="modal">إلغاء</button>
                <button class="button button-primary">حفظ </button>
            </div>
        </form>
        </div>
    </div>
</div>

@endforeach


@endsection

