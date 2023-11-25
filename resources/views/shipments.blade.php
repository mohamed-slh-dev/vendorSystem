@extends('layouts.app')

@section('title', 'الإرساليات')

@section('content')


<div class="row">

    <div class="col-12 mb-4">
        <form class="row" action="{{route('searchShipmentValue')}}" method="POST">

            @csrf
            <div class="col-sm-12 mb-3 text-center">
                <h4>ابحث برقم الإرسالية</h4>
            </div>
        
            <div class="col-sm-5"></div>

            <div class="col-sm-2 mb-3 text-center">
                <input type="number"  name="number" class="form-control" id="">
            </div>

            <div class="col-sm-5"></div>
        
        
            <div class="col-sm-12 mb-4 text-center">
               <button class="btn btn-success">بحث</button>
            </div>

        </form>
    </div>
   

    <div class="col-12">

        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1">اضافة إرسالية </button>

    </div>

 

    @foreach ($shipments as $ship)
        
    <div class="col-12">
        <hr>
    </div>

        <!--Table Head Dark Start-->
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head row">
                    <div class="col-sm-12 mt-4">
                        <h4 class="title"> شحنة رقم {{$ship->number}}</h4>

                    </div>

                    <div class="col-sm-3 mt-3">
                        <button class="btn btn-success"  data-toggle="modal" data-target="#add-product-shipment-{{$ship->id}}" >إضافة بيان</button>

                    </div>

                    <div class="col-sm-3 mt-3">
                        <button class="btn btn-primary"  data-toggle="modal" data-target="#update-shipment-{{$ship->id}}" >تعديل الإرسالية</button>

                    </div>


                    <div class="col-sm-3 mt-3">
                        <button class="btn button-warning shipment-assign-id"  data-toggle="modal" data-target="#add-shipment" value="{{$ship->id }}">اضافة منصرفات </button>

                    </div>

                    <div class="col-sm-3 mt-3">
                        <button class="btn btn-danger shipment-delete-assign-id"  data-toggle="modal" data-target="#delete-shipment" value="{{$ship->id }}"> حذف الإرسالية </button>

                    </div>


                   
                   
                </div>
                <div style="overflow-x: auto">
                    <table class="table table-hover my-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>بواسطة</th>
                                <th>تعديل البيان</th>
                                <th>حذف البيان</th>

                                <th>إضافة مبيعات</th>
                                <th>رقم الشحنة</th>
                                <th> المورد</th>
                                <th> التاريخ</th>
                                <th> البييان</th>
                                <th> الكمية</th>
                                <th>  الكمية المتبيقة</th>

                                <th> سعر الفاتورة</th>
                                <th style="background: #e9907a; color: black">قيمة الفاتورة</th>
                                <th style="background: #e9907a; color: black">سعر الفاتورة SA</th>
                                <th style="background: #e9907a; color: black">قيمة الفاتورة SA</th>
                                <th style="background: #e9907a; color: black"> الإجمالي</th>

                                <th style="background: #fdfd62; color: black"> تاريخ اخر تعديل</th>

                                <th style="background: #fdfd62; color: black"> </th>
                                <th style="background: #fdfd62; color: black"> </th>

                                <th style="background: #fdfd62; color: black"> العميل</th>
                                <th style="background: #fdfd62; color: black">الكمية المباعة</th>
                                <th style="background: #fdfd62; color: black"> التالف</th>
                                <th style="background: #fdfd62; color: black"> فرق الكميات</th>
                                <th style="background: #fdfd62; color: black"> السعر</th>
                                <th style="background: #fdfd62; color: black"> المبيعات</th>
                                <th style="background: #fdfd62; color: black"> الصافي</th>

                                <th style="background: #fdfd62; color: black"> رقم الفاتورة</th>



                            </tr>
                        </thead>
                        <tbody>

                            @php
                                
                                $sum_value = 0;
                                $sum_price_sar = 0;
                                $sum_value_sar = 0;
                                $sum_sell = 0;
                               
                            @endphp     
                          

                         

                           @foreach ($ship->shipmentItmes as $item)
                            @php

                                 $sum_value += $item->invoice_total;
                                 $sum_price_sar += $item->invoice_price_sa;
                                 $sum_value_sar += $item->invoice_total_sa;
                                 
                                        
                                        


                            @endphp

                                 {{-- shipment rows --}}

                                    <tr>
                                    
                                        <td>{{$ship->user_created}}</td>

                                        <td>

                                            <button class="btn btn-primary" data-toggle="modal" data-target="#update-item-{{$item->id}}">تعديل البيان </button>

                                        </td>

                                        <td>

                                            <button class="btn btn-danger item-delete-assign-id"  data-toggle="modal" data-target="#delete-item" value="{{$item->id }}">حذف البيان </button>

                                        </td>

                                        <td>
                                            <button
                                            @if ($item->remaining_quantity <=  0 )
                                                disabled
                                            @endif 
                                            class="btn btn-success selling-assign-id" data-toggle="modal" data-target="#add-selling" value="{{ $item->id }}" >اضافة مبيعات</button>
                                        </td> 


                                    <td>{{$ship->number}}</td> 
                                    <td>{{$ship->supplier}}</td> 
                                    <td>{{$ship->date}}</td> 
                                    <td>{{$item->product->name}}</td> 
                                    <td 
                                        @if ($item->remaining_quantity <=  0 )
                                        style= "background-color : #3bff3b;"
                                        @endif 
                                        >{{$item->quantity}}
                                    </td> 
                                    <td>{{$item->remaining_quantity}}</td> 

                                    <td>{{ number_format($item->invoice_price , 3, '.', ',')}}</td> 

                                    <td style="background: #e9907a; color: black">
                                        {{ number_format($item->invoice_total , 3, '.', ',') }}
                                    </td> 
                                    <td style="background: #e9907a; color: black">
                                        {{ number_format($item->invoice_price_sa , 3, '.', ',') }}
                                    </td> 
                                    <td style="background: #e9907a; color: black">
                                        {{ number_format($item->invoice_total_sa , 3, '.', ',') }}
                                    </td> 
                                    <td style="background: #e9907a; color: black">
                                        {{ number_format($item->total , 3, '.', ',') }}
                                    </td> 

                                    
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <td></td>

                                    
                                    </tr>

                                   

                                    @php
                                       
                                        $sum_selling_quantity = 0; 

                                    @endphp
                                @foreach ($item->itemSells as $sell)

                                    @php
                                        $sum_sell += $sell->selling;
                                        $sum_selling_quantity += $sell->quantity + $sell->damaged ;
                                    @endphp

                                    {{-- selling rows --}}
                                    <tr >
                                        <td>{{$sell->user_created}}</td>

                                        <td></td>
                                        <td> </td> 

                                        <td></td>
                                    <td>{{$ship->number}}</td> 
                                    <td>{{$ship->supplier}}</td> 
                                    <td>{{$sell->date}}</td> 
                                    <td>{{$item->product->name}}</td> 
                                   
                                    <td></td> 
                                    <td></td> 


                                    <td></td> 
                                   

                                    <td style="background: #e9907a; color: black">
                                        
                                    </td> 
                                    <td style="background: #e9907a; color: black">
                                       
                                    </td> 
                                    <td style="background: #e9907a; color: black">
                                       
                                    </td> 
                                    <td style="background: #e9907a; color: black">
                                      
                                    </td> 

                                    <td style="background: #fdfd62;"> 
                                    {{ date("Y-m-d H:i:s", strtotime($sell->updated_at ." +3 hours")) }} 
                                    </td>


                                    <td style="background: #fdfd62;">

                                        <button class="btn btn-warning" data-toggle="modal" data-target="#update-sell-{{$sell->id}}">تعديل المبيعات </button>

                                    </td>

                                     <td style="background: #fdfd62;">

                                        <button class="btn btn-danger delete-assign-id" data-toggle="modal" data-target="#delete-sell" value="{{$sell->id}}">حذف المبيعات </button>

                                    </td>

                                    <td style="background: #fdfd62;">{{$sell->client}}</td>
                                    <td style="background: #fdfd62;">{{$sell->quantity}}</td>
                                    <td style="background: #fdfd62;">{{$sell->damaged}}</td>
                                    <td style="background: #fdfd62;">{{ $item->quantity - $sum_selling_quantity}}</td>
                                    <td style="background: #fdfd62;">{{ number_format($sell->price , 3, '.', ',')}}</td>
                                    <td style="background: #fdfd62;">{{ number_format($sell->selling , 3, '.', ',')}}</td>

                                    <td style="background: #fdfd62;"> {{ number_format( $sum_sell - $item->total , 3, '.', ',')}} </td>
                                    
                                    <td style="background: #fdfd62;">{{$sell->bill_number}}</td>
                                    
                                    </tr>
                                @endforeach
  
                            @endforeach

                            {{-- total bill row --}}
                            <tr style="background-color: #fdfd62">
                                <td></td>
                                

                                <td style="font-weight: bold">إجمالي الفاتورة</td>
                                <td></td>
                                <td></td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                                <td style="font-weight: bold">
                                    @php
                                       echo number_format($sum_value , 3, '.', ',');
                                    @endphp
                                </td>

                                <td style="font-weight: bold">
                                    @php
                                    echo number_format($sum_price_sar , 3, '.', ',');
                                    @endphp
                                </td>


                                <td style="font-weight: bold">
                                    @php

                                    echo number_format($sum_value_sar , 3, '.', ',')
                                        
                                    @endphp
                                </td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="font-weight: bold">
                                    
                                    @php
                                   
                                    echo number_format($sum_sell , 3, '.', ',');

                                   @endphp
                                   </td>
                                <td style="font-weight: bold">
                                    @php
                                     echo number_format($sum_sell - $sum_value_sar   , 3, '.', ',')
                                    @endphp
                                   
                                </td>
                                <td></td>
                               
                            </tr>

                         
                            @php
                                 $sum_exp = 0;
                                 $sum_others = 0;

                            @endphp

                            @foreach ($ship->otherTransactions as $exp)
                                
                                @php
                                    $sum_exp += $exp->customs_price;
                                    $sum_others += $exp->others_price;

                                @endphp

                          {{-- customes --}}
                            <tr>
                                <td></td>
                                <td></td>

                                <td style="font-weight: bold">الشحن و التخليص</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                               

                                <td style="font-weight: bold">{{ number_format($exp->customs_price , 3, '.', ',')}}</td>

                            </tr>

                        {{-- other expenses --}}
                            <tr>
                                <td></td>
                                <td></td>

                                <td style="font-weight: bold">منصرفات اخرى خاصة بالشحن</td>

                                <td>( {{$exp->desc}} )</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                                <td style="font-weight: bold">{{ number_format($exp->others_price , 3, '.', ',')}}</td>

                            </tr>

                            @endforeach
                            
                         {{-- total shipment final number  --}}

                            <tr>
                                <td></td>
                                <td></td>

                                <td style="font-weight: bold">إجمالي تكلفة الشحن</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                                <td style="font-weight: bold">
                                    @php
                                        echo number_format($sum_value_sar + $sum_exp + $sum_others , 3, '.', ',');
                                    @endphp
                                   
                                </td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                                <td style="font-weight: bold">
                                    @php
                                        
                                        echo number_format( $sum_sell  - ($sum_value_sar + $sum_exp + $sum_others) , 3, '.', ',');

                                    @endphp
                                  

                                </td>

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--Table Head Dark End-->

    @endforeach
   

  
    @if($shipments instanceof \Illuminate\Pagination\LengthAwarePaginator )

    <div class="m-4">

        {{$shipments->links()}}
     
    </div>
    
    @endif

