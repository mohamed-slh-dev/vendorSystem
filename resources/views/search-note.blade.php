@extends('layouts.app')

@section('title', 'الملاحظات')

@section('content')


<div class="row">


    <div class="col-12 mb-4">
        <form class="row" action="{{route('searchNoteValue')}}" method="POST">

            @csrf
            <div class="col-sm-12 mb-3 text-center">
                <h4>ابحث بالتاريخ</h4>
            </div>
        
            <div class="col-sm-5"></div>

            <div class="col-sm-2 mb-3 text-center">
                <input type="date" required  name="date_from" class="form-control mb-4" id="">
                
                <input type="date" required name="date_to" class="form-control" id="">

            </div>

            <div class="col-sm-5"></div>
        
        
            <div class="col-sm-12 mb-4 text-center">
               <button class="btn btn-success">بحث</button>
            </div>

        </form>
    </div>

  

    <div class="col-12">
        <hr>
    </div>

    @foreach ($dates as $date => $notes)
        <!--Table Head Dark Start-->
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <h4 class="title">جدول الملاحظات </h4>
                    <h4> {{$date}}</h4>
                </div>
                <div style="overflow-x: auto">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>بواسطة</th>
                                <th> إضافة مبيعات</th>

                                <th> التاريخ</th>
                                <th> البيان</th>

                                <th> الكمية</th>
                                <th> الكمية المتبقية</th>
                                <th> ملاحظات</th>
                               
                                <th>تعديل</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($notes as $note)
                          
                            <tr>

                                <td>{{$note->user_created}}</td>
                                
                                <td>
                                    <button
                                    @if ($note->remaining_quantity <= 0 )
                                        disabled
                                    @endif 
                                    class="btn btn-success selling-assign-id" data-toggle="modal" data-target="#add-selling" value="{{ $note->id }}" >اضافة مبيعات</button>
                                </td> 

                                <td>{{$note->date}}</td>
                                <td>{{$note->product->name}}</td>
                                <td> {{$note->quantity}}</td>
                                <td> {{$note->remaining_quantity}}</td>
                                <td> {{$note->desc}}</td>
               
                                <td> <button class="btn btn-primary" data-toggle="modal" data-target="#update-note-{{$note->id}}">تعديل الملاحظة </button></td>
                               
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



@foreach ($all_notes as $note)
    

<div class="modal fade" id="update-note-{{$note->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل ملاحظة</h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form action="{{route('updateNote')}}" method="POST">

                <input type="hidden" name="id" value="{{$note->id}}" id="">
                @csrf
                <div class="row">
                    <div class="col-sm-4 mb-20">
                        <label for="date"> التاريخ</label>
                        <input type="date" id="date" required name="date" value="{{$note->date}}" class="form-control" >
                    </div>

                    <div class="col-sm-8 mb-20">
                    </div>

                    <div class="col-sm-4 mb-20">
                        <label for="name"> البيان</label>
                        <select class="form-control" name="name" id="">
                            <option value="{{$note->product_id}}">{{$note->product->name}}</option>
                            @foreach ($products as $prod)

                            <option value="{{$prod->id}}">{{$prod->name}}</option>
                                
                            @endforeach
                        </select>
                    </div>


                    <div class="col-sm-4 mb-20">
                        <label for="quantity"> الكمية</label>
                        <input type="number" required id="quantity" min="0" name="quantity" value="{{$note->quantity}}" class="form-control" >
                    </div>

                    <div class="col-sm-4 mb-20">
                        <label for="remaining_quantity"> الكمية المتبقية</label>
                        <input type="number" required id="remaining_quantity" min="0" name="remaining_quantity" value="{{$note->remaining_quantity}}" class="form-control" >
                    </div>

                    <div class="col-sm-12 mb-20">
                        <label for="desc"> ملاحظات</label>
                        <input type="text" id="desc" name="desc" value="{{$note->desc}}"  class="form-control" >
                    </div>

                    <div class="text-center col-12">

                        <hr  style="width: 99% ; color: solid black">

                    </div>


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


<div class="modal fade add-selling" id="add-selling">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة مبيعات </h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>

        <form action="{{route('sellingFromNote')}}" method="POST">

            <input type="hidden" name="id" id="modal-assign-selling" value="">

            <div class="modal-body">

                @csrf
                <div class="row">
                   

                    <div class="col-sm-4 mb-20">
                        <label for="number"> رقم الشحنة</label>
                       
                        <select class="form-control" name="ship_id" id="">

                            @foreach ($shipments as $ship)
                                
                            <option value="{{$ship->id}}">{{$ship->number}}</option>

                            @endforeach
                        </select>
                    </div>


                    <div class="col-sm-4 mb-20">
                        <label for="client"> العميل</label>
                        <input type="text" required id="client" name="client" class="form-control" >
                    </div>

                    <div class="col-sm-4 mb-20">
                        <label for="date"> التاريخ</label>
                        <input type="date" id="date" required name="date" class="form-control" >
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
                        <input type="number" id="quantity" name="price" class="form-control" min="0" required step=".01" >                    
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




@endsection


@section('scripts')

<script>

    $('.selling-assign-id').click(function() {

    // get selling id
    item_id = $(this).val();

    $('#modal-assign-selling').val(item_id);

    });

</script>

    
@endsection