@extends('layouts.main')
@section('content')
<!-- Menu Start Section -->
  
<section id="page-title" class="background-overlay" data-parallax-image="{{asset('images/banner/banner.jpg')}}">
    <div class="container">
        <div class="page-title">
            <h1 class="text-uppercase text-medium">{{ $data->title }}</h1>
       
        </div>
    </div>
</section>
<!-- </div> -->
<section class="custom-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
<div>
<div>
<p><?php echo html_entity_decode($data->content)?></p>
</div>
</div>
</div>
            </div>
        </div>
    </div>
</section>


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