@extends('layouts.main')
@section('content')
<!-- Menu Start Section -->
<section id="page-title" class="background-overlay" data-parallax-image="{{asset('images/banner/banner.jpg')}}">
    <div class="container">
        <div class="page-title">
            <h1 class="text-uppercase text-medium">Shop</h1>
        </div>
    </div>
</section>
<!-- Shop products -->
<section id="page-content" class="sidebar-left">
    <div class="container">
        <div class="row">
            <!-- Content-->
            <div class="content col-md-12">
                <div class="product">
                    <div class="row m-b-40">
                        <div class="col-md-5">
                            <div class="product-image">
                                <div class="preview-pic tab-content">
                                    <div class="tab-pane active" id="pic-1"><img src="{{ asset('admin/images/'.$product->image_id) }}" /></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="product-description">
                                @php
                                    $productCategories = explode(',', $product->category_id);
                                @endphp
                                <div class="product-category">
                                    |
                                    @foreach($categories as $category)
                                    @if(in_array($category->category_id, $productCategories))
                                        {{$category->title}} |
                                    @endif
                                    @endforeach
                                </div>
                                <div class="product-title">
                                    <h3><a >{{$product->title}}</a></h3>
                                </div>
                                <div class="product-price">
                                    Price :<ins> ${{$product->regular_price}}</ins>                                
                                </div>
                                @if ($product->restricted_status == 'yes')
                                <div class="seperator m-b-10"></div>
                                <p style="color: #555; font-weight: bold; font-family: 'PT Sans', sans-serif;"> NOTE: This is a restricted product. To order it to your ship to address you must be <span style="color: #ff4000;">pre-validated by Firequick.</span> If you are not a pre-validated customer, you will be notified at the checkout.</p>
                                @endif
                                </br>
                                <div style="font-weight: bold;color: #ff4000;font-family: 'PT Sans', sans-serif;" >
                                    Status: In stock                                
                                </div>
                                <div style="background-color: #f1f1f1; padding: 30px; padding-top: 10px;">
                                    <p> <b style="color: #ff4000;font-family: 'PT Sans', sans-serif;" >DESCRIPTION: </b></p>
                                    <p style="font-family: 'PT Sans', sans-serif; font-size: 17px;">{{$product->discripition}}</p>
                                </div>
                                <div class="seperator m-t-20 m-b-10"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="">
                                        <label for="case">Choose Your Flare Package Size:</label>
                                        <select id="case">
                                            <option style="color:#222222; font-weight: bold;" value="39">Box $68.50 (10 Flares)</option>
                                            <option style="color:#222222; font-weight: bold;" value="40">Mini Case $1350(20 Boxes/200 Flares)</option>
                                            <option style="color:#222222; font-weight: bold;" value="41">Case $2600(40 Boxes/400 Flares)</option>
                                        </select>
                                    </div>
                                    <h6>
                                        <p>Select quantity</p>
                                    </h6>
                                    <div class="cart-product-quantity">
                                        <script>
                                            function incrementValue()
                                                {
                                                var value = parseInt(document.getElementById('number').value, 10);
                                                value = isNaN(value) ? 0 : value;
                                                if(value<50){
                                                value++;
                                                    document.getElementById('number').value = value;
                                                }
                                                }
                                                function decrementValue()
                                                {
                                                var value = parseInt(document.getElementById('number').value, 10);
                                                value = isNaN(value) ? 0 : value;
                                                if(value>1){
                                                value--;
                                                    document.getElementById('number').value = value;
                                                }
                                            
                                                }
                                        </script>
                                        <div class="quantity m-l-5" id="incdec">
                                            <input type="button" onclick="decrementValue()" value="-" class="minus"/>
                                            <input type="text" name="quantity" value="1" maxlength="2" max="100" size="1" id="number" class="qty"/>
                                            <input type="button" onclick="incrementValue()" value="+" class="plus" />   
                                        </div>
                                        <div>
                                            <h6>Add to Cart</h6>
                                            <div style=" display:none; width: 20px; height: 47px;" id="btnCart">
                                                <a href="https://www.firequick.com/page/cart" class="btn">View Cart </a>
                                            </div>
                                            <button class="btn" id="addtocart" value="39"><i class="fa fa-shopping-cart"></i>
                                            Add to Cart 
                                            </button>
                                            <button class="btn" id="refer" value="https://www.firequick.com/page/single-product/39/Hotshot-Flare-1-box-10-flares--NFES-000371">
                                            Refer a friend 
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: Content-->
        </div>
    </div>
</section>
<script src="https://www.firequick.com/assets/jquery-3.2.1.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-1.10.2.js"></script> -->
<script>
    $(document).ready(function(){
        
        $('#color').change(function(){
            // alert($(this).val());
        });
        
        $('#click').on('click',function(){
            // alert($('#size').val());
        });
        
        $('#addtocart').on('click',function(){
            var size = $('#size').val();
            var color = $('#color').val();
            var product_id = $(this).val();
            var qty = $('.qty').val();
            var optional = $('#optional_info').val();
            var currentURL = window.location.href;
    
        var agree = true;
            if($("#size").length){
               if(size == null || size == ''){
                   $('#error-size').text('Please select size.');
                   agree = false;
               }
            } 
            if($("#color").length){
               if(color == null || color == ''){
                   $('#error-color').text('Please select colour.');
                   agree = false;
               }
            } 
    
    
            
                if(agree == true){
    
                    $.ajax({
                        url: 'https://www.firequick.com/form/addtocart',
                        type: 'POST',
                        data: { myDataid: product_id,size:size,color:color,quantity:qty,optional_info:optional,currentURL:currentURL}, 
                       success: function (data, status, xhr) {
                            
                             console.log('data',data);
                             var obj = JSON.parse(data);
                             console.log(obj);
                            $('.shopping-cart-items').html(obj.cart_total_item);
                            if(obj.alert == true){
                                alert("“Your order contains a shipment of restricted items to a Customer and Ship to address that has not been validated by Firequick. Please call the Firequick office at 760-377-5766 to confirm your address and for details on our customer verification process.”");                                        
                             }
                             if(obj.alert == "login"){
                                //  alert("Please login to proceed to checkout");
                                // alert(obj.address);
                                // alert(window.location.href);
                                window.location.href = obj.address;
                             }else{
                                $('#btnCart').show();    
                             }
                             
    
                        },
                        error: function (jqXhr, textStatus, errorMessage) {
                              alert(textStatus);
                              alert(errorMessage);
                              
                        }
                    }); 
    
    
    
                }
    
        });
        
        
        $('#refer').on('click',function(){
            var email = prompt('Enter friend Email here.');
             var url =  $(this).val();
             
            if(email != null ){
                $.ajax({
                    url: 'https://www.firequick.com/mail/sendtofriend',
                    type: 'POST',
                    data: { email:email,url:url}, 
                   success: function (data, status, xhr) {
                        
                        if(data == "true"){
                            alert('Product link successfully sent.')
                        }
                        
    
                    },
                    error: function (jqXhr, textStatus, errorMessage) {
                          alert(textStatus);
                          alert(errorMessage);
                          
                    }
                }); 
            }
        })
        
        
    });
                
</script>
<script>
    $(document).ready(function(){
      $('#case').change(function(){
           
         var productID = $(this).val();
          
          $("#addtocart").val(productID);
          
          
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
    (()=>{
        
    })()
</script>
@endsection