</div>



<div class="modal fade" id="exampleModal1" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة إرسالية </h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>

        <form action="{{route('addShipment')}}" method="POST">

            <div class="modal-body">

                @csrf
                <div class="row">
                    <div class="col-sm-4 mb-20">
                        <label for="number"> الرقم</label>
                        <input type="number" required id="number" min="0" name="number" class="form-control" >
                    </div>

                    <div class="col-sm-4 mb-20">
                        <label for="supplier"> المورد</label>
                        <input type="text" required id="supplier" name="supplier" class="form-control" >
                    </div>


                    <div class="col-sm-4 mb-20">
                        <label for="date"> التاريخ</label>
                        <input type="date" id="date" required name="date" class="form-control" >
                    </div>

                  <div class="col-12 mb-20 row">
                    <div class="text-center col-12">
                    <hr style="width: 99%">
                    </div>
                   
                    <div class="col-sm-3 mb-20">
                        <label for="name"> البيان</label>
                        <select class="form-control" name="b_name[]" id="">
                            @foreach ($products as $prod)

                            <option value="{{$prod->id}}">{{$prod->name}}</option>
                                
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3 mb-20">
                        <label for="quantity"> الكمية</label>
                        <input type="number" required id="quantity" name="b_quantity[]" class="form-control" >
                    </div>

                    <div class="col-sm-3 mb-20">
                        <label for="jord_price"> سعر الفاتورة (بالأردني)</label>
                        <input type="number" required id="jord_price" name="b_price[]" class="form-control" min="0" value="0" step=".001" >
                    </div>

                    <div class="col-sm-3 mb-20">
                        <label for="sar_price"> سعر الفاتورة (بالريال)</label>
                        <input type="number" required id="sar_price" name="sar_price[]" class="form-control" min="0" value="0" step=".001" >
                    </div>

                    <div class="text-center col-12">

                        <hr  style="width: 99% ; color: solid black">

                    </div>

                    

                  </div>

                  <div id="newinput" class="col-12 row mr-2"></div>



                </div>

                <div class="col-12 text-center">

                    <button id="rowAdder" type="button" class="btn btn-dark">
                        <span class="bi bi-plus-square-dotted">
                        </span> إضافة بيان
                    </button>

                </div>
                   

            </div>
            <div class="modal-footer">
                <button class="button button-danger" data-dismiss="modal">إلغاء</button>
                <button type="submit" class="button button-primary">حفظ </button>
            </div>
        </form>

        </div>
    </div>
