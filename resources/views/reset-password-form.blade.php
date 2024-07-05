@extends('layouts.main')
@section('content')

<section id="page-title" class="background-overlay" data-parallax-image="https://www.firequick.com/assets/images/banner/banner.jpg"><div class="parallax-container" data-velocity="-.090" style="background: url(https://www.firequick.com/assets/images/banner/banner.jpg)"></div>
    <div class="container">
        <div class="page-title">
            <h1 class="text-uppercase text-medium">RESET-PASSWORD-FORM</h1>
       
        </div>
    </div>
</section>

<section class="custom-section">
    <div class="container">
        <div class="row">

        @if ($errors->any())

        
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
        {{ $error }}
    </div>
            @endforeach
      
  
@endif





            <div class="col-md-4 col-md-offset-4">
                <div class="panel ">

  <div class="panel-body"><h3>Login</h3>
  <form method="POST" action="{{ route('reset-password-update', ['email' => $email, 'hash' => $hash]) }}">
  @csrf
                    <div class="form-group">
                         
                        

                    </div>
                    <div class="form-group m-b-5">
                        <label class="sr-only">Password</label>
                        <input type="hidden" name="email" value="{{ $email }}">
                        <input type="hidden" name="token" value="{{ $hash }}">
                        <input type="password" name="password" placeholder="Password" class="form-control">
                        <label class="sr-only">Confirm password</label>
                        <input type="password" name="cpassword" placeholder="Confirm password" class="form-control">
                    </div>
                    <div class="form-group form-inline m-b-10 ">
                        
                        <div class="checkbox">
                            <!-- <label>
                                <input type="checkbox"><small> Remember me</small>
                            </label> -->
                        </div>
                    </div><div class="form-group">
                        
                        <input type="submit" class="btn btn-default" value="RESET">
                        
                    </div>
                </form>
                    
                    
            </div>

        </div>
    </div>
</div></div></section>


@endsection