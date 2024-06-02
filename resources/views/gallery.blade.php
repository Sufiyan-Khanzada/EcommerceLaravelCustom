@extends('layouts.main')
@section('content')
  	<!-- Menu Start Section -->
  
<section id="page-title" class="background-overlay" data-parallax-image="{{asset('images/banner/banner.jpg')}}">
    <div class="container">
        <div class="page-title">
            <h1 class="text-uppercase text-medium">gallery</h1>
       
        </div>
    </div>
</section>




<section id="page-content">

            <div class="container">
<a href="https://www.firequick.com/page/add-image" id="add-image" class="btn">
 Add Image to gallery

</a>
        

                        <!-- Gallery -->
                        <div class="grid-layout grid-3-columns" data-margin="20" data-item="grid-item" data-lightbox="gallery">
                               

                            @forelse ($data as $key => $gallery)
                           
                            <div class="grid-item">
                                <a class="image-hover-zoom" href="{{ asset('admin/gallery/' . $gallery->location) }}">

                                <img style=" width: 350px; height: 250px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); "src="{{ asset('admin/gallery/' . $gallery->location) }}">
                                </a>
                            </div>
            
                                @empty
                                <span style='font-size:26px; font-weight:bold;'>Images not Found</span>
                                @endforelse

                        </div>
                        <!-- end: Gallery -->
            </div>
        </section>


<script src="https://www.firequick.com/assets/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#add-image').click(function(e){
            var agree = confirm('To agree our Photo Release Policy Press `OK`');
            if(!agree){
                return false;
            }else{
                return true;
            }
            
        });
    });
</script><!-- Start footer -->  
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