</div>


@foreach ($shipments as $ship)
    
<div class="modal fade" id="update-shipment-{{$ship->id}}" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل إرسالية </h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>

        <form action="{{route('updateShipment')}}" method="POST">

            <div class="modal-body">

                @csrf

                <input type="hidden" name="id" value="{{$ship->id}}" id="">
                <div class="row">
                    <div class="col-sm-4 mb-20">
                        <label for="number"> الرقم</label>
                        <input type="number" required id="number" min="0" value="{{$ship->number}}" name="number" class="form-control" >
                    </div>

                    <div class="col-sm-4 mb-20">
                        <label for="supplier"> المورد</label>
                        <input type="text" required id="supplier" name="supplier" value="{{$ship->supplier}}" class="form-control" >
                    </div>


                    <div class="col-sm-4 mb-20">
                        <label for="date"> التاريخ</label>
                        <input type="date" id="date" required name="date" value="{{$ship->date}}" class="form-control" >
                    </div>

                 

                </div>

            </div>
            <div class="modal-footer">
                <button class="button button-danger" data-dismiss="modal">إلغاء</button>
                <button type="submit" class="button button-primary">حفظ </button>
            </div>
        </form>

        </div>
    </div>
</div>

@endforeach




@foreach ($shipments as $ship)
    
