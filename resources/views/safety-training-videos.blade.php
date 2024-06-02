@extends('layouts.main')
@section('content')
     
		<!-- Menu Start Section -->
<style>
    .stv-description {
        margin: 35px 0;
    }

    .stv-description p {
        margin: 0;
        font-size: 18px;
    }

    .stv-list,
    .stv-list>div,
    .stv-list>div p {
        padding: 0;
    }

    .stv-list>div {
        flex: 0 0 32%;
        max-width: 32%;
        margin-bottom: 30px;
    }

    .stv-list iframe {
        width: 100%;
        height: 220px;
    }

    .stv-list {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .stv-list>div p {
        text-transform: uppercase;
    }

    @media screen and (min-width: 767px) and (max-width: 1024px) {
        .stv-list>div {
            flex: 0 0 48%;
            max-width: 48%;
        }
    }

    @media screen and (min-width: 601px) and (max-width: 766px) {
        .stv-list>div {
            flex: 0 0 48%;
            max-width: 48%;
        }

        .container {
            width: 95% !important;
        }
    }

    @media screen and (min-width: 360px) and (max-width: 600px) {
        .stv-list>div {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .container {
            width: 90% !important;
        }
    }
</style>
<section id="page-title" class="background-overlay" data-parallax-image="{{asset('images/banner/banner.jpg')}}">
    <div class="container">
        <div class="page-title">
            <h1 class="text-uppercase text-medium">safety&nbsp;&nbsp;training&nbsp;&nbsp;videos</h1>
            <!--      <span>Home > Company History</span> -->
        </div>
    </div>
</section>
<!-- end: Page title -->
<div id="stv" class="container">
    <div class="row">
        <div class="col-md-12 stv-description">
            <p>{{ $data['description'] }}</p>
        </div>
                <div class="col-md-12 stv-list">
                                
                <?php
              
            if (!empty($data['youtube_url'])) {
                foreach ($data['youtube_url'] as $key => $value) {
                    $url1 = explode('watch?v=', $value);
                    $url2 = explode('&', $url1[1]);
                    $videoID = $url2[0];
                    $embedURL = "https://www.youtube.com/embed/" . $videoID;
            ?>
                    <div class="col-md-4">
                        <iframe src="<?php echo isset($embedURL) ? $embedURL : ''; ?>"></iframe>
                        <p><?php echo isset($youtube_title[$key]) ? $youtube_title[$key] : ''; ?></p>
                    </div>
            <?php
                }
            }
            ?>               
                                    
             </div>
    </div>
</div><!-- Start footer -->
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