@extends('layouts.main') 
@section('content')

<section id="page-title" class="background-overlay" data-parallax-image="https://www.firequick.com/assets/images/banner/banner.jpg">
	<div class="container">
		<div class="page-title">
			<h1 class="text-uppercase text-medium">User Update</h1> </div>
	</div>
</section>
<!-- </div> -->
<section class="custom-section">
	<div class="container">
		<div class="row">
			<div class="col-md-10 center no-padding">
				<div id="error">
					<p style="color:red;font-size:15px;font-weight:bold;"></p>
				</div>
				<div class="col-md-6 form-group">
					<form method="POST" action="#">
						<label class="">First Name</label>
						<input type="text" name="fname" class="form-control input-lg" placeholder="First Name" value="Sufiyan" id="fname"> </div>
				<div class="col-md-6 form-group">
					<label class="">Last Name</label>
					<input type="text" name="lname" class="form-control input-lg" placeholder="Last Name" value="Ahmed" id="lname"> </div>
				<div class="col-md-6 form-group">
					<label class="">Email</label>
					<input type="email" name="email" class="form-control input-lg" placeholder="Email" value="sufiyankhanzada748@gmail.com" id="email" disabled> </div>
				<div class="col-md-6 form-group">
					<label class="">Organization / Company</label>
					<input type="text" name="company" class="form-control input-lg" placeholder="Organization" value="ABC" id="company"> </div>
				<div class="col-md-6 form-group">
					<label class="">Password</label>
					<input type="password" name="password" class="form-control input-lg" placeholder="Password" value="" id="password"> </div>
				<div class="col-md-12 form-group ">
					<label class="">Address</label>
					<input type="text" name="address1" class="form-control input-lg" placeholder="Street" value="Hyderabad" id="address1"> </div>
				<div class="col-md-6 form-group">
					<input type="text" name="address2" class="form-control input-lg" placeholder="Apartment, Unit, etc" value="hyderabad" id="address2"> </div>
				<div class="row"></div>
				<div class="col-md-5 form-group" style="margin-right:5%">
					<label class="">Country</label>
					<select name="country" id="country" class="mycountry">
						<option value="167">Pakistan</option>
					</select>
				</div>
				<div class="col-md-5 form-group">
					<label>State</label>
					<select name="state" id="state">
						<option value="3172">Azad Kashmir</option>
						<option value='3172'>Azad Kashmir</option>
						<option value='3174'>Balochistan</option>
						<option value='3173'>Federally Administered Tribal Areas</option>
						<option value='3170'>Gilgit-Baltistan</option>
						<option value='3169'>Islamabad Capital Territory</option>
						<option value='3171'>Khyber Pakhtunkhwa</option>
						<option value='3176'>Punjab</option>
						<option value='3175'>Sindh</option>
					</select>
				</div>
				<div class="col-md-6 form-group">
					<label>City</label>
					<input type="text" name="city" class="form-control input-lg" placeholder="City" value="hyderabad" id="city"> </div>
				<div class="col-md-6 form-group">
					<label class="">Postcode / Zip</label>
					<!-- <input type="text" name="postcode" class="form-control input-lg" placeholder="Postcode / Zip" value="710000" id="postcode"> -->
					<input type="text" name="postcode" class="form-control input-lg" placeholder="Postcode / Zip" value="710000" id="postcode"> </div>
				<div class="col-md-6 form-group">
					<label class="">Phone </label>
					<input type="text" class="form-control input-lg" name="phone" value="" placeholder="03461351500"> </div>
				<div class="col-md-12 form-group">
					<input type="submit" class="btn btn-default submit" value="Update"> </div>
			</div>
			</form>
		</div>
	</div>
	<p id="result"></p>
</section>
<!--<script src="https://www.firequick.com/assets/jquery-3.2.1.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
	var jq14 = jQuery.noConflict(true);
	$("#state").select2();
	$(".mycountry").select2();
	var agree = true;
	if(agree == true) {
		$.ajax({
			url: 'https://www.firequick.com/get/country',
			type: 'POST',
			success: function(data, status, xhr) {
				var json = $.parseJSON(data);
				$(json).each(function(i, val) {
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
	$('.mycountry').change(function() {
		$('#state').parent().show();
		$('#city').parent().show();
		$('#state').html('');
		var CountryID = $(this).val();
		if(CountryID != 0 && CountryID != '') {
			$.ajax({
				url: 'https://www.firequick.com/get/state',
				type: 'POST',
				data: {
					country_id: CountryID
				},
				success: function(data, status, xhr) {
					if(data != "false") {
						var json = $.parseJSON(data);
						$(json).each(function(i, val) {
							$('#state').append('<option value="' + val.id + '">' + val.name + '</option>');
							// console.log(val);
						});
					} else {
						$('#state').parent().hide();
						$('#city').parent().hide();
						$('#city').val('');
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
</script> 
@endsection