<div class="modal fade" id="add-product-shipment-{{$ship->id}}" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> إضافة بيان </h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>

        <form action="{{route('addProductShipment')}}" method="POST">

            <div class="modal-body">

                @csrf

                <input type="hidden" name="id" value="{{$ship->id}}" id="">

                <div class="row">
                   

                    <div class="col-sm-3 mb-20">
                        <label for="name"> البيان</label>
                        <select class="form-control" name="b_name[]" id="">
                            @foreach ($products as $prod)

                            <option value="{{$prod->id}}">{{$prod->name}}</option>
                                
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3 mb-20">
                        <label for="quantity"> الكمية</label>
                        <input type="number" required id="quantity" name="b_quantity[]" class="form-control" >
                    </div>

                    <div class="col-sm-3 mb-20">
                        <label for="jord_price"> سعر الفاتورة (بالأردني)</label>
                        <input type="number" required id="jord_price" name="b_price[]" class="form-control" min="0" value="0" step=".001" >
                    </div>

                    <div class="col-sm-3 mb-20">
                        <label for="sar_price"> سعر الفاتورة (بالريال)</label>
                        <input type="number" required id="sar_price" name="sar_price[]" class="form-control" min="0" value="0" step=".001" >
                    </div>

                    <div class="text-center col-12">

                        <hr  style="width: 99% ; color: solid black">

                    </div>


                  <div id="newinput2" class="col-12 row mr-2"></div>

                 
                  <div class="col-12 text-center">

                    <button id="rowAdder2" type="button" class="btn btn-dark">
                        <span class="bi bi-plus-square-dotted">
                        </span> إضافة بيان
                    </button>

                </div>


                </div>

            </div>
            <div class="modal-footer">
                <button class="button button-danger" data-dismiss="modal">إلغاء</button>
                <button type="submit" class="button button-primary">حفظ </button>
            </div>
        </form>

        </div>
    </div>
