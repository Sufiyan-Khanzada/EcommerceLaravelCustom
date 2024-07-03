@extends('layouts.main')
@section('content')

<section id="page-title" class="background-overlay" data-parallax-image="https://www.firequick.com/assets/images/banner/banner.jpg">
    <div class="container">
        <div class="page-title">
            <h1 class="text-uppercase text-medium">reset&nbsp;&nbsp;password</h1>
       
        </div>
    </div>
</section>
<section class="custom-section">
    <div class="container">
        <div class="row">

 
            <div class="col-sm-6 col-sm-offset-3">
                <div class="panel ">

  <div class="panel-body"><h3>Login</h3>
                    <form method="POST" action="{{route('recover-password-form')}}">
                        @csrf
                    <div class="form-group">
                         
                    
					<div class="form-group">
						<p class="center">To receive a new password, enter your email address below.</p>
						<input type="email" name="email" class="form-control form-white placeholder" placeholder="Enter your email..." required="">
					</div>
					<div class="text-center">
						
						<input type="submit" class="btn btn-default" value="Recover your Password">
					</div>
				</form>
                    
                    
            </div>

        </div>
    </div>
</section>



@endsection 