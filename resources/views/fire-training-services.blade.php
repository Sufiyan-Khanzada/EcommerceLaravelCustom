@extends('layouts.main')
@section('content')
      <!-- Start All Title Box -->
      <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>
                        Fire  Training  Services</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">
                            Fire  Training  Services</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start About Page  -->
    <div class="about-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                   
                    <p>
                        Firequick Products, Inc. will support your support your S-219 Firing Operations (previously S-234) training, or other firing devices class by making or supporting presentations and conducting or supporting firing demonstrations. Inert flares can be procured for environments that are not conducive to burning. Firequick User Training Workbooks can be printed and provided for your class.
                       </p>

                       <p>
                        You should be prepared to procure product to support your class. Travel and training fees are negotiable. Often new products may be available for demonstration. Call for the latest information when preparing for a training class. Please provide ample lead time prior to your class for a representative to be scheduled.
                       </p>

                       <p>
                        Launcher Repair Request Form Customer Launcher Repair Request
                       </p>
    

                </div>

				<div class="col-lg-4">
                    <div class="banner-frame"> <img class="img-fluid" src="{{asset('images/ft1.jpg')}}" alt="" />
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="banner-frame"> <img class="img-fluid" src="{{asset('images/ft2.jpg')}}" alt="" />
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="banner-frame"> <img class="img-fluid" src="{{asset('images/ft3.jpg')}}" alt="" />
                    </div>
                </div>
                
            </div>
           
        </div>
    </div>
    <!-- End About Page -->

    <!-- Start Instagram Feed  -->
    @include('widgets.instagram')
    <!-- End Instagram Feed  -->
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