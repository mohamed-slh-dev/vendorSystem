@extends('layouts.app')

@section('title', 'العهد')

@section('content')


    <div class="row">



        <!-- Top Report Start -->
        <div class="col-xlg-4 col-md-12 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head">
                    <h4 class="text-primary"> المجموع</h4>
                    <a href="#" class="view text-primary"><i class="zmdi zmdi-check"></i></a>
                </div>

                <!-- Content -->
                <div class="content">
                    <h2 class="text-primary"> {{ $outcome - $income }} <small>SAR</small></h2>

                </div>

                <!-- Footer -->
                <div class="footer">
                    <div class="progess">
                        <div class="progess-bar"
                            style="width: 100%; background : linear-gradient(to right, #1080db 0%, #87d9ee 100%)"></div>
                    </div>
                </div>

            </div>
        </div><!-- Top Report End -->



        <!-- Top Report Start -->
        <div class="col-xlg-4 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head">
                    <h4 class="text-success"> له </h4>
                    <a href="#" class="view text-success"><i class="zmdi zmdi-arrow-right-top"></i></a>
                </div>

                <!-- Content -->
                <div class="content">
                    <h2 class="text-success"> {{ $income }} <small>SAR</small></h2>
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
        <div class="col-xlg-4 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head">
                    <h4 class="text-danger"> عليه</h4>
                    <a href="#" class="view text-danger"><i class="zmdi zmdi-arrow-left-bottom"></i></a>
                </div>

                <!-- Content -->
                <div class="content">
                    <h2 class="text-danger"> {{ $outcome }} <small>SAR</small></h2>

                </div>

                <!-- Footer -->
                <div class="footer">
                    <div class="progess">
                        <div class="progess-bar"
                            style="width: 100%; background : linear-gradient(to right, #db1010 0%, #ee8787 100%)"></div>
                    </div>
                </div>

            </div>
        </div><!-- Top Report End -->




        <div class="col-12">

            <button class="button button-primary" data-toggle="modal" data-target="#exampleModal1">اضافة عميل جديد </button>
        </div>



        <div class="col-12">
            <hr>
        </div>

        <div class="col-12">

            <!--Table Head Dark Start-->
            <div class="col-12 mb-30">
                <div class="box">
                    <div class="box-head">
                        <h4 class="title">جدول العهد </h4>
                    </div>

                    @foreach ($clients as $client)
                        <div style="overflow-x: auto">
                            <table class="table mb-4">

                                <tbody>



                                    <tr>

                                        <td style="width: 10%">
                                            <button class="btn btn-primary" type="button" data-toggle="collapse"
                                                data-target="#collapseExample-{{ $client->id }}" aria-expanded="false"
                                                aria-controls="collapseExample-{{ $client->id }}">
                                                <i class="fa fa-sort-amount-asc"></i>
                                                عرض العاملات المالية
                                            </button>
                                        </td>

                                        <td>

                                            <button class="btn btn-success client-id" data-toggle="modal"
                                                data-target="#new-trans" value="{{ $client->id }}">اضافة معاملة جديدة
                                            </button>

                                        </td>

                                        <td>

                                            <button class="btn btn-info" data-toggle="modal"
                                                data-target="#update-client-{{ $client->id }}"> تعديل بيانات العميل
                                            </button>

                                        </td>

                                        <td>

                                            <a href="{{ route('printClient', $client->id) }}">
                                                <button class="btn btn-dark">كشف الحساب</button>
                                            </a>

                                        </td>


                                        <td style="width: 10%">
                                            <h3> ({{ $client->transactions->count() }})</h3>

                                        </td>
                                        <td style="width: 25%">
                                            <h3> {{ $client->name }}</h3>

                                        </td>
                                        <td style="width: 10%">
                                            <h3> {{ $client->type }}</h3>

                                        </td>
                                        <td style="width: 15%">
                                            <h3> {{ number_format(($client->transactions->where('type', 'عليه')->sum('price') - $client->transactions->where('type', 'له')->sum('price') ), 2, '.', ',') }}</h3>
                                        </td>
                                        <td>
                                            @if ($client->transactions->where('type', 'عليه')->sum('price') - $client->transactions->where('type', 'له')->sum('price') < 0)
                                                <i style="font-weight: bold; font-size:18px;"
                                                    class="text-center text-success fa fa-arrow-up"></i>
                                            @elseif($client->transactions->where('type', 'عليه')->sum('price') - $client->transactions->where('type', 'له')->sum('price') > 0)
                                                <i style="font-weight: bold; font-size:18px;"
                                                    class="text-center text-danger fa fa-arrow-down"></i>
                                            @endif
                                        </td>



                                    </tr>


                                </tbody>
                            </table>


                            <div class="collapse" id="collapseExample-{{ $client->id }}">


                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>تاريخ العملية</th>
                                            <th>التفاصيل</th>
                                            <th>النوع</th>
                                            <th></th>
                                            <th>المبلغ</th>
                                            <th>الرصيد</th>

                                            <th>تعديل</th>
                                            <th>حذف</th>

                                        </tr>
                                    </thead>

                                    <tbody>

                                        {{-- adding the total dynamically --}}
                                        @php

                                            $dynamic_total = 0;

                                        @endphp


                                        @foreach ($client->transactions->sortBy('date') as $trans)
                                            @if ($trans->type == 'له')
                                                @php

                                                    $dynamic_total -= $trans->price;

                                                @endphp
                                            @else
                                                @php

                                                    $dynamic_total += $trans->price;

                                                @endphp
                                            @endif

                                            <tr>
                                                <td style="width: 20%">
                                                    <h4>{{ $trans->date }}</h4>

                                                </td>



                                                <td style="width: 25%">
                                                    <h4>{{ $trans->desc }}</h4>
                                                </td>




                                                <td style="width: 5%">

                                                    <span class="ml-3" style="font-size: 18px; font-weight : bold;">
                                                        {{ $trans->type }}</span>


                                                </td>

                                                <td style="width: 15%">

                                                    @if ($trans->type == 'له')
                                                        <i style="font-weight: bold; font-size:18px;"
                                                            class="text-success fa fa-arrow-up"></i>
                                                    @else
                                                        <i style="font-weight: bold; font-size:18px;"
                                                            class="text-danger fa fa-arrow-down"></i>
                                                    @endif

                                                </td>


                                                <td style="width: 10%">
                                                    <h4>
                                                        {{ number_format($trans->price, 2, '.', ',') }}
                                                    </h4>

                                                </td>

                                                <td style="width: 10%">
                                                    <h4>
                                                        {{ number_format($dynamic_total, 2, '.', ',') }}
                                                    </h4>

                                                </td>

                                                <td style="width: 15%;">

                                                    <button class="btn btn-info" data-toggle="modal"
                                                        data-target="#update-trans-{{ $trans->id }}"> تعديل المعاملة
                                                        المالية </button>

                                                </td>

                                                <td style="width: 15%;">

                                                    <button class="btn btn-danger delete-transaction-id" data-toggle="modal" data-target="#delete-transaction" value="{{$trans->id}}">حذف المعاملة </button>

                                                </td>


                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>


                        </div>
                    @endforeach


                </div>
            </div>
            <!--Table Head Dark End-->

        </div>

    </div>



    <div class="modal fade" id="exampleModal1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة عميل جديد </h5>
                    <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('addClient') }}" method="POST">

                        @csrf
                        <div class="row">
                            <div class="col-sm-4 mb-20">
                                <label for="name"> الأسم</label>
                                <input type="text" required id="name" name="name" class="form-control">
                            </div>

                            <div class="col-sm-4 mb-20">
                                <label for="phone"> رقم الهاتف</label>
                                <input type="text" id="phone" name="phone" class="form-control">
                            </div>

                            <div class="col-sm-4 mb-20">
                                <label for="date"> التاريخ</label>
                                <input type="date" required id="date" name="date" class="form-control">
                            </div>

                            <div class="col-sm-4 mb-20">
                                <label for="client_type"> النوع</label>

                                <select name="client_type" class="form-control" id="client_type">
                                    <option value="عملاء">عملاء</option>
                                    <option value="موردين">موردين</option>
                                    <option value="عام">عام</option>

                                </select>
                            </div>

                            <div class="col-sm-4 mb-20">
                                <label for="price"> المبلغ</label>
                                <input type="text" id="price" required name="price" min="0"
                                    step=".01" class="form-control fraction-commas">
                            </div>

                            <div class="col-sm-12 mb-20">
                                <label for="desc"> التفاصيل</label>
                                <input type="text" required id="desc" name="desc" class="form-control">
                            </div>


                            <div class="col-sm-6 mb-20 text-center">
                                <label class="radio-inline">
                                    <input type="radio" name="trans_type" value="عليه" checked>
                                    <span style="font-size: 22px;font-weight: bold;" class="text-danger">عليه</span>
                                </label>
                            </div>


                            <div class="col-sm-6 mb-20 text-center">
                                <label class="radio-inline">
                                    <input type="radio" value="له" name="trans_type">
                                    <span style="font-size: 22px;font-weight: bold;" class="text-success">له</span>
                                </label>
                            </div>





                        </div>

                </div>
                <div class="modal-footer">
                    <button class="button button-danger" data-dismiss="modal">إلغاء</button>
                    <button class="button button-primary">حفظ </button>
                </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade" id="new-trans">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة معاملة مالية </h5>
                    <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('addTransaction') }}" method="POST">

                        @csrf
                        <div class="row">

                            <input type="hidden" name="id" value="" id="modal-assign-id">

                            <div class="col-sm-4 mb-20">
                                <label for="date"> التاريخ</label>
                                <input type="date" required id="date" name="date" class="form-control">
                            </div>



                            <div class="col-sm-4 mb-20">
                                <label for="price"> المبلغ</label>
                                <input type="text" id="price" required name="price" min="0"
                                    step=".01" class="form-control fraction-commas">
                            </div>

                            <div class="col-sm-12 mb-20">
                                <label for="desc"> التفاصيل</label>
                                <input type="text" required id="desc" name="desc" class="form-control">
                            </div>


                            <div class="col-sm-6 mb-20 text-center">
                                <label class="radio-inline">
                                    <input type="radio" name="trans_type" value="عليه" checked>
                                    <span style="font-size: 22px;font-weight: bold;" class="text-danger">عليه</span>
                                </label>
                            </div>


                            <div class="col-sm-6 mb-20 text-center">
                                <label class="radio-inline">
                                    <input type="radio" value="له" name="trans_type">
                                    <span style="font-size: 22px;font-weight: bold;" class="text-success">له</span>
                                </label>
                            </div>

                        </div>

                </div>
                <div class="modal-footer">
                    <button class="button button-danger" data-dismiss="modal">إلغاء</button>
                    <button class="button button-primary">حفظ </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($clients as $client)
        <div class="modal fade" id="update-client-{{ $client->id }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">تعديل العميل </h5>
                        <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('updateClient') }}" method="POST">

                            <input type="hidden" name="id" value="{{ $client->id }}" id="">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4 mb-20">
                                    <label for="name"> الأسم</label>
                                    <input type="text" id="name" name="name" value="{{ $client->name }}"
                                        class="form-control">
                                </div>

                                <div class="col-sm-4 mb-20">
                                    <label for="phone"> رقم الهاتف</label>
                                    <input type="text" id="phone" name="phone" value="{{ $client->phone }}"
                                        class="form-control">
                                </div>


                                <div class="col-sm-4 mb-20">
                                    <label for="client_type"> النوع</label>

                                    <select name="client_type" class="form-control" id="client_type">
                                        <option value="{{ $client->type }}">{{ $client->type }}</option>

                                        <option value="عملاء">عملاء</option>
                                        <option value="موردين">موردين</option>
                                        <option value="عام">عام</option>

                                    </select>
                                </div>

                            </div>

                    </div>
                    <div class="modal-footer">
                        <button class="button button-danger" data-dismiss="modal">إلغاء</button>
                        <button class="button button-primary">حفظ </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach



    @foreach ($transactions as $trans)
        <div class="modal fade" id="update-trans-{{ $trans->id }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">تعديل معاملة </h5>
                        <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('updateTransaction') }}" method="POST">

                            <input type="hidden" name="id" value="{{ $trans->id }}" id="">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4 mb-20">
                                    <label for="date"> التاريخ</label>
                                    <input type="date" id="date" name="date" value="{{ $trans->date }}"
                                        class="form-control">
                                </div>
                                <div class="col-sm-4 mb-20">
                                    <label for="price"> المبلغ</label>
                                    <input type="number" id="price" required name="price"
                                        value="{{ $trans->price }}" min="0" step=".01" class="form-control">
                                </div>

                                <div class="col-sm-12 mb-20">
                                    <label for="desc"> التفاصيل</label>
                                    <input type="text" required id="desc" name="desc"
                                        value="{{ $trans->desc }}" class="form-control">
                                </div>


                                <div class="col-sm-6 mb-20 text-center">
                                    <label class="radio-inline">
                                        <input @if ($trans->type == 'عليه') checked @endif type="radio"
                                            name="trans_type" value="عليه">
                                        <span style="font-size: 22px;font-weight: bold;" class="text-danger">عليه</span>
                                    </label>
                                </div>


                                <div class="col-sm-6 mb-20 text-center">
                                    <label class="radio-inline">
                                        <input @if ($trans->type == 'له') checked @endif type="radio"
                                            value="له" name="trans_type">
                                        <span style="font-size: 22px;font-weight: bold;" class="text-success">له</span>
                                    </label>
                                </div>




                            </div>

                    </div>
                    <div class="modal-footer">
                        <button class="button button-danger" data-dismiss="modal">إلغاء</button>
                        <button class="button button-primary">حفظ </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <div class="modal fade" id="delete-transaction">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> حذف المعاملة </h5>
                    <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>

                <form action="{{ route('deleteTransaction') }}" method="POST">

                    <div class="modal-body">

                        @csrf

                        <input type="hidden" name="id" value="" id="modal-delete-transaction-id">

                        <div class="row">

                            <h4 class="mr-4">هل انت متأكد من حذف هذه المعاملة؟</h4>


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


@section('scripts')

    <script>
        $('.client-id').click(function() {

            // get selling id
            client_id = $(this).val();

            $('#modal-assign-id').val(client_id);

        });


        $('.delete-transaction-id').click(function() {

            // get selling id
            transaction_id = $(this).val();

            $('#modal-delete-transaction-id').val(transaction_id);

        });
    </script>
@endsection

@endsection
