@extends('layouts.app')

@section('title', 'المستخدمين')

@section('content')


<div class="row">

    <div class="col-12">
        <hr>
    </div>

    <div class="col-12">

        <!--Table Head Dark Start-->
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <h4 class="title">جدول المستخدمين </h4>
                </div>
                <div style="overflow-x: auto">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th> الأسم</th>
                                <th> اسم المستخدم</th>
                                <th> تعديل كلمة المرور</th>
                               
                               

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($users as $user)
                          
                            <tr >
                                <th>{{$user->id}}</th>
                                <td>{{$user->name}}</td>
                                <td>{{$user->username}}</td>

                             
                                <td>  <button class="button button-success" data-toggle="modal" data-target="#updateUser-{{$user->id}}"> تعديل </button></td>

                                
                               
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





@foreach ($users as $user)
    
<div class="modal fade" id="updateUser-{{$user->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل كلمة المرور </h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form action="{{route('updateUser')}}" method="POST">

                <input type="hidden" name="id" value="{{$user->id}}" id="">
                @csrf
                <div class="row">
                    <div class="col-sm-4 mb-20">
                        <label for="name"> كلمةالمرور</label>
                        <input type="text" id="name" name="pass"  class="form-control" >
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