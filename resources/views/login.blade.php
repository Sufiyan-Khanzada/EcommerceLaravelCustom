@extends('layouts.main')

@section('content')
    <!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Login</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start Contact Us  -->
    <div class="contact-box-main">
        <div class="container">
            <div class="row justify-content-center"> <!-- Center the content horizontally -->
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-body">
                            <h3>Login</h3>
                            <form method="POST" action="https://www.firequick.com/form/login_submit">
                                <div class="form-group">
                                    <label class="sr-only">Email</label>
                                    <input type="text" name="email" placeholder="Email" class="form-control">
                                </div>
                                <div class="form-group m-b-5">
                                    <label class="sr-only">Password</label>
                                    <input type="password" name="password" placeholder="Password" class="form-control">
                                </div>
                                <div class="form-group form-inline m-b-10">
                                    <div class="checkbox">
                                        <!-- <label>
                                            <input type="checkbox"><small> Remember me</small>
                                        </label> -->
                                    </div>
                                    <a class="right" href="https://www.firequick.com/page/reset-password"><small>Lost your Password?</small></a>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-default" value="Login">
                                </div>
                            </form>
                        </div>
                    </div>
                    <p class="small">Don't have an account yet? <a href="https://www.firequick.com/page/registration">Register New Account</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contact Us -->

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
