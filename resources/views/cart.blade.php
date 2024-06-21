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
$workbook = false;
$session = \Session::get('cart_contents');
$handling_fee = $session['handling_fee'];
$total_items = $session['total_items'];
$cart_total = $session['cart_total'];
$flag = 0;
if ($total_items == 1) {
    foreach ($cartItems as $n => $m) {

        if ($m['id'] == 1000) {
            $workbook = true;
        }
    }
}
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
            <?php
            if ($val['restricted_status'] == "yes") {
                $flag = 1;
            }
            $handling_fee += $val['handling_fee'];
            //  $tax += $value['tax'];   
            if (\Auth::guard('customer')->user()) {
                $user = \Auth::guard('customer')->user();
                $final_user_data = \DB::table('customers AS u')
                    ->select('u.*', 'c.iso2 AS country_code', 's.iso2 AS state_code')
                    ->join('countries AS c', 'u.country_id', '=', 'c.id')
                    ->join('states AS s', 'u.state_id', '=', 's.id')
                    ->where('email', $user->email)
                    ->first();

                // dd($final_user_data);
                // Check if the user exists
                if ($final_user_data) {
                    $Hawaii  = '1400';
                    $Alaska = '1411';
                   
                    if ($Hawaii == $final_user_data->state_id || $Alaska == $final_user_data->state_id) {
                        \Session::put('restricted_place', "true");
                        // dd(\Session::get('restricted_place'));
                        // print_r("order cannot proceed because of alaska ,hawaii");
                    } else {
                        $strPath = base_path('app/Services/Fedex');
                        \Session::put('restricted_place', "false");
                        $objRate = new App\Services\Fedex\fedexRates();
                        $objRate->requestType("rate");
                        $objRate->wsdl_root_path = $strPath . "/wsdl-test/";
                        $client = new \SoapClient($objRate->wsdl_root_path . $objRate->wsdl_path, array('trace' => 1));
                        $aryRecipient = [
                            'Contact' => [
                                'PersonName' => $final_user_data->fname . ' ' . $final_user_data->lname,
                                'CompanyName' => 'Company Name',
                                'PhoneNumber' => $final_user_data->phone
                            ],
                            'Address' => [
                                'StreetLines' => [$final_user_data->address1, $final_user_data->address2],
                                'City' => $final_user_data->city,
                                'StateOrProvinceCode' => $final_user_data->state_code,
                                'PostalCode' => $final_user_data->postalcode,
                                'CountryCode' => $final_user_data->country_code,
                                'Residential' => true
                            ]
                        ];

                        // dd($aryRecipient);   
                    }
                    $package = array();
                    $packages = array();
                    $aryPackage = array();
                    $counter = 0;

                    foreach ($cartItems as $key => $value) {
                        // Fetch product details
                        $product = App\Models\Product::where('product_id', $value['id'])->first();

                        if ($product) {
                            $pkg_item = ($counter + 1);
                            $package['contents']['product_' . $pkg_item] = [
                                'data' => [
                                    'length' => $product->length,
                                    'width' => $product->width,
                                    'height' => $product->height,
                                    'weight' => $product->weight_lbs,
                                    'price' => $value['price']
                                ],
                                'quantity' => $value['qty']
                            ];
                            $counter++;

                            // Fetch special product details
                            $specialProducts = App\Models\SpecialProduct::where('product_id', $product->product_id)->get();

                            foreach ($specialProducts as $specialProduct) {
                                $pkg_item = ($counter + 1);
                                $package['contents']['product_' . $pkg_item] = [
                                    'data' => [
                                        'length' => $specialProduct->special_product_length_inch,
                                        'width' => $specialProduct->special_product_width_inch,
                                        'height' => $specialProduct->special_product_height_inch,
                                        'weight' => $specialProduct->special_product_weight_lbs,
                                        'price' => $value['price']
                                    ],
                                    'quantity' => $value['qty']
                                ];
                                $counter++;
                            }
                        }
                    }




                    try {


                        $fedex = new App\Services\Fedex\WC_Shipping_Fedex;

                        $response = $fedex->get_fedex_packages($package);

                        $total_packages = count($response);
                        if ($response) {
                            foreach ($response as $k => $v) {
                                $packages[$k] = new App\Services\Fedex\Package("FEDEX Package # " . ($k + 1) . "", $total_packages, 1);
                                $packages[$k]->setPackageWeight($v['Weight']['Value']);     //Package Actual Weight
                                $packages[$k]->setPackageDimensions($v['Dimensions']['Length'], $v['Dimensions']['Width'], $v['Dimensions']['Height']);       //Package (Length x Width x Height)
                                $aryPackage[$k] = $packages[$k]->getObjectArray();
                            }
                        }

                        // print_r($response);
                    } catch (Exception $e) {
                        echo 'Message: ' . $e->getMessage();

                        // dd($e);

                    }

                    $aryOrder = array(
                        'TotalPackages' => $total_packages,
                        'PackageType' => 'YOUR_PACKAGING',        #FEDEX_10KG_BOX, FEDEX_25KG_BOX, FEDEX_BOX, FEDEX_ENVELOPE, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING
                        'ServiceType' => 'GROUND_HOME_DELIVERY',
                        'TermsOfSaleType' => "DDU",         #    DDU/DDP
                        'DropoffType' => 'REGULAR_PICKUP'         # BUSINESS_SERVICE_CENTER, DROP_BOX, REGULAR_PICKUP, REQUEST_COURIER, STATION
                    );
                    $request = $objRate->rateRequest($aryRecipient, $aryOrder, $aryPackage);
                    if ($workbook) {
                        // $amount = 0;
                    } else {
                        // try 
                        // {
                        if ($objRate->setEndpoint('changeEndpoint')) {
                            $newLocation = $client->__setLocation(setEndpoint('endpoint'));
                        }
                        $response = $client->getRates($request);
                        if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR') {
                            $success = $objRate->showResponseMessage($response);
                            // dd("Fedex: ".$success);
                            $rateReply = $response->RateReplyDetails;
                            $amount = number_format($rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount, 2, ".", ",");
                        } else {
                            $error = $objRate->showResponseMessage($response);
                            // dd($error);
                        }
                        // }catch (\SoapFault $exception){  
                        //     dd($objRate->requestError($exception, $client));
                        // }

                    }
                }
            }

            if ($final_user_data->tax_exempt != 1 && $final_user_data->state_id == 1416) {

                $DBtax = App\Models\Tax::first();

                $row = $DBtax->tax_rate;

                $california_tax   =  $row / 100 * $cart_total;

                $session_data = array('cost' => number_format($california_tax, 2, ".", ","));
                \Session::put('california_tax', $session_data);
            } else {
                // if(!empty($tax)){
                //     echo '$'.number_format($tax,2,".",",");
                // }    
                $session_data = array('cost' => -1);
                \Session::put('california_tax', $session_data);

                $california_tax = 0;
            }


            ?>


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
                                        <span class="amount">${{$amount}}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cart-product-name">
                                        <strong>Tax</strong>
                                    </td>

                                    <td class="cart-product-name text-right">
                                        <span class="amount">${{number_format($california_tax,2,".",",")}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cart-product-name">
                                        <strong>Handling Fee</strong>
                                    </td>

                                    <td class="cart-product-name text-right">
                                        <span class="amount">${{number_format($handling_fee,2,".",",")}}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="cart-product-name">
                                        <strong>Total</strong>
                                    </td>

                                    <?php

                                    $token = uniqid();
                                    \Session::put('token', $token);


                                    if (!empty($amount)) {

                                        $num = floatval(str_replace(",", "", $amount));
                                        $cart_total =  $cart_total + $num + $handling_fee + $california_tax;
                                        $session_data = array('cost' => number_format($num, 2, ".", ","));
                                        \Session::put('Shipping_rate', $session_data);
                                    } else {


                                        $cart_total =  $cart_total + $handling_fee + $california_tax;
                                        $session_data = array('cost' => number_format(0, 2, ".", ","));
                                        \Session::put('Shipping_rate', $session_data);
                                    }
                                    ?>

                                    <td class="cart-product-name text-right">
                                        <span class="amount color lead"><strong>${{number_format($cart_total,2,".",",")}}</strong></span>
                                    </td>
                                </tr>
                            </tbody>

                        </table>

                    </div>


                    <?php

                    if (\Session::has('restricted_place')  == 'true') {
                        $userQulification = \Auth::guard('customer')->user()->status;

                        if ($userQulification == 3 && $flag == 1) {
                            echo "<span style='text-align: left !important;float: left;'>Your Account is not verified and cannot proceed with Restricted Product.</span>";
                        } else {




                    ?>
                            <form action="{{route('checkout')}}" method="POST" id="form">
                                <input type="hidden" name="token" value="{{$token}}">
                                <!-- <input type="submit" name="submit"  value="Proceed to Checkout" class="btn btn-default icon-left float-right" id="submit"> -->
                                <!-- <input type="submit" name="submit"  value="Checkout with Paypal" class="btn btn-default icon-left float-right" id="submit"> -->
                            </form>
                            <button class="btn btn-default" type="button" id="CheckOutPaytrace">Checkout with Paytrace</button>
                            <div class="row paytrace-checkout-container" style=" display: none; background: rgba(0, 0, 0, 0.05); margin-top:30px;padding: 30px; ">

                                <div class="col-md-12 m-10">
                                    <form action="#" id="paytraceForm" class="row">
                                        <div class="form-group col-md-12 text-center">
                                            <h4 class="text-dark">Credit/Debit Card</h4>
                                            <img src="{{asset('images/cc/visa.png')}}" alt="">
                                            <img src="{{asset('images/cc/mc.png')}}" alt="">
                                            <img src="{{asset('images/cc/amex.png')}}" alt="">
                                            <img src="{{asset('images/cc/discover.png')}}" alt="">
                                            <img src="{{asset('images/cc/jcb.png')}}" alt="">
                                            <p>Please make sure you enter your correct billing information.</p>
                                            <p class="text-danger"><small class="trans-errors"></small></p>
                                            <p class="text-success"><small class="trans-success"></small></p>
                                            <img src="{{asset('images/checkout-loder.gif')}}" class="img-fluid m-auto payment-loader" style="display:none;" alt="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="">Card Number</label>
                                            <input type="text" class="form-control" name="cc" id="cc" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Month</label>
                                            <select name="month" class="form-control" required>
                                                <option value="" selected disabled>Select Month</option>
                                                <option value="01">1</option>
                                                <option value="02">2</option>
                                                <option value="03">3</option>
                                                <option value="04">4</option>
                                                <option value="05">5</option>
                                                <option value="06">6</option>
                                                <option value="07">7</option>
                                                <option value="08">8</option>
                                                <option value="09">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Year</label>
                                            <select name="year" class="form-control" required>
                                                <option value="" selected disabled>Select Year</option>
                                                <?php $year = 2035;
                                                for ($i = date('Y'); $i <= $year; $i++) { ?>
                                                    <option value="<?= $i ?>"> <?= $i ?> </option>
                                                <?php } ?>
                                            </select>
                                            <!-- <input type="text" name="year" id="year" class="form-control"> -->
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">CSC</label>
                                            <input type="text" name="csc" required id="csc" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for=""><input type="radio" name="addrchk" value="0" class='addr_chk' id="chk1" checked> Billing Address same as Shipping Address</label>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><input type="radio" name="addrchk" value="1" class='addr_chk' id="chk2"> Enter a new billing address</label>
                                        </div>
                                        <div class="new_addr" style="display: none;">
                                            <!-- <div class="form-group">
                                            <label for="">New Addres</label>
                                            <input type="text" name="new_billing" class="form-control">
                                        </div> -->
                                            <div class="col-md-12 form-group ">
                                                <label class="">Address</label>
                                                <input type="text" name="address1" class="form-control input-lg" placeholder="Street" id="address1">
                                            </div>

                                            <div class="col-md-12 form-group">
                                                <input type="text" name="address2" class="form-control input-lg" placeholder="Apartment, Unit, etc" id="address2">
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label class="">Country</label>

                                                <select name="country" id="country" class="mycountry form-control">

                                                </select>
                                            </div>


                                            <div class="col-md-6 form-group">
                                                <label>State</label>
                                                <select name="state" id="state" class='form-control'>
                                                    
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>City</label>
                                                <input type="text" name="city" class="form-control input-lg" placeholder="City" id="city">
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label class="">Postcode / Zip</label>

                                                <input type="text" name="postcode" class="form-control input-lg" placeholder="Postcode / Zip" id="postcode">

                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label class="">Phone</label>
                                                <input type="text" class="form-control input-lg" name="phone" value="">
                                            </div>


                                        </div>
                                        <div class="form-group col-md-12">
                                            <input type="submit" value="Checkout" class="btn btn-default" id="checkoutSubmitButton">
                                        </div>
                                    </form>
                                </div>
                            </div>
                    <?php

                        }
                    } else {
                        echo "<span style='text-align: left !important;float: left;'>Shipping to AK and HI requires air shipping and orders cannot be processed online. Please call 855-374-3473 to complete your order.</span>";
                    }

                    ?>

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


<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.addr_chk').change(function() {
            var status = $(this).val()
            if (status == 0) {
                $('.new_addr').hide();
                $('#address1').removeAttr('required');
                $('#city').removeAttr('required');
                $('#postalcode').removeAttr('required');
                $('#phone').removeAttr('required');
            }
            if (status == 1) {
                $('.new_addr').show()
                $('#address1').attr('required', 'required');
                $('#city').attr('required', 'required');
                $('#postalcode').attr('required', 'required');
                $('#phone').attr('required', 'required');
            }
        })

        var loading = '<svg class="loading-img" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background-image: none; display: block; shape-rendering: auto;" width="40px" height="40px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><g transform="translate(50 50)"><g transform="scale(0.7)"><g transform="translate(-50 -50)"><g><animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" values="0 50 50;360 50 50" keyTimes="0;1" dur="0.7575757575757576s"></animateTransform><path fill-opacity="0.8" fill="#93dbe9" d="M50 50L50 0A50 50 0 0 1 100 50Z"></path></g><g><animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" values="0 50 50;360 50 50" keyTimes="0;1" dur="1.0101010101010102s"></animateTransform><path fill-opacity="0.8" fill="#689cc5" d="M50 50L50 0A50 50 0 0 1 100 50Z" transform="rotate(90 50 50)"></path></g><g><animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" values="0 50 50;360 50 50" keyTimes="0;1" dur="1.5151515151515151s"></animateTransform><path fill-opacity="0.8" fill="#5e6fa3" d="M50 50L50 0A50 50 0 0 1 100 50Z" transform="rotate(180 50 50)"></path></g><g><animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" values="0 50 50;360 50 50" keyTimes="0;1" dur="3.0303030303030303s"></animateTransform><path fill-opacity="0.8" fill="#3b4368" d="M50 50L50 0A50 50 0 0 1 100 50Z" transform="rotate(270 50 50)"></path></g></g></g></g></svg>';
        $('#paytraceForm').on('submit', function(e) {
            e.preventDefault();
            $('.payment-loader').show();
            $('.trans-errors').html('');
            $('.trans-success').html('');
            var form_data = $(this).serialize();
            $.ajax({
                method: 'POST',
                url: "{{route('sendPayment')}}",
                data: {
                        _token: '{{ csrf_token() }}',
                        form_data
                    },
                beforeSend: function() {
                    $('#checkoutSubmitButton').parent().append(loading);
                    $('#checkoutSubmitButton').hide();
                },
                error: function(jqXhr, textStatus, errorMessage) {

                    $('#checkoutSubmitButton').show();
                    alert(textStatus);
                    alert(errorMessage);

                },
                success: function(response) {
                      console.log('response: '+response);
                    response = $.parseJSON(response);
                    // console.log(response);
                    $('.payment-loader').hide();

                    if (response.cart_error == true && response.cart == 'update') {
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
                    if (response.success == true || response.success != '') {
                        $('.payment-loader').hide();
                        $('.loading-img').hide();
                        $('.trans-success').html(response.status_message);
                        redirect = "{{route('myaccount')}}";
                        setTimeout(function() {
                            window.location.replace(redirect);
                        }, 500)
                    }
                    if (typeof response.cart_error == 'undefined') {
                        if (response.success == false) {
                            $('.payment-loader').hide();
                            $('.loading-img').hide();
                            $('#checkoutSubmitButton').show();
                            rs_errors = response.errors;
                            $('.trans-errors').html('');
                            for (x in rs_errors) {
                                $('.trans-errors').append(rs_errors[x] + "<br>");
                            }
                        }

                    }

                }

            })
        })

        $('#additional_note').keyup(function() {



            var note = $('#additional_note').val();

            $.ajax({
                url: 'https://www.firequick.com/form/addtonote',
                type: 'POST',
                // dataType : "json",
                data: {
                    note: note
                },
                success: function(data, status, xhr) {
                    // $('#additional_note').val(note);
                    // $('#additional_note').attr("disabled", "disabled");
                    // $("#additional_note").css("border", "0px");
                    // $('#addnote').remove();
                },
                error: function(jqXhr, textStatus, errorMessage) {

                    alert(textStatus);
                    alert(errorMessage);

                }
            });



        });

        $('.remove').on('click', function(e) {
            e.preventDefault();
            var cart_id = $(this).attr('id');
            // console.log(cart_id);
            rm = $(this);




            var agree = confirm('Are you sure?');
            if (agree == true) {

                $.ajax({
                    url: "{{route('removeFromCart')}}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        myDataid: cart_id
                    },
                    success: function(data, status, xhr) {

                        alert('cart updated');
                        location.reload();
                        //   window.location.replace($(location).attr('href'));




                    },
                    error: function(jqXhr, textStatus, errorMessage) {
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
        if (agree == true) {
            $.ajax({
                url: "{{route('getCountries')}}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data, status, xhr) {
                    // console.log(data);
                    // var json = $.parseJSON(data);
                    $(data).each(function(i, val) {
                        // console.log(i);
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

            if (CountryID != 0 && CountryID != '') {
                $.ajax({
                    url: "{{route('getStates')}}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        country_id: CountryID
                    },

                    success: function(data, status, xhr) {

                        if (data != "false") {
                            // var json = $.parseJSON(data);
                            $(data).each(function(i, val) {

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