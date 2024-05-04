@extends('layouts.main')
@section('content')
   <!-- Start Top Search -->
   <div class="top-search">
    <div class="container">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-search"></i></span>
            <input type="text" class="form-control" placeholder="Search">
            <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
        </div>
    </div>
</div>
<!-- End Top Search -->

<!-- Start Slider -->
<div id="slides-shop" class="cover-slides">
    <ul class="slides-container">
        <li class="text-center">
            <img src="{{asset('images/Header-1.jpg')}}" alt="">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="m-b-20">In the challenging wild land fire environment, stay safer with 300’ flare travel and delayed remote ignition.</h1>
                    </div>
                </div>
            </div>
        </li>
        <li class="text-center">
            <img src="{{asset('images/Header-3.jpg')}}" alt="">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="m-b-20">Firequick flares burn hotter, faster, longer than the competition – don’t waste your time with inferior products!</h1>
                    </div>
                </div>
            </div>
        </li>
        <li class="text-center">
            <img src="{{asset('images/Header-4.jpg')}}" alt="">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="m-b-20">
                        For prescribed or control burns, flash to wet and heavy fuels, Firequick has the right flare for the job!</h1>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    <div class="slides-navigation">
        <a href="#" class="next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
        <a href="#" class="prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
    </div>
</div>
<!-- End Slider -->

<!-- Start Categories  -->
<div class="categories-shop">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="shop-cat-box">
                    <img class="img-fluid" src="{{asset('images/FlaresGroup_1.jpg')}}" alt="" />
                    <a class="btn hvr-hover" href="#">FLARES</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="shop-cat-box">
                    <img class="img-fluid" src="{{asset('images/LauncherIII_1.jpg')}}" alt="" />
                    <a class="btn hvr-hover" href="#">LAUNCHERS</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="shop-cat-box">
                    <img class="img-fluid" src="{{asset('images/CleaningKitContents_1.jpg')}}" alt="" />
                    <a class="btn hvr-hover" href="#">FIREQUICK ACCESSORIES</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="shop-cat-box">
                    <img class="img-fluid" src="{{asset('images/prod3.jpg')}}" alt="" />
                    <a class="btn hvr-hover" href="#">WILEY-X TACTICAL EYEWEAR AND GLOVES</a>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- End Categories -->

<div class="box-add-products">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="offer-box-products">
                    <img class="img-fluid" src="{{asset('images/news-box.jpg')}}" alt="" />
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="offer-box-products">
                    <img class="img-fluid" src="{{asset('images/ship-box.jpg')}}" alt="" />
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="offer-box-products">
                    <img class="img-fluid" src="{{asset('images/gallery-box.jpg')}}" alt="" />
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Start Blog  -->
<div class="latest-blog">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-all text-center">
                    <h1>TESTIMONIALS</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-4 col-xl-4">
                <div class="blog-box">
                    <div class="blog-img">
                        <img class="img-fluid" src="{{asset('images/testimonial-1.jpg')}}" alt="" />
                    </div>
                    <div class="blog-content">
                        <div class="title-blog">
                            <p>We have been using Firequick products for years including the launchers and hand thrown devices. We have used them for both wildland fire fighting operations and controlled burns because they work! The amount of time and energy they have saved my crew cannot be overemphasized. Thanks for a great product</p>
                            <h3>Tim Walsh – Fire Crew Superintendent, Marin County Fire Department, Tamalpais Fire Crew</h3>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-4">
                <div class="blog-box">
                    <div class="blog-img">
                        <img class="img-fluid" src="{{asset('images/testimonial-2.jpg')}}" alt="" />
                    </div>
                    <div class="blog-content">
                    <div class="title-blog">
                            <p>We have been using Firequick products for years including the launchers and hand thrown devices. We have used them for both wildland fire fighting operations and controlled burns because they work! The amount of time and energy they have saved my crew cannot be overemphasized. Thanks for a great product</p>
                            <h3>Tim Walsh – Fire Crew Superintendent, Marin County Fire Department, Tamalpais Fire Crew</h3>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-4">
                <div class="blog-box">
                    <div class="blog-img">
                        <img class="img-fluid" src="{{asset('images/testimonial-3.jpg')}}" alt="" />
                    </div>
                    <div class="blog-content">
                    <div class="title-blog">
                            <p>We have been using Firequick products for years including the launchers and hand thrown devices. We have used them for both wildland fire fighting operations and controlled burns because they work! The amount of time and energy they have saved my crew cannot be overemphasized. Thanks for a great product</p>
                            <h3>Tim Walsh – Fire Crew Superintendent, Marin County Fire Department, Tamalpais Fire Crew</h3>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Blog  -->



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