</div>

@endforeach



    
<div class="modal fade" id="delete-shipment" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">حذف الإرسالية </h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>

        <form action="{{route('deleteShipment')}}" method="POST">

            <div class="modal-body">

                @csrf

                <input type="hidden" name="id" value="" id="delete-shipment-id">

                <div class="row">
                   
                    <h4 class="mr-4">هل انت متأكد من حذف هذه الإرسالية؟</h4>
                  

                </div>

            </div>
            <div class="modal-footer">
                <button class="button button-danger" data-dismiss="modal">إلغاء</button>
                <button type="submit" class="button button-primary">حذف </button>
            </div>
        </form>

        </div>
    </div>
</div>


 
<div class="modal fade" id="delete-item" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">حذف البيان </h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>

        <form action="{{route('deleteShipmentProduct')}}" method="POST">

            <div class="modal-body">

                @csrf

                <input type="hidden" name="id" value="" id="delete-item-id">

                <div class="row">
                   
                    <h4 class="mr-4">هل انت متأكد من حذف هذا البيان؟</h4>
                  

                </div>

            </div>
            <div class="modal-footer">
                <button class="button button-danger" data-dismiss="modal">إلغاء</button>
                <button type="submit" class="button button-primary">حذف </button>
            </div>
        </form>

        </div>
    </div>
</div>



@foreach ($sells as $sell)
    
<div class="modal fade" id="update-sell-{{$sell->id}}" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل المبيعات </h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>

        <form action="{{route('updateSell')}}" method="POST">

            <div class="modal-body">

                @csrf

                <input type="hidden" name="id" value="{{$sell->id}}" id="">
                <div class="row">
                   
                    <div class="col-sm-4 mb-20">
                        <label for="client"> العميل</label>
                        <input type="text" required id="client" name="client" value="{{$sell->client}}" class="form-control" >
                    </div>

                    <div class="col-sm-4 mb-20">
                        <label for="date"> التاريخ</label>
                        <input type="date" id="date" name="date" value="{{$sell->date}}" class="form-control" >
                    </div>


                    <div class="col-sm-4 mb-20">
                        <label for="selling_quantity"> الكمية المباعة</label>
                        <input type="number" required id="selling_quantity" min="0" value="{{$sell->quantity}}" name="selling_quantity" class="form-control" >
                    </div>

                    <div class="col-sm-4 mb-20">
                        <label for="damaged"> التالف</label>
                        <input type="number" id="damaged" name="damaged" value="{{$sell->damaged}}" class="form-control" >
                    </div>


                    <div class="col-sm-4 mb-20">
                        <label for="number"> السعر</label>
                        <input type="number" id="quantity" name="price" required class="form-control" value="{{$sell->price}}" min="0"  step=".001" >                    
                    </div>


                    <div class="col-sm-4 mb-20">
                        <label for="bill"> رقم الفاتورة</label>
                        <input type="text" id="bill" name="bill" value="{{$sell->bill_number}}" class="form-control" >
                    </div>
                    

                </div>

            </div>
            <div class="modal-footer">
                <button class="button button-danger" data-dismiss="modal">إلغاء</button>
                <button type="submit" class="button button-primary">حفظ </button>
            </div>
        </form>

        </div>
    </div>
</div>

@endforeach




    
<div class="modal fade" id="delete-sell" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">حذف المبيعات </h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>

        <form action="{{route('deleteSell')}}" method="POST">

            <div class="modal-body">

                @csrf

                <input type="hidden" name="id" value="" id="delete-sell-id">

                <div class="row">
                   
                    <h4 class="mr-4">هل انت متأكد من حذف هذه المبيعات؟</h4>
                  

                </div>

            </div>
            <div class="modal-footer">
                <button class="button button-danger" data-dismiss="modal">إلغاء</button>
                <button type="submit" class="button button-primary">حذف </button>
            </div>
        </form>

        </div>
    </div>
