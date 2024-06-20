@extends('layouts.main')
@section('content')



<!-- Menu Start Section -->



<section id="page-title" class="background-overlay" data-parallax-image="{{asset('images/banner/banner.jpg')}}">
    <div class="container">
        <div class="page-title">
            <h1 class="text-uppercase text-medium">cart</h1>

        </div>
    </div>
</section>

@if($cartItems)
<?php
$session = \Session::get('cart_contents');
$handling_fee = $session['handling_fee'];
$total_items = $session['total_items'];
$cart_total = $session['cart_total'];
?>


<section id="shop-cart">
    <div class="container">
        <div class="shop-cart">

            <div class="table table-condensed table-striped table-responsive">


                <table class="table">
                    <thead>
                        <tr>
                            <th class="cart-product-remove"></th>
                            <th class="cart-product-thumbnail">Product</th>

                            <th class="cart-product-price">Unit Price</th>
                            <th class="cart-product-quantity">Quantity</th>
                            <th class="cart-product-subtotal">Sub-Total</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach ($cartItems as $key => $val)
                 
                        <tr>
                            <td class="cart-product-remove">
                                <a class="remove" id="{{$key}}" href="#"><i class="fa fa-close"></i></a>


                            </td>

                            <td class="cart-product-discripition">

                                <div class="cart-product-thumbnail-name">
                                    <a href='javascript:void(0)'>{{ucfirst($val['title'])}}</a>
                                </div>
                            </td>


                            <td class="cart-product-price">
                                <span class="amount">${{$val['price']}}</span>
                            </td>
                            <td class="cart-product-quantity">
                                <div class="quantity">
                                    <input type="text" class="qty" value="{{$val['qty']}}" name="quantity" disabled="">

                                </div>
                            </td>
                            <td class="cart-product-subtotal">
                                <span class="amount">${{$val['subtotal']}}</span>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>

                </table>

            </div>
            <div class="row">

                <div class="col-md-6 form-group">
                    <!-- <label class="sr-only">State / County</label> -->
                    <label>Additional Note:</label>
                    <!-- <input type="text" class="form-control input-lg" placeholder="State / County" value=""> -->
                    <textarea class="form-control input-lg" id="additional_note" style="border: 2px solid coral;"></textarea>

                    <!-- <input type="button" class="btn btn-default" id="addnote" value="Click to add">  -->
                </div>

            </div>



            <div class="row">
                <div class="col-md-4">
                    <!-- <button type="button" class="btn btn-default">Back to shopping</button> -->

                    <a href="{{route('home')}}" class="btn btn-default">Back to shopping</a>
                </div>

            </div>

            <div class="row">
                <hr class="space">
                <div class="col-md-6">

                </div>
                <div class="col-md-6 p-r-10 ">
                    <div class="table-responsive">


                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="cart-product-name">
                                        <strong>Cart Subtotal</strong>
                                    </td>

                                    <td class="cart-product-name text-right">
                                        <span class="amount" id="subtotal">${{$cart_total}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cart-product-name">
                                        <strong>Shipping</strong>
                                    </td>
                               <!-- Destination country code missing or invalid  -->
                               <td class="cart-product-name  text-right">
                                        <span class="amount">$0
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cart-product-name">
                                        <strong>Tax</strong>
                                    </td>

                                    <td class="cart-product-name text-right">
                                        <span class="amount">$0</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cart-product-name">
                                        <strong>Handling Fee</strong>
                                    </td>

                                    <td class="cart-product-name text-right">
                                        <span class="amount">${{$handling_fee}}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="cart-product-name">
                                        <strong>Total</strong>
                                    </td>

                                    <td class="cart-product-name text-right">
                                        <span class="amount color lead"><strong>${{$cart_total}}</strong></span>
                                    </td>
                                </tr>
                            </tbody>

                        </table>

                    </div>

                    <!-- <span style='text-align: left !important;float: left;'>Your Account is not verified and cannot proceed with Restricted Product.</span> -->
                </div>
            </div>





        </div>
    </div>

</section>


@else
<section id="shop-cart">
    <div class="container text-center">
       
<h1 class="text-dark">Cart Is Empty!</h1>

</div>
</section>
@endif


<script src="https://www.firequick.com/assets/jquery-3.2.1.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function(){
            $('.addr_chk').change(function () {
                var status  = $(this).val()
                if (status == 0) {
                    $('.new_addr').hide();
                    $('#address1').removeAttr('required');
                    $('#city').removeAttr('required');
                    $('#postalcode').removeAttr('required');
                    $('#phone').removeAttr('required');
                }
                if (status == 1) {
                    $('.new_addr').show()
                    $('#address1').attr('required' , 'required');
                    $('#city').attr('required' , 'required');
                    $('#postalcode').attr('required' , 'required');
                    $('#phone').attr('required' , 'required');
                }
            })

            var loading = '<svg class="loading-img" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background-image: none; display: block; shape-rendering: auto;" width="40px" height="40px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><g transform="translate(50 50)"><g transform="scale(0.7)"><g transform="translate(-50 -50)"><g><animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" values="0 50 50;360 50 50" keyTimes="0;1" dur="0.7575757575757576s"></animateTransform><path fill-opacity="0.8" fill="#93dbe9" d="M50 50L50 0A50 50 0 0 1 100 50Z"></path></g><g><animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" values="0 50 50;360 50 50" keyTimes="0;1" dur="1.0101010101010102s"></animateTransform><path fill-opacity="0.8" fill="#689cc5" d="M50 50L50 0A50 50 0 0 1 100 50Z" transform="rotate(90 50 50)"></path></g><g><animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" values="0 50 50;360 50 50" keyTimes="0;1" dur="1.5151515151515151s"></animateTransform><path fill-opacity="0.8" fill="#5e6fa3" d="M50 50L50 0A50 50 0 0 1 100 50Z" transform="rotate(180 50 50)"></path></g><g><animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" values="0 50 50;360 50 50" keyTimes="0;1" dur="3.0303030303030303s"></animateTransform><path fill-opacity="0.8" fill="#3b4368" d="M50 50L50 0A50 50 0 0 1 100 50Z" transform="rotate(270 50 50)"></path></g></g></g></g></svg>';
            $('#paytraceForm').on('submit' , function (e) {
                e.preventDefault();
                $('.payment-loader').show();
                $('.trans-errors').html('');
                $('.trans-success').html('');
                var form_data = $(this).serialize();
                $.ajax({
                    method:'POST',
                    url:"https://www.firequick.com/paytrace/send",
                    data:form_data,
                    beforeSend: function() {
                        $('#checkoutSubmitButton').parent().append(loading);
                        $('#checkoutSubmitButton').hide();
                    },
                    error: function (jqXhr, textStatus, errorMessage) {
                        
                        $('#checkoutSubmitButton').show();
                          alert(textStatus);
                          alert(errorMessage);
                          
                    },
                    success:function(response){
                    //   console.log(response);
                        response = $.parseJSON(response);
                        // console.log(response);
                        $('.payment-loader').hide();
                        
                        if (response.cart_error == true && response.cart == 'update' ) {
                            $('.payment-loader').hide();
                            $('.loading-img').hide();
                            $('.trans-errors').html(response.api_error);
                            if (response.cart == 'update') {
                                redirect = "{{route('cart')}}"; 
                                setTimeout(function() {
                                    window.location.replace(redirect)
                                }, 500)
                            }
                        }
                        
                       
                        if (response.error == true || response.error != '') {
                            $('.payment-loader').hide();
                            $('.loading-img').hide();
                            $('#checkoutSubmitButton').show();
                            if (response.api_error != '' || response.api_error != null) {
                                $('.trans-errors').html(response.api_error);
                            }
                        }
                        if(response.success == true || response.success != ''){
                            $('.payment-loader').hide();
                            $('.loading-img').hide();
                            $('.trans-success').html(response.status_message);
                            redirect = "{{route('myaccount')}}"; 
                            setTimeout(function() {
                                window.location.replace(redirect);
                            }, 500)
                        }
                        if(typeof response.cart_error == 'undefined' ){
                            if(response.success == false){
                                $('.payment-loader').hide();
                                $('.loading-img').hide();
                                $('#checkoutSubmitButton').show();
                                rs_errors = response.errors;
                                    $('.trans-errors').html('');
                                for(x in rs_errors){
                                    $('.trans-errors').append(rs_errors[x]+"<br>");
                                }
                            }
                            
                        }
                        
                    }

                })
            })

            $('#additional_note').keyup(function(){
                

                            
                var note = $('#additional_note').val();

                $.ajax({
                    url: 'https://www.firequick.com/form/addtonote',
                    type: 'POST',
                    // dataType : "json",
                    data: {note: note}, 
                   success: function (data, status, xhr) {                                           
                        // $('#additional_note').val(note);
                         // $('#additional_note').attr("disabled", "disabled");
                         // $("#additional_note").css("border", "0px");
                         // $('#addnote').remove();
                    },
                    error: function (jqXhr, textStatus, errorMessage) {
                        
                          alert(textStatus);
                          alert(errorMessage);
                          
                    }
                });
            
                  
                
            });

            $('.remove').on('click',function(e){
                e.preventDefault();
                var cart_id = $(this).attr('id');
                // console.log(cart_id);
                rm = $(this);



                
                var agree = confirm('Are you sure?');
                    if(agree == true){

                        $.ajax({
                            url: "{{route('removeFromCart')}}",
                            type: 'POST',
                            data: {  _token: '{{ csrf_token() }}', myDataid: cart_id}, 
                           success: function (data, status, xhr) {
                                  
                            alert('cart updated');
                            location.reload();
                                //   window.location.replace($(location).attr('href'));
                                

                                

                            },
                            error: function (jqXhr, textStatus, errorMessage) {
                                //   alert(textStatus);
                                  alert(errorMessage);
                                  
                            }
                        }); 

                    }

            });

            
          var jq14 = jQuery.noConflict(true);
          $("#state").select2();
          $(".mycountry").select2();
               
        var agree = true;
        if(agree == true){
            $.ajax({
                url: 'https://www.firequick.com/get/country',
                type: 'POST',
                success: function (data, status, xhr) {
                    var json = $.parseJSON(data);
                    $(json).each(function(i,val){
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
        $('.mycountry').change(function(){
            $('#state').parent().show();
            $('#city').parent().show();
            $('#state').html('');

            var CountryID = $(this).val();
             
             if(CountryID != 0 && CountryID != ''){
                $.ajax({
                    url: 'https://www.firequick.com/get/state',
                    type: 'POST',
                    data: {country_id: CountryID}, 
                    
                    success: function (data, status, xhr) {
                        
                        if(data != "false"){
                            var json = $.parseJSON(data);
                            $(json).each(function(i,val){
                                
                                $('#state').append('<option value="'+val.id+'">'+val.name+'</option>');
                                // console.log(val);
                            });    
                        }else{
                            $('#state').parent().hide();
                            $('#city').parent().hide();
                            $('#city').val('');

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
                    
    </script>
    


@endsection
@section('css')
<style type="text/css">

</style>
@endsection

@section('js')
<script type="text/javascript">
    (() => {

    })()
</script>
@endsection