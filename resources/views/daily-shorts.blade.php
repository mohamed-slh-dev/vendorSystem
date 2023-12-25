@extends('layouts.app')

@section('title', 'نواقص المبيعات')

@section('content')




<form action="{{route('addDailyShort')}}" method="POST">

    @csrf


    <div class="row">
       

    @foreach ($shorts as $short)

    
    <input type="hidden" name="short_id[]" value="{{$short->id}}" id="">
    <input type="hidden" name="id[]" value="{{$short->daily_sell_id}}" id="">

        <div class="col-sm-4 mb-20">
            <label for=""> العميل</label>
            <h4 class="mt-3">{{$short->dailySell->client}}</h4 class="mt-3">
        
        </div>

        <div class="col-sm-4 mb-20">
            <label for=""> التاريخ</label>
            <h4 class="mt-3">{{$short->dailySell->date}}</h4 class="mt-3">
        
        </div>

        <div class="col-sm-4 mb-20">
            <label for="">رقم الفاتورة</label>
            <h4 class="mt-3">{{$short->dailySell->bill_number}}</h4 class="mt-3">
        
        </div>
        


        <div class="col-sm-4 mb-20">
            <label for="number"> رقم الشحنة</label>
           
            <select class="form-control" name="ship_id[]" id="">

                @foreach ($shipments->sortBy('number') as $ship)
                    
                <option value="{{$ship->id}}">{{$ship->number}}</option>

                @endforeach
            </select>
        </div>



        <div class="col-sm-4 mb-20">
            <label for="name"> البيان</label>
           <select class="form-control" name="b_name[]" id="">
            <option value="{{$short->product_id}}">{{$short->product->name}}</option>

        </select>

        </div>


        <div class="col-sm-4 mb-20">
            <label for="selling_quantity"> الكمية المباعة</label>
            <input type="number" required id="selling_quantity[]" max="{{$short->remaining_quantity}}"  value="0" min="1" name="selling_quantity[]" class="form-control" >
        </div>

         <div class="col-sm-4 mb-20">
            <label for="remaining_quantity"> الكمية المتبقية</label>
            <h4 class="mt-3">{{$short->remaining_quantity}}</h4 class="mt-3">
           
        </div>

        <div class="col-sm-4 mb-20">
            <label for="damaged"> التالف</label>
            <input type="number" id="damaged" name="damaged[]"  value="{{$short->damaged}}" min="0" value="0" class="form-control" >
        </div>



        <div class="col-sm-4 mb-20">
            <label for="price"> السعر</label>
            <input type="number" id="price" name="price[]"  value="{{$short->price}}" class="form-control" min="0" required step=".001" >                    
        </div>


        <div class="col-sm-4 mb-20">
            <button class="btn button-danger" type="button" data-toggle="modal" data-target="#product-quantity-{{$short->id}}"> عرض كميات المنتج في الإرساليات </button>                    
        </div>

        <div class="text-center col-12">

            <hr  style="width: 99% ; color: solid black">

        </div>

    @endforeach
      


    </div>


    @if($shorts instanceof \Illuminate\Pagination\LengthAwarePaginator )

    <div class="m-4">

        {{$shorts->links()}}
     
    </div>
    
    @endif

    @if ($shorts->count() > 0 )
        
        <div class="modal-footer">
            <button class="button button-primary">حفظ </button>
        </div>

    @endif

</form>
    



@foreach ($shorts as $short)
    
<div class="modal fade" id="product-quantity-{{$short->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">الكميات المتبقية من - {{$short->product->name}}</h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
             
                <div class="row">


                <div class="col-12" style="overflow-x: auto;">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>

                                <th> رقم الإرسالية </th>

                                <th> البيان</th>

                                <th> الكمية</th>
                               
                               


                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($items->where('product_id', $short->product_id) as $item)
                                
                                <tr>

                                    <td>{{$item->shipment->number}}</td>
                                    <td>{{$item->product->name}}</td>
                                    <td>{{$item->remaining_quantity}}</td>

                                </tr>
                            @endforeach
                                   
                        </tbody>
                    </table>
                </div>
                    
                    
                
                </div>

            </div>
            <div class="modal-footer">
                <button  class="button button-danger" data-dismiss="modal">إلغاء</button>
            </div>
       
        </div>
    </div>
</div>

@endforeach

@endsection