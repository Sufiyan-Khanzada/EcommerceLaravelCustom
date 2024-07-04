@extends('layouts.main') 

@section('content')
<!-- Menu Start Section -->
<section id="page-title" class="background-overlay" data-parallax-image="{{asset('images/banner/banner.jpg')}}">
	<div class="container">
		<div class="page-title">
			<h1 class="text-uppercase text-medium">Registration</h1> </div>
	</div>
</section>
<!-- </div> -->
<section class="custom-section">
	<div class="container">
		<div class="row">
		<form action="{{ route('register-user') }}" method="POST">
    @csrf
    <div class="col-md-8 center no-padding">
        <div class="col-md-12">
            <h3>Register New Account</h3>
            <p>Create an account by entering the information below. If you are a returning customer, please login at the top of the page.</p>
        </div>
        
        <div class="col-md-6 form-group">
            <label>First Name</label>
            <input type="text" name="fname" required class="form-control input-lg" placeholder="First Name" value="{{ old('fname') }}" id="fname">
            @error('fname')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="col-md-6 form-group">
            <label>Last Name</label>
            <input type="text" name="lname" required class="form-control input-lg" placeholder="Last Name" value="{{ old('lname') }}" id="lname">
            @error('lname')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="col-md-6 form-group">
            <label>Email</label>
            <input type="email" name="email" required class="form-control input-lg" placeholder="Email" value="{{ old('email') }}" id="email">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="col-md-6 form-group">
            <label>Organization / Company</label>
            <input type="text" name="company" required class="form-control input-lg" placeholder="Organization" value="{{ old('company') }}" id="company">
            @error('company')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="col-md-6 form-group">
            <label>Password</label>
            <input type="password" name="password" required class="form-control input-lg" placeholder="Password" id="password">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="col-md-12 form-group">
            <label>Address</label>
            <input type="text" name="address1" required class="form-control input-lg" placeholder="Street" value="{{ old('address1') }}" id="address1">
            @error('address1')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="col-md-6 form-group">
            <input type="text" name="address2" required class="form-control input-lg" placeholder="Apartment, Unit, etc" value="{{ old('address2') }}" id="address2">
            @error('address2')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="col-md-6 form-group">
            <label>Country</label>
            <select name="country" id="country" required class="mycountry">
                <option value="">select</option>
                <!-- Options should be populated here -->
            </select>
            @error('country')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="col-md-6 form-group">
            <label>State</label>
            <select name="state" id="state"  style="width: 100% !important">
                <option value="">select</option>
                <!-- Options should be populated here -->
            </select>
            @error('state')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="col-md-6 form-group">
            <label>City</label>
            <input type="text" name="city" class="form-control input-lg" placeholder="City" value="{{ old('city') }}" id="city">
            @error('city')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="col-md-6 form-group">
            <label>Postcode / Zip</label>
            <input type="text" name="postcode" required class="form-control input-lg" placeholder="Postcode / Zip" value="{{ old('postcode') }}" id="postcode">
            @error('postcode')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="col-md-6 form-group">
            <label>Phone</label>
            <input type="text" name="phone" required class="form-control input-lg" placeholder="Phone" value="{{ old('phone') }}" id="phone">
            @error('phone')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="col-md-12 form-group">
            <button type="submit" class="btn btn-default submit">Register New Account</button>
        </div>
    </div>
</form>

		</div>
	</div>
</section>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
<!--<script src="https://www.firequick.com/assets/jquery-3.2.1.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
	var agree = true;
	if(agree == true) {
		$.ajax({
			url: '{{route("allCountries")}}',
			type: 'GET',
			success: function(data, status, xhr) {
				$(data).each(function(i, val) {
					$('#country').append('<option value="' + val.id + '">' + val.name + '</option>');
				});
			},
			error: function(jqXhr, textStatus, errorMessage) {
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
	if(CountryID != 0 && CountryID != '') {
		$.ajax({
			url: '{{route("allStates")}}/'.CountryID,
			type: 'GET',
			success: function(data, status, xhr) {
				if(data != "false") {
					var json = $.parseJSON(data);
					$(json).each(function(i, val) {
						$('#state').append('<option value="' + val.id + '">' + val.name + '</option>');
					});
				} else {
					$('#state').parent().hide();
					$('#city').parent().hide();
				}
			},
			error: function(jqXhr, textStatus, errorMessage) {
				alert(jqXhr);
				alert(textStatus);
				alert(errorMessage);
			}
		});
	}
	$('.submit').on('click', function(e) {
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
		if(fname == '' || lname == '' || email == '' || password == '' || address1 == '' || country == '' || postcode == '' || phone == '' || company == '') {
			e.preventDefault();
		}
		if(fname == '') {
			validate('First Name');
		}
		if(lname == '') {
			validate('Last Name');
		}
		if(email == '') {
			validate('Email');
		}
		if(password == '') {
			validate('Password');
		}
		if(address1 == '') {
			validate('Address');
		}
		if(country == '') {
			validate('Country');
		}
		if(postcode == '') {
			validate('Postcode');
		}
		if(phone == '') {
			validate('Phone');
		}
		if(company == '') {
			validate('Company');
		}
	});
});

function validate(data) {
	$('#error').append('<p style="color:red;font-size:15px;font-weight:bold;">*' + data + ' is required</p>');
}
</script>
<script>
$(document).ready(function() {
	//change selectboxes to selectize mode to be searchable
	var jq14 = jQuery.noConflict(true);
	$(document).ready(function() {
		$("#state").select2();
		$("#country").select2();
		$('#country').change(function() {
			$('#state').parent().show();
			$('#city').parent().show();
			$('#state').html('');
			var CountryID = $(this).val();
			if(CountryID != 0 && CountryID != '') {
				$.ajax({
					url: '{{route("allStates")}}/' + CountryID,
					type: 'GET',
					success: function(data, status, xhr) {
						if(data != "false") {
							$(data).each(function(i, val) {
								$('#state').append('<option value="' + val.id + '">' + val.name + '</option>');
							});
						} else {
							$('#state').parent().hide();
							$('#city').parent().hide();
						}
					},
					error: function(jqXhr, textStatus, errorMessage) {
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