</div>



@foreach ($items as $item)
    
<div class="modal fade" id="update-item-{{$item->id}}" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل بيان </h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>

        <form action="{{route('updateItem')}}" method="POST">

            <div class="modal-body">

                @csrf

                <input type="hidden" name="id" value="{{$item->id}}" id="">
                <div class="row">
                  
                    <div class="col-sm-4 mb-20">
                        <label for="name"> البيان</label>
                        <select class="form-control" name="name" id="">

                            <option value="{{$item->product_id}}">{{$item->product->name}}</option>

                            @foreach ($products as $prod)

                            <option value="{{$prod->id}}">{{$prod->name}}</option>
                                
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-4 mb-20">
                        <label for="quantity"> الكمية</label>
                        <input type="number" required id="quantity" min="0" name="quantity" value="{{$item->quantity}}" class="form-control" >
                    </div>


                    <div class="col-sm-4 mb-20">
                        <label for="remaining_quantity"> الكمية المتبقية</label>
                        <input type="number" required id="remaining_quantity" min="0" name="remaining_quantity" value="{{$item->remaining_quantity}}" class="form-control" >
                    </div>

                    <div class="col-sm-4 mb-20">
                        <label for="jord_price"> سعر الفاتورة</label>
                        <input type="number" required id="jord_price" name="price"  value="{{$item->invoice_price}}" class="form-control" min="0" value="0" step=".001" >
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button class="button button-danger" data-dismiss="modal">إلغاء</button>
                <button type="submit" class="button button-primary">حفظ </button>
            </div>
        </form>

        </div>
    </div>
</div>

@endforeach



<div class="modal fade add-selling" id="add-selling">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة مبيعات </h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>

        <form action="{{route('sellShipment')}}" method="POST">

            <input type="hidden" name="id" id="modal-assign-selling" value="">

            <div class="modal-body">

                @csrf
                <div class="row">
                   
                    <div class="col-sm-4 mb-20">
                        <label for="client"> العميل</label>
                        <input type="text" required id="client" name="client" class="form-control" >
                    </div>

                    <div class="col-sm-4 mb-20">
                        <label for="date"> التاريخ</label>
                        <input type="date" id="date" name="date" class="form-control" >
                    </div>


                    <div class="col-sm-4 mb-20">
                        <label for="selling_quantity"> الكمية المباعة</label>
                        <input type="number" required id="selling_quantity" min="0" name="selling_quantity" class="form-control" >
                    </div>

                    <div class="col-sm-4 mb-20">
                        <label for="damaged"> التالف</label>
                        <input type="number" id="damaged" name="damaged" min="0" value="0" class="form-control" >
                    </div>



                    <div class="col-sm-4 mb-20">
                        <label for="number"> السعر</label>
                        <input type="number" id="quantity" name="price" required class="form-control" min="0"  step=".001" >                    
                    </div>


                    <div class="col-sm-4 mb-20">
                        <label for="bill"> رقم الفاتورة</label>
                        <input type="text" id="bill" name="bill" class="form-control" >
                    </div>
                    

                  </div>     

            </div>
            <div class="modal-footer">
                <button class="button button-danger" data-dismiss="modal">إلغاء</button>
                <button type="submit" class="button button-primary">حفظ </button>
            </div>
        </form>

        </div>
    </div>
</div>





