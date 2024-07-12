@extends('layouts.main') 

@section('content')
	<style>
	.marquee {
		/*width: 450px;*/
		width: 100%;
		margin: 0 auto;
		overflow: hidden;
		white-space: nowrap;
		box-sizing: border-box;
		animation: marquee 30s linear infinite;
	}
	
	.marquee:hover {
		animation-play-state: paused
	}
	/* Make it move */
	
	@keyframes marquee {
		/*0%   { text-indent: 27.5em }*/
		0% {
			text-indent: 90.5em
		}
		100% {
			text-indent: -105em
		}
	}
	</style>
	<section id="page-title" class="background-overlay" data-parallax-image="https://www.firequick.com/assets/images/banner/banner.jpg">
		<div class="container">
			<div class="page-title">
				<!--<h1 class="text-uppercase text-medium">myaccount</h1>-->
				<h1 class="text-uppercase text-medium">My Account</h1> </div>
		</div>
	</section>
	<!-- </div> -->
	<section class="custom-section">
		<div class="container">
			<div class="col-md-3 no-padding" style="width: 8%;">
				<ul type="none">
					<li> </li>
					<li><a href="{{route('myaccount.downloads')}}">Downloads</a></li>
					<li><a href="{{route('myaccount.orders')}}">Orders</a></li>
					<li><a href="{{route('myaccount.details')}}">My details</a></li>
					<li><a href="{{route('logout')}}">Logout</a></li>
				</ul>
			</div>
			<div class="col-md-9">
                @yield('myaccount-content')
			</div>
		</div>
	</section> 
@endsection