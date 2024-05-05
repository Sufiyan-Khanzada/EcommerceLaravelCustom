@extends('layouts.main')
@section('content')
      <!-- Start All Title Box -->
      <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Launcher Repair Services</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Launcher Repair Services</li>
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
                <div class="col-lg-6">
                   
                    <p>
                        FireQuick Launchers come with a one-year warranty from date of purchase. If you experience performance problems with your launcher you should return it to the manufacturer for repair. Attempting to repair the launcher yourself or utilizing an unauthorized repair shop will void your warranty. Gunsmiths or other unauthorized repair shops are not able to obtain spare parts or to adequately test launchers for their intended purpose. Use of such facilities may perpetrate a safety hazard with future use of your launcher. Manufacturer assumes no liability and offers no warranty for such repairs.
                       </p>
    
                       <p>
                        Most launcher failures, even on launchers well beyond the warranty period, are easily fixed and are often accomplished at little or no charge to the customer. For more extensive, out-of-warranty repairs Firequick Products will provide a repair estimate prior to committing to repair. Call the manufacturer directly at 760-377-5766 if you have questions regarding a launcher return.
                       </p>

                       <p>
                        Firequick is happy to assist with your department’s launcher maintenance requirements if desired. Whether for an individual launcher, or for multiple launchers, use the launcher repair request form and write “maintenance needed” in the area used to describe problems. Fill out the balance of the information as instructed on the form. The minimum charge for simple routine maintenance is $10.00 per launcher plus return shipping. Launchers sent in for maintenance that also require repair will receive a quote for services prior to proceeding with repairs. Please use the following form for all launcher repair/maintenance requests. Print the form, follow the instructions and include it with your shipment. The more information you can provide on the problem you are experiencing, the easier it is for us to isolate the issue and determine a course of action. If you have dismantled your launcher at all, place all available parts in an envelope or sandwich bag and include with your package. Be sure to note if your launcher repair is urgent.
                       </p>

                       <p>
                        Launcher Repair Request Form Customer Launcher Repair Request
                       </p>
    

                </div>

				<div class="col-lg-6">
                    <div class="banner-frame"> <img class="img-fluid" src="{{asset('images/launcher-repair.jpg')}}" alt="" />
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