<div class="modal fade add-shipment" id="add-shipment">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة منصرفات </h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>

        <form action="{{route('addExpenses')}}" method="POST">

            <input type="hidden" name="id" id="modal-assign-shipment" value="">

            <div class="modal-body">

                @csrf
                <div class="row">
                   
                    <div class="col-sm-6 mb-20">
                        <label for="customs">التخلص و الشحن</label>
                        <input type="text"  id="customs" name="customs"  min="0" value="0" step=".001" class="form-control fraction-commas" >
                    </div>

                    <div class="col-sm-6 mb-20">
                        <label for="others"> منصرفات اخرى</label>
                        <input type="text" id="others" name="others"  min="0" value="0" step=".001" class="form-control fraction-commas" >
                    </div>

                    <div class="col-12 mb-20">
                        <label for="desc">ملاحظة</label>
                        <input type="text" id="desc" class="form-control" name="desc">
                    </div>

                  
                    

                  </div>     

            </div>
            <div class="modal-footer">
                <button class="button button-danger" data-dismiss="modal">إلغاء</button>
                <button type="submit" class="button button-primary">حفظ </button>
            </div>
        </form>

        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>

    //add selling assing id function
    $('.selling-assign-id').click(function() {

    item_id = $(this).val();

    $('#modal-assign-selling').val(item_id);

    });

    //add expenss assing id function
    $('.shipment-assign-id').click(function() {

    shipment_id = $(this).val();

    $('#modal-assign-shipment').val(shipment_id);

    });


    //delete shipment assing id function
    $('.shipment-delete-assign-id').click(function() {

    shipment_delete_id = $(this).val();

    $('#delete-shipment-id').val(shipment_delete_id);

    });

    //delete item assing id function
    $('.item-delete-assign-id').click(function() {

    item_delete_id = $(this).val();

    $('#delete-item-id').val(item_delete_id);

    });


    //delete sell assing id function
    $('.delete-assign-id').click(function() {

    sell_id = $(this).val();

    $('#delete-sell-id').val(sell_id);

    });

</script>

<script type="text/javascript">


    $("#rowAdder").click(function () {
        newRowAdd =
            '<div id="row" class="col-12 mb-20 row" ><div class="text-center col-12"><hr style="width: 99%"></div> <div class="col-12 mb-20 text-center"><button class="btn btn-danger" id="DeleteRow" type="button">حذف</button></div><div class="col-sm-3 mb-20"><label for="name"> البيان</label><select name="b_name[]" class="form-control" id="">@foreach ($products as $prod)<option value="{{$prod->id}}">{{$prod->name}}</option>@endforeach</select></div><div class="col-sm-3 mb-20"><label for="quantity"> الكمية</label><input type="number" id="quantity" required name="b_quantity[]" class="form-control" ></div><div class="col-sm-3 mb-20"><label for="quantity"> سعر الفاتورة (بالأردني)</label><input type="number" id="quantity" required name="b_price[]" class="form-control" min="0" value="0" step=".001" ></div>  <div class="col-sm-3 mb-20"><label for="sar_price"> سعر الفاتورة (بالريال)</label><input type="number" required id="sar_price" name="sar_price[]" class="form-control" min="0" value="0" step=".001" ></div><div class="text-center col-12"><hr style="width: 99%"></div></div>';

        $('#newinput').append(newRowAdd);
    });
    $("body").on("click", "#DeleteRow", function () {
        $(this).parents("#row").remove();
    })



    $("#rowAdder2").click(function () {
        newRowAdd =
            '<div id="row2" class="col-12 mb-20 row" ><div class="text-center col-12"><hr style="width: 99%"></div> <div class="col-12 mb-20 text-center"><button class="btn btn-danger" id="DeleteRow2" type="button">حذف</button></div><div class="col-sm-3 mb-20"><label for="name"> البيان</label><select name="b_name[]" class="form-control" id="">@foreach ($products as $prod)<option value="{{$prod->id}}">{{$prod->name}}</option>@endforeach</select></div><div class="col-sm-3 mb-20"><label for="quantity"> الكمية</label><input type="number" id="quantity" required name="b_quantity[]" class="form-control" ></div><div class="col-sm-3 mb-20"><label for="quantity"> سعر الفاتورة (بالأردني)</label><input type="number" id="quantity" required name="b_price[]" class="form-control" min="0" value="0" step=".001" ></div>  <div class="col-sm-3 mb-20"><label for="sar_price"> سعر الفاتورة (بالريال)</label><input type="number" required id="sar_price" name="sar_price[]" class="form-control" min="0" value="0" step=".001" ></div><div class="text-center col-12"><hr style="width: 99%"></div></div>';

        $('#newinput2').append(newRowAdd);
    });
    $("body").on("click", "#DeleteRow2", function () {
        $(this).parents("#row2").remove();
    })


</script>
    
@endsection