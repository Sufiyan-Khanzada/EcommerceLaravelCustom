@extends('layouts.main')

@section('content')
    <!-- Menu Start Section -->


<section id="page-title" class="background-overlay" data-parallax-image="{{asset('images/banner/banner.jpg')}}">
    <div class="container">
        <div class="page-title">
            <h1 class="text-uppercase text-medium">registration</h1>
       
        </div>
    </div>
</section>
<!-- </div> -->

<section class="custom-section">
    <div class="container">
        <div class="row">
            <form action="{{route('register-user')}}" method="POST">
                @csrf
                <div class="col-md-8 center no-padding">
                        <div class="col-md-12">
                            <h3>Register New Account</h3>
                        <p>Create an account by entering the information below. If you are a returning customer please login at the top of the page.</p></div>
                        
                        <div id="error"><p style="color:red;font-size:15px;font-weight:bold;"></p></div>
                        
                        <div class="col-md-6 form-group">
                            <label class="">First Name</label>
                            <input type="text" name="fname" class="form-control input-lg" placeholder="First Name" value="" id="fname">
                        </div><div class="col-md-6 form-group">
                            <label class="">Last Name</label>
                            <input type="text" name="lname" class="form-control input-lg" placeholder="Last Name" value="" id="lname">
                        </div>
                        
                        <div class="col-md-6 form-group">
                            <label class="">Email</label>
                            <input type="email" name="email" class="form-control input-lg" placeholder="Email" value="" id="email">
                        </div>


                        <div class="col-md-6 form-group">
                        <label class="">Organization / Company</label>
                            <input type="text" name="company" class="form-control input-lg" placeholder="Organization" value="" id="company">
                            
                        </div>

                        <div class="col-md-6 form-group">
                        <label class="">Password</label>
                            <input type="password" name="password" class="form-control input-lg" placeholder="Password" value="" id="password">
                            
                        </div>

                        
                        <div class="col-md-12 form-group ">
                            <label class="">Address</label>
                            <input type="text" name="address1" class="form-control input-lg" placeholder="Street" value="" id="address1">
                        </div>

                        <div class="col-md-6 form-group">
                            
                            <input type="text" name="address2" class="form-control input-lg" placeholder="Apartment, Unit, etc" value="" id="address2">
                        </div>
                        <div class="row"></div>
                        <div class="col-md-6 form-group">
                            <label class="">Country</label>
                            
                            <select name="country" id="country" class="mycountry">
                                    <option value="">select</option>
                                    
                                
                            </select>
                        </div>
                        
                        
                        <div class="col-md-6 form-group">
                            <label >State</label>
                            <select name="state" id="state" style="width: 100% !important">
                                    <option value="">select</option>
                            </select>
                        </div>
                        
                       
                        <div class="col-md-6 form-group">
                            <label >City</label>
                            <input type="text" name="city" class="form-control input-lg" placeholder="City" value="" id="city">
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="">Postcode / Zip</label>
                            <input type="text" name="postcode" class="form-control input-lg" placeholder="Postcode / Zip" value="" id="postcode">
                        </div>
                        
                        <div class="col-md-6 form-group">
                            <label class="">Phone</label>
                            <input type="text" name="phone" class="form-control input-lg" placeholder="Phone" value="" id="phone">
                        </div>

                        <div class="col-md-12 form-group">
                            <button type="submit" class="btn btn-default submit">Register New Account </button>
                                
                        
                        </div>
                        
                    </div>
                </form>


        </div>
    </div>

    <p id="result"></p>
</section>



<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
<!--<script src="https://www.firequick.com/assets/jquery-3.2.1.min.js"></script>-->


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<script>

    $(document).ready(function(){
        
        var agree = true;
        if(agree == true){
            $.ajax({
                url: '{{route("getCountries")}}',
                type: 'GET',
                success: function (data, status, xhr) {
                    $(data).each(function(i,val){
                        $('#country').append('<option value="'+val.id+'">'+val.name+'</option>');
                    });
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    alert(jqXhr);
                    alert(textStatus);
                    alert(errorMessage);                      
                }
            }); 
        }
        
        $('#state').parent().hide();
        $('#city').parent().hide();
        $('#state').html('');

        var CountryID = $(this).val();        
             
        if(CountryID != 0 && CountryID != ''){
            $.ajax({
                url: '{{route("getStates")}}/'.CountryID,
                type: 'GET',
                success: function (data, status, xhr) {
                        
                    if(data != "false"){
                        var json = $.parseJSON(data);
                        $(json).each(function(i,val){
                                
                            $('#state').append('<option value="'+val.id+'">'+val.name+'</option>');
                        });    
                    }else{
                        $('#state').parent().hide();
                        $('#city').parent().hide();
                    }

                        
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    alert(jqXhr);
                    alert(textStatus);
                    alert(errorMessage);
                          
                }
            }); 
        }

        $('.submit').on('click',function(e){
            $('#error').html('');            
            var fname = $('#fname').val();
            var lname = $('#lname').val();
            var email = $('#email').val();
            var company = $('#company').val();
            var password = $('#password').val();
            var address1 = $('#address1').val();
            var country = $('#country').val();
            var postcode = $('#postcode').val();
            var phone = $('#phone').val();            
            if(fname == '' || lname =='' || email == ''|| password == '' || address1 == '' || country == '' ||  postcode == '' || phone == ''|| company == '' ){
                
                e.preventDefault();
            }
            if(fname == ''){
               validate('First Name');                
            }
            if(lname == ''){
               validate('Last Name');
            }
            if(email == ''){
                validate('Email');
            }
            if(password == ''){
                validate('Password');
            }
            if(address1 == ''){
                validate('Address');
            }
            if(country == ''){
                validate('Country');
            }
            if(postcode == ''){
                validate('Postcode'); 
            }
            if(phone == ''){
                validate('Phone');
            }  
            if(company == ''){
                validate('Company');
            }         
        });
    });

function validate(data){
    $('#error').append('<p style="color:red;font-size:15px;font-weight:bold;">*'+data+' is required</p>');
}

</script>


<script>
    
    $(document).ready(function () {
//change selectboxes to selectize mode to be searchable
    var jq14 = jQuery.noConflict(true);
    
 
    $(document).ready(function () {

            $("#state").select2();
            $("#country").select2();
            $('#country').change(function(){
        
            $('#state').parent().show();
            $('#city').parent().show();
            $('#state').html('');

            var CountryID = $(this).val();
             
             if(CountryID != 0 && CountryID != ''){
                $.ajax({
                    url: '{{route("getStates")}}/'+CountryID,
                    type: 'GET',
                    success: function (data, status, xhr) {
                        
                        if(data != "false"){
                            $(data).each(function(i,val){
                                $('#state').append('<option value="'+val.id+'">'+val.name+'</option>');
                            });    
                        }else{
                            $('#state').parent().hide();
                            $('#city').parent().hide();
                        }

                        
                    },
                    error: function (jqXhr, textStatus, errorMessage) {
                        alert(jqXhr);
                        alert(textStatus);
                        alert(errorMessage);
                          
                    }
                }); 
             }

        }); 
    });

});
</script>

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
