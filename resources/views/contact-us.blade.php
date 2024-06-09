@extends('layouts.main')
@section('content')
<!-- Menu Start Section -->

<section id="page-title" class="background-overlay" data-parallax-image="{{asset('images/banner/banner.jpg')}}">
    <div class="container">
        <div class="page-title">
            <h1 class="text-uppercase text-medium">contact&nbsp;&nbsp;us</h1>
       
        </div>
    </div>
</section>

<section class="custom-section">
            <div class="container">
                <div class="row">
                @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

                    <div class="col-md-6"><!-- 
                        <h3 class="text-uppercase">Get In Touch</h3> -->
                        <div class="m-t-30">
    <form class="" action="{{ route('contact-form') }}" role="form" method="post">
        @csrf
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="name">Name</label>
                <input type="text" aria-required="true" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter your Name" value="{{ old('name') }}">
                @error('name')
                   <div class="alert alert-danger">{{ $message }}</div>

                @enderror
            </div>
            <div class="form-group col-sm-6">
                <label for="email">Email</label>
                <input type="email" aria-required="true" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your Email" value="{{ old('email') }}">
                @error('email')
                   <div class="alert alert-danger">{{ $message }}</div>

                @enderror
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-12">
                <label for="subject">Your Subject</label>
                <input type="text" name="subject" class="form-control" placeholder="Subject..." value="{{ old('subject') }}">
            </div>
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror" placeholder="Enter your Message">{{ old('message') }}</textarea>
            @error('message')
               <div class="alert alert-danger">{{ $message }}</div>

            @enderror
        </div>
        <div class="form-group">
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            <div class="g-recaptcha" data-sitekey="6LdxV-oZAAAAAK6JNQiqKOd7gOjOtC2Up8qKTofP"></div>
        </div>
        <button class="btn btn-default" type="submit" id="form-submit"><i class="fa fa-paper-plane"></i>&nbsp;Send message</button>
    </form>
</div>

                    </div>
                    <div class="col-md-6"><!-- 
                        <h3 class="text-uppercase">Address & Map</h3> -->
                        <!-- Google map sensor -->
                         <!--<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3.exp"></script>-->
                        <!--<div class="map m-t-30" data-map-address="Melburne, Australia" data-map-zoom="10" data-map-icon="images/markers/marker2.png" data-map-type="ROADMAP"></div>-->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3242.40673509447!2d-117.82420838476658!3d35.64234938020346!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c175034e08d179%3A0x3f6e1b0dc8bea5c0!2sFirequick%20Products!5e0!3m2!1sen!2s!4v1579291035659!5m2!1sen!2s" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                         Google map sensor 

                    </div>
                </div>
            </div>
        </section><!-- Start footer -->
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