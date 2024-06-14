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
 
            @if(session('message'))
            <div style="
                padding: 13px 21px;
                border-radius: 3px;
                background-color: #e8ffe8;
                border: 1px solid #8fcb8f;
                color: #0c540c;
                max-width: 500px;
                margin: auto;
            ">
                {{ session('message') }}
            </div>
            @endif
            
            @if(session('error'))
            <div style="
                padding: 13px 21px;
                border-radius: 3px;
                background-color: #ffe8e8;
                border: 1px solid #cb8f8f;
                color: #540c0c;
                max-width: 500px;
                margin: auto;
            ">
                {{ session('error') }}
            </div>
            @endif

            <div class="col-md-4 col-md-offset-4">
                <div class="panel ">

                    <div class="panel-body"><h3>Login</h3>
                    <form method="POST" action="{{route('authenticate')}}">
                        @csrf
                    <div class="form-group">
                        <label class="sr-only">Email</label>
                        <input type="text" name="email" placeholder="Email" class="form-control">
                    </div>
                    <div class="form-group m-b-5">
                        <label class="sr-only">Password</label>
                        <input type="password" name="password" placeholder="Password" class="form-control">
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
