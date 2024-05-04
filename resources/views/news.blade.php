@extends('layouts.main')
@section('content')
      <!-- Start All Title Box -->
      <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>News</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">News</li>
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
                    <img src="{{asset('images/new-01.jpg')}}">
                    <div class="blog-meta">
                <span class="meta-date">Date: January 1, 2024</span>
                <span class="meta-author">Author: John Doe</span>
            </div>
                    <h2 class="noo-sh-title-top">We are <span>Freshshop</span></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <a class="btn hvr-hover" href="#">Read More</a>
                </div>
            </div>
            <div class="col-sm-12 col-lg-12">
                <div class="blog-block">
                    
                    <div class="blog-image">
                    <img src="{{asset('images/new-02.jpg')}}">
                </div>
                    <div class="blog-meta">
                <span class="meta-date">Date: January 1, 2024</span>
                <span class="meta-author">Author: John Doe</span>
            </div>
                    <h2 class="noo-sh-title-top">We are <span>Freshshop</span></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <a class="btn hvr-hover" href="#">Read More</a>
                </div>
            </div>
            <div class="col-sm-12 col-lg-12">
                <div class="blog-block">
                <div class="blog-image">
                    <img src="{{asset('images/flare-post-news.png')}}">
                </div>
                    <div class="blog-meta">
                <span class="meta-date">Date: January 1, 2024</span>
                <span class="meta-author">Author: John Doe</span>
            </div>
                    <h2 class="noo-sh-title-top">We are <span>Freshshop</span></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
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