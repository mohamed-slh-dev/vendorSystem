@extends('layouts.app')

@section('title', 'الرئيسية')

@section('content')
    
<form action="{{route('updateCurrency')}}" method="POST">
    @csrf

    <div class="row">
        <div class="col-sm-4 mb-20">
            <label for="number"> الريال السعودي مقابل الدينار الأردني</label>
            <input type="number" required id="number" name="price" min="0" step=".001" value="{{$price}}" class="form-control" >
        </div>

        <div class="col-sm-12">
            <button type="submit" class="button button-primary" > تحديث </button>

        </div>
    </div>
</form>
@endsection