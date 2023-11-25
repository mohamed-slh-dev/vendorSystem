

    @if ($message = Session::get('success'))

    <div class=" alert rounded bg-success text-white text-center mt-3 py-3">

        <button type="button" style="background: transparent;border: none;color: white;" class="close" data-dismiss="alert">×</button>
        
        <i class="fa fa-check"></i> 
        <span style="font-weight: bold; color:white; font-size: 18px">{{ $message }}</span> 

    </div>

    {{Session::forget('success')}}
    @endif

    @if ($message = Session::get('warning'))

    <div class=" alert rounded bg-warning text-white text-center mt-3 py-3">

        <button type="button" style="background: transparent;border: none;color: white;" class="close" data-dismiss="alert">×</button>
        
        <i class="fa fa-cross"></i> 
        <span style="font-weight: bold; color:white; font-size: 18px">{{ $message }}</span> 

    </div>

    {{Session::forget('warning')}}
    @endif

   


