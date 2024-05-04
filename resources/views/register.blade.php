@extends('layouts.main')

@section('content')
    <!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Registration</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start Registration Form -->
    <div class="contact-box-main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form action="https://www.firequick.com/form/user_register_submit" method="POST">
                        <div class="panel">
                            <div class="panel-body">
                                <h3>Register New Account</h3>
                                <p>Create an account by entering the information below. If you are a returning customer, please login at the top of the page.</p>
                                <div id="error">
                                    <p style="color:red; font-size:15px; font-weight:bold;"></p>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>First Name</label>
                                        <input type="text" name="fname" class="form-control input-lg" placeholder="First Name" value="" id="fname">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Last Name</label>
                                        <input type="text" name="lname" class="form-control input-lg" placeholder="Last Name" value="" id="lname">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control input-lg" placeholder="Email" value="" id="email">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Organization / Company</label>
                                        <input type="text" name="company" class="form-control input-lg" placeholder="Organization" value="" id="company">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control input-lg" placeholder="Password" value="" id="password">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label>Address</label>
                                        <input type="text" name="address1" class="form-control input-lg" placeholder="Street" value="" id="address1">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="text" name="address2" class="form-control input-lg" placeholder="Apartment, Unit, etc" value="" id="address2">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Country</label>
                                        <select name="country" id="country" class="form-control input-lg">
                                            <option value="">Select Country</option>
                                            <!-- Add your country options here -->
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>State</label>
                                        <select name="state" id="state" class="form-control input-lg">
                                            <option value="">Select State</option>
                                            <!-- Add your state options here -->
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>City</label>
                                        <input type="text" name="city" class="form-control input-lg" placeholder="City" value="" id="city">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Postcode / Zip</label>
                                        <input type="text" name="postcode" class="form-control input-lg" placeholder="Postcode / Zip" value="" id="postcode">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control input-lg" placeholder="Phone" value="" id="phone">
                                    </div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <button type="submit" class="btn btn-default submit">Register New Account</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Registration Form -->
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
