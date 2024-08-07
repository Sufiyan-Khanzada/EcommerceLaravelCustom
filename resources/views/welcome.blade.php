@extends('layouts.main')
@section('content')
<!-- Inspiro Slider -->
<div id="slider0" class="inspiro-slider0 slider-fullscreen0 arrows-large arrows-creative dots-creative owl-carousel owl-theme" data-height-xs="360">
    <!-- Slide 1 -->
    <div class="slide0 background-overlay-dark item" style="background-image: url({{asset('images/banner/Header-1.jpg')}});">
        <div class="container">
            <div class="slide-captions text-center">
                <!-- Captions -->
                <h2 class="text-light">In the challenging wild land fire environment, stay safer with 300’ flare travel and delayed remote ignition.</h2>
            </div>
        </div>
        <!-- div id="scroll-down" class="scrolldown-animation scrolldown-bottom">

                        <img alt="" src="assets/images/scrolldown.png">

                </div -->
    </div>
    <!-- end: Slide 1 -->
    <!-- Slide 2 -->
    <div class="slide0 background-overlay-dark item" style="background-image: url({{asset('images/banner/Header-2.jpg')}});">
        <div class="container">
            <div class="slide-captions text-center">
                <!-- Captions -->
                <h2 class="text-light">Firequick flares burn hotter, faster, longer than the competition – don’t waste your time with inferior products!</h2>
            </div>
        </div>
        <!-- div id="scroll-down" class="scrolldown-animation scrolldown-bottom">
                    
                        <img alt="" src="assets/images/scrolldown.png">
                    
                </div -->
    </div>
    <!-- end: Slide 2 -->
    <!-- Slide 3 -->
    <div class="slide0 background-overlay-dark item" style="background-image: url({{asset('images/banner/Header-3.jpg')}});">
        <div class="container">
            <div class="slide-captions text-center">
                <!-- Captions -->
                <h2 class="text-light">When you need rugged products designed specifically for your burn operations you need Firequick.</h2>
                <!-- end: Captions -->
            </div>

        </div>
        <!-- div id="scroll-down" class="scrolldown-animation scrolldown-bottom">
                    
                        <img alt="" src="assets/images/scrolldown.png">
                    
                </div -->
    </div>
    <!-- end: Slide 3 -->
    <!-- Slide 4 -->
    <div class="slide0 background-overlay-dark item" style="background-image: url({{asset('images/banner/Header-4.jpg')}});">
        <div class="container">
            <div class="slide-captions text-center">
                <!-- Captions -->
                <h2 class="text-light">
                    For prescribed or control burns, flash to wet and heavy fuels, Firequick has the right flare for the job!</h2>

                <!-- end: Captions -->
            </div>

        </div>
        <!-- div id="scroll-down" class="scrolldown-animation scrolldown-bottom">
                    
                        <img alt="" src="assets/images/scrolldown.png">
                    
                </div -->
    </div>
    <!-- end: Slide 4 -->

    <!-- Slide 5 -->
    <div class="slide0 background-overlay-dark item" style="background-image: url({{asset('images/banner/Header-5.jpg')}});">
        <div class="container">
            <div class="slide-captions text-center">
                <!-- Captions -->
                <h2 class="text-light">
                    Fight fire with fire! Unprecedented 4000°F burn with a guaranteed 95% ignition rate – We’ve got you covered!</h2>

                <!-- end: Captions -->
            </div>

        </div>
        <!-- div id="scroll-down" class="scrolldown-animation scrolldown-bottom">
                    
                        <img alt="" src="assets/images/scrolldown.png">
                    
                </div -->
    </div>
    <!-- end: Slide 5 -->



</div>
<!--end: Inspiro Slider -->

<!-- Menu Start Section --><!-- Start PRODUCTS -->
<section class="Products">
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                <div class="Products-box">
                    <a href="{{route('products',3)}}" title=""><img style="width:320px; height: 200px; " src="{{asset('images/flare/FlaresGroup_1.jpg')}}" alt="" class="img-responsive"></a>
                    <h4><a href="{{route('products',3)}}" title="">FLARES</a></h4>
                    <p>Full line of remote-ignition incendiary flares excellent for control burn and prescribed burn operations. Mechanically and hand-launched configurations available!</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="Products-box">
                    <a href="{{route('products',2)}}" title=""><img style="width:250px; height: 200px; " src="{{asset('images/flare/LauncherIII_1.jpg')}}" alt="" class="img-responsive"></a>
                    <h4><a href="{{route('products',2)}}" title="">LAUNCHERS</a></h4>
                    <p>Pistol-style Firequick launcher for use with mechanically launched flares. And now available: our new AR-style Large Format Launcher to propel Large Format Flares!</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="Products-box">
                    <a href="{{route('products',4)}}" title=""><img style="width:250px; height: 200px; " src="{{asset('images/flare/CleaningKitContents_1.jpg')}}" alt="" class="img-responsive"></a>
                    <h4><a href="{{route('products',4)}}" title="">FIREQUICK ACCESSORIES</a></h4>
                    <p>Firing cartridges, cleaning kits, holsters, and a wide variety of other items to complement your Firequick flare systems.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="Products-box">
                    <a href="{{route('products',6)}}" title=""><img style="width:250px; height: 200px; " src="{{asset('images/flare/prod3.jpg')}}" alt="" class="img-responsive"></a>
                    <h4><a href="{{route('products',6)}}" title="">WILEY-X TACTICAL EYEWEAR AND GLOVES</a></h4>
                    <p>ANSI Z87 rated premium safety / sunglasses exceeding OSHA standards. Gloves offer the ultimate in flame resistant hand protection while allowing for maximum dexterity.</p>
                </div>
            </div>






        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="Service">
                    <a href="{{route('news')}}"><img src="{{asset('images/services-training/news-box.jpg')}}" alt="" class="img-responsive"></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="Service">
                    <a href="{{route('products')}}"><img src="{{asset('images/services-training/ship-box.jpg')}}" alt="" class="img-responsive"></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="Service">
                    <a href="{{route('gallery')}}"><img src="{{asset('images/services-training/gallery-box.jpg')}}" alt="" class="img-responsive"></a>
                </div>
            </div>
        </div>
    </div>
</section>




<!-- End PRODUCTS -->
<!-- Start TESTIMONIALS -->

<section class="testimonial">
    <div class="container">
        <div class="row">
            <h1>TESTIMONIALS</h1>
            @if(count($data['testimonials']) > 0)


            @foreach ($data['testimonials'] as $testimonial)
            <div class="col-md-4">

                <div class="testimonial-content">
                    <img style="border:2px solid #222222 !important; width:420px; height:220px; padding-bottom: 0px !important ; " src="{{ asset('admin/images/' . $testimonial->image_id) }}" alt="" class="img-responsive">
                    <p>{{ $testimonial->discripition }}</p>
                </div>
                <div class="author">
                    <h4>{{ $testimonial->author}}</h4>
                </div>

            </div>

            @endforeach
            @endif



        </div>
    </div>
</section>


<?php
// dd($menuItems)



?>

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