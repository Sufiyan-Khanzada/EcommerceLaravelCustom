@extends('myaccount.layout') 

@section('myaccount-content')


    <ul type="none">
        @php
            $customer = Auth::guard('customer')->user();
        @endphp
        <li>
            @if ($customer && $customer->workbook_status == 1)
                <p><a href="{{ route('downloadWorkbook') }}">
                    <div class="col-md-9">
             

             <p>You can Download from Here</p><p><a href="https://www.firequick.com/page/myaccount/download-workbook"><img src="https://www.firequick.com/assets/images/pdf-icon.png" width="10%" height="15%"></a>

     </p></div></a></p>
            @else
                <p>You haven't purchased the workbook yet.</p>
            @endif
        </li>
    </ul>


@endsection
