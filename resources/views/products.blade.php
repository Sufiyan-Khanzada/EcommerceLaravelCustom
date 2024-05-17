@extends('layouts.main')
@section('content')
    <!-- Menu Start Section -->

<section id="page-title" class="background-overlay" data-parallax-image="{{asset('images/banner/banner.jpg')}}">
    <div class="container">
        <div class="page-title">
            <h1 class="text-uppercase text-medium">Flares</h1>
       
        </div>
    </div>
</section>
<!-- Shop products -->
        <section id="page-content" class="sidebar-left">
            <div class="container">
                <div class="row">
                    <!-- Content-->
                    <div class="content col-md-12">
                        <div class="row m-b-20">
                            <div class="col-md-12">
                                <div class="order-select">
                                    <p> <b>SORTING BY CATEGORY</b></p>
                                    <style>
                                        #my-ul {
                                            list-style: none;
                                            padding: 0;
                                            margin: 0;
                                        }
                                        #my-ul li {
                                            width: 200px;
                                            border: 3px double #ff4000;
                                            float: left;
                                            text-align: center;
                                            border-radius: 20px;
                                            margin-left: 5px;
                                            color: #000000;
                                            font-weight: bold;
                                            padding-right: 10px;
                                            padding-left:  10px;
                                        }
                                        #my-ul li:hover{
                                            /*border: 3px double #000000;*/
                                            color: white;
                                            background-color: #ff4000;
                                            
                                        }

                                    </style>
                                    <div id="mydiv">
                                                                            <ul id="my-ul">
                                        <a href="https://www.firequick.com/page/products"><li>All Products</li></a>
                                                                                <a href="https://www.firequick.com/page/products/category/2"> <li     >Launchers</li></a>
                                                                                <a href="https://www.firequick.com/page/products/category/3"> <li  style=' color: white;  background-color: #ff4000; '   >Flares</li></a>
                                                                                <a href="https://www.firequick.com/page/products/category/4"> <li     >Firequick Accessories</li></a>
                                                                                <a href="https://www.firequick.com/page/products/category/5"> <li     >Kits and Combos</li></a>
                                                                                <a href="https://www.firequick.com/page/products/category/6"> <li     >Wiley X Tactical Eyewear and Gloves</li></a>
                                        
                                    </ul>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <!--Product list-->
                        <div class="shop">
                            <div class="grid-layout grid-3-columns" data-item="grid-item">

                                @foreach ($products as $product)
                                    <div class="grid-item">
                                        <div class="product">
                                            <div class="product-image" style="width: 320px; height:250px;">
                                                <a href="{{route('single.product')}}"><img   alt="Shop product image!" src="{{ asset('admin/images/'.$product->image_id) }}">
                                                </a>
                                                <a href="{{route('single.product')}}"><img alt="Shop product image!" src="{{ asset('admin/images/'.$product->image_id) }}">
                                                </a>
                                                
                                                <div class="product-overlay">
                                                    <a href="" data-lightbox="image" title="Shop product image!">Quick View</a>
                                                </div>
                                            </div>

                                            <div class="product-description">
                                                <div class="product-category">Flares</div>
                                                <div class="product-title">
                                                    <h3><a href="{{route('single.product')}}">{{$product->title}}</a></h3>
                                                </div>

                                                <div class="product-price"> <br>
                                                    
                                                    <ins>${{$product->regular_price}}</ins> 


                                                </div>                                            
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                        </div>
                        <!--End: Product list-->
                    </div>
                    <!-- end: Content-->

                </div>
            </div>
        </section>
        <!-- end: Shop products -->
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