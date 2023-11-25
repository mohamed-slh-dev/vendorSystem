@extends('layouts.app')

@section('title', 'البيان')

@section('content')


<div class="row">

    <div class="col-12">

        <button class="button button-primary" data-toggle="modal" data-target="#exampleModal1">اضافة بيان </button>
    </div>

  

    <div class="col-12">
        <hr>
    </div>

    <div class="col-12">

        <!--Table Head Dark Start-->
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <h4 class="title">جدول   البيان </h4>
                </div>
                <div style="overflow-x: auto">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th> الأسم</th>
                                <th> الحالة</th>

                                <th> تعديل</th>
                                <th> إخفاء</th>
                                <th> حذف</th>

                                <th> بواسطة</th>

                               

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($products->sortBy('is_active') as $prod)
                          
                            <tr >
                                <th>{{$prod->id}}</th>
                                <td>{{$prod->name}}</td>
                                <td>
                                    @if ($prod->is_active == 0)
                                       <h4 class="text-success">ظاهر</h4> 
                                    @else
                                    <h4 class="text-danger">مخفي</h4>  
                                    @endif

                                    </td>

                                <td>  <button class="btn btn-success" data-toggle="modal" data-target="#updateProd-{{$prod->id}}"> تعديل </button></td>

                                <td>

                                @if ($prod->is_active == 0)
                                <a href="{{route('hideProduct', $prod->id)}}">
                                    <button class="btn btn-dark">إخفاء</button>
                                </a>

                                 @else
                                 <a href="{{route('hideProduct', $prod->id)}}">
                                        <button class="btn btn-info">إظهار</button>
                                    </a> 
                                 @endif

                                </td>

                                <td>
                                    <a href="{{route('deleteProduct', $prod->id)}}">
                                        <button class="btn btn-danger">حذف</button>
                                    </a> 
                                </td>

                                <td>{{$prod->user_created}}</td>
                               
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--Table Head Dark End-->

    </div>

</div>



<div class="modal fade" id="exampleModal1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة بيان </h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form action="{{route('addProduct')}}" method="POST">

                @csrf
                <div class="row">
                    <div class="col-sm-4 mb-20">
                        <label for="name"> الأسم</label>
                        <input type="text" id="name" name="name" class="form-control" >
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


@foreach ($products as $prod)
    
<div class="modal fade" id="updateProd-{{$prod->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل بيان </h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form action="{{route('updateProduct')}}" method="POST">

                <input type="hidden" name="id" value="{{$prod->id}}" id="">
                @csrf
                <div class="row">
                    <div class="col-sm-4 mb-20">
                        <label for="name"> الأسم</label>
                        <input type="text" id="name" name="name" value="{{$prod->name}}" class="form-control" >
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

@endsection