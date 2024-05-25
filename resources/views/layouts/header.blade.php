@if(count($getNews) > 0)
@foreach ($getNews as $getNew)
<div class="marquee">
<b>{{ $getNew->discription }}</b>
</div>	
@endforeach

@endif
        
                 	
        
         
	<!-- Wrapper -->
	<div id="wrapper">
		<!-- Header -->
		<header id="header" class="header-transparent dark">
		
			<div id="header-wrap">
				<div class="container">
					
					<div class="row">
						<div class="col-xs-12 col-sm-5 col-md-5">
							<!--Logo-->
							<div id="logo">
								<a href="{{ route('home') }}" class="logo" data-dark-logo="{{asset('images/services-training/logo.png')}}">
									<img src="{{asset('images/services-training/logo.png')}}" alt="Polo Logo">
								</a>

							</div>
							<!--End: Logo-->
						
						</div>
						<div class="col-xs-12 col-sm-7 col-md-7">
							
							<div class="top-header-right">
								<a href="tel:760-377-5766">Call (760) 377-5766</a><span style="color: #fff;">,</span>&nbsp;<a href="tel:855-374-3473">855-FPI-FIRE (855-374-3473)</a>
							</div>
							<div class="site_needguns_wrap">
									<div class="top-header-left new-btn-div" style="display:none;">
						<a href="http://www.gunstores.net/about/about.aspx?d=wxmmLYeS6Ig=&u=&g=&z=tMxIW4mepAM=">
                                    <span>Need guns? Visit Firequick Firearms here!</span>
                                </a>
					


					</div>
								
								<div id="google_translate_element" class="google-translate"></div>
							</div>
					<!--Header Extras-->
					<div class="header-extras">
						<ul>
							
							<li>
							
				<div class="top-header-second top-header-left">

					@if(isset($user) && $user)
						<div>
							<a href="{{route('my-account')}}">
								<i class="fa fa-user"></i><span>My Account</span>
							</a>

							<a href="{{route('logout')}}">
								<i class="fa fa-sign-out"></i><span>Logout</span>
							</a>
						</div>
					@else
						<div>
							<a href="{{route('login')}}">
											<i class="fa fa-sign-in"></i><span>Login</span>
										</a>

							<a href="{{route('registration')}}">
											<i class="fa fa-user-plus"></i><span>Register</span>
										</a>
						</div>
					@endif

					
				</div>								
							
							</li>
							
							<li class="hidden-xs">
								<!--shopping cart-->
								<div id="shopping-cart">
									<a href="{{route('cart')}}">
                                        <span class="shopping-cart-items" style="height: 19px;
										   text-align:center;
											padding: 5px;
											right: -11px;
											top: -12px;
											width: 19px;
										">0</span>
                                        <i class="fa fa-shopping-cart"></i></a>
								</div>
								<!--end: shopping cart-->
							</li>
							
							
						</ul>
					</div>
					<!--end: Header Extras-->
						
						
						</div>
					</div>
					



					<!--Navigation Resposnive Trigger-->
					<div id="mainMenu-trigger">
						<button class="lines-button x"> <span class="lines"></span> </button>
					</div>
					<!--end: Navigation Resposnive Trigger-->

				</div>
			</div>
			
								<!--Navigation-->
					<div id="mainMenu" class="light">
						<div class="container">
							
						
							<nav>
								<ul>
									<li>
										<a href="{{route('home')}}">Home</a>
									</li>


									<?php
								
								if (isset($menuItems)) {
									foreach ($menuItems as $key => $value) {
										if ($value->menu_status == 1) { // Accessing object property using object syntax
											$string = str_replace(' ', '-', $value->menu_title); // Replaces all spaces with hyphens.
								
											$tit = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
								
											$flag = false;
											foreach ($subMenuItems as $k => $v) {
												if ($v->submenu_status == 1) { // Accessing object property using object syntax
													if ($value->menu_id == $v->menu_id) { // Accessing object property using object syntax
														$flag = true;
													}
												}
											}
											if ($flag == true) {
												$a = '<li class="dropdown"><a href="' . route('page', ['pageId' => $value->post_id, 'pageTitle' => $tit]) . '">' . $value->menu_title . '</a>';
												echo $a;
											} else {
												$a = '<li ><a href="' . route('page', ['pageId' => $value->post_id, 'pageTitle' => $tit]) . '">' . $value->menu_title . '</a>';
												echo $a;
											}
								
											if ($flag == true) {
												echo '<ul class="dropdown-menu">';
											}
											foreach ($subMenuItems as $k => $v) {
								
												$string2 = str_replace(' ', '-', $v->submenu_title); // Replaces all spaces with hyphens.
								
												$tit2 = preg_replace('/[^A-Za-z0-9\-]/', '', $string2);
												// echo $tit2;
												if ($v->submenu_status == 1) { // Accessing object property using object syntax
													if ($value->menu_id == $v->menu_id) { // Accessing object property using object syntax
														echo '<li><a href="' . route('page', ['pageId' => $v->post_id, 'pageTitle' => $tit2]) . '">' . $v->submenu_title . '</a></li>';
													}
												}
											}
										
											echo '<li><a href="' . route('documents') . '">Documents</a></li>';
											echo '<li><a href="' . route('news') . '">News</a></li>';
								
											if ($flag == true) {
												echo '</ul>';
											}
											echo '</li>';
										}
									}
								}
								
									?>

									<li class="dropdown"><a href="{{route('products', ['categoryId' => 2])}}">Flares</a>
										<ul class="dropdown-menu">
											<li><a href="{{route('flares-overview')}}">Overview</a>
											</li>
											<li><a href="{{route('products', ['categoryId' => 2])}}">Flares For Sale</a>
											</li>
											<li><a href="{{route('news')}}">News</a>
											</li>
										</ul>


									</li>
									<li class="dropdown"><a href="{{route('products', ['categoryId' => 3])}}">Launchers</a>
										<ul class="dropdown-menu">
											<li><a href="{{route('launchers-overview')}}">Overview</a>
											</li>
											<li><a href="{{route('products', ['categoryId' => 3])}}">Launchers For Sale</a>
											</li>
											<li><a href="{{route('launchers-news')}}">News</a>
											</li>
										</ul>


									</li>
									<li class="dropdown">
										<a href="{{route('products', ['categoryId' => 4])}}">Fire Accessories</a>
										<ul class="dropdown-menu">
											<li><a href="{{route('fire-accessories-overview')}}">Overview</a>
											</li>
											<li><a href="{{route('products', ['categoryId' => 4])}}">Fire Accessories For Sale</a>
											</li>
											<li><a href="{{route('news')}}">News</a>
											</li>
										</ul>


									</li>

									<li class="dropdown">
										<a href="/page/23/Services">Services</a>
										<ul class="dropdown-menu">
											<li><a href="/page/23/Services">Overview</a>
											</li>
											<li><a href="{{route('launcher-repair-services')}}">Launcher repair services</a>
											</li>
											<li><a href="{{route('fire-training-services')}}">Fire Training Services</a>
											</li>
											<li><a href="{{route('safety-training-videos')}}">Safety Training Videos</a>
										</ul>


									</li>
									<li><a href="{{route('gallery')}}">Gallery</a>
									</li>
									<li><a href="{{route('contact-us')}}">Contact Us</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
					<!--end: Navigation-->

		</header>
		<!-- end: Header -->