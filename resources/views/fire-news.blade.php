@extends('layouts.main')
@section('content')
      <!-- Start All Title Box -->
      <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Quick Fire News</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Quick Fire News</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start About Page  -->
    <div class="about-box-main">
        <div class="container">
            
        <div class="row my-5">
            <div class="col-sm-12 col-lg-12">
                <div class="blog-block">
                <div class="blog-image">
                
                </div>
                    <img src="{{asset('images/fire-news.jpg')}}">
                    <div class="blog-meta">
                <span class="meta-date">Date: January 1, 2024</span>
                <span class="meta-author">Author: John Doe</span>
            </div>
                    <h2 class="noo-sh-title-top">Wiley-X available at Firequick Products!</h2>
                    <p>We know that wild land firefighters face the toughest conditions in the fire industry when they are battling fierce wildfires. Firequick chose Wiley-X high-performance protective
                    </p>
                    <a class="btn hvr-hover" href="#">Read More</a>
                </div>
            </div>
           
          
        </div>

           
        </div>
    </div>
    <!-- End About Page -->

    
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