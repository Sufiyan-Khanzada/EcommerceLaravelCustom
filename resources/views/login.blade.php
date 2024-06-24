@extends('layouts.main')

<style>
    .alert {
    }
    .alert-success {
    }
    .alert-error {
        background-color: #ffe8e8;
        border: 1px solid #cb8f8f;
        color: #540c0c;
    }
</style>

@section('content')

		<!-- Menu Start Section -->  
        <section id="page-title" class="background-overlay" data-parallax-image="{{asset('images/banner/banner.jpg')}}">
    <div class="container">
        <div class="page-title">
            <h1 class="text-uppercase text-medium">login</h1>
       
        </div>
    </div>
</section>
<!-- </div> -->
<section class="custom-section">
    <div class="container">
        <div class="row">
 
            
            <div class="col-md-4 col-md-offset-4">
                <div class="panel ">

                    <div class="panel-body"><h3>Login</h3>
                    <form method="POST" action="{{route('authenticate')}}">
                        @csrf
                    <div class="form-group">
                        <label class="sr-only">Email</label>
                        <input type="text" name="email" placeholder="Email" required class="form-control">
                        @error('email')
                <div style="color: red;">{{ $message }}</div>
            @enderror
                    </div>
                    <div class="form-group m-b-5">
                        <label class="sr-only">Password</label>
                        <input type="password" name="password" placeholder="Password" required class="form-control">
                        @error('password')
                <div style="color: red;">{{ $message }}</div>
            @enderror
                    </div>
                    <div class="form-group form-inline m-b-10 ">
                        
                        <div class="checkbox">
                        </div><a class="right" href="{{route('reset-password')}}"><small>Lost your Password?</small></a>
                    </div><div class="form-group">
                        
                        <input type="submit" class="btn btn-default" value="Login">
                        
                    </div>
                </form>
                </div></div><p class="small">Don't have an account yet? <a href="https://www.firequick.com/page/registration">Register New Account</a></p>
                    
                    
            </div>

        </div>
    </div>
</section><!-- Start footer -->
@endsection

@section('css')
    <style type="text/css">
        /* Add your custom CSS here */
    </style>
@endsection

@section('js')
    <script type="text/javascript">
        // Add your custom JavaScript here
    </script>
@endsection
