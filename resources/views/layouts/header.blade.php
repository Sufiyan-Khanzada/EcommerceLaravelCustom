<?php
$this->db->select( 'menus.menu_id,menus.status as `menu_status`,menus.title as `menu_title`,posts.post_id,posts.title as`post_title`, posts.status as `post_status` ' );
$this->db->from( 'posts' );
$this->db->join( 'menus', 'menus.post_id = posts.post_id' );

$menu = $this->db->get()->result_array();


$this->db->select( 'submenus.menu_id,submenus.status as `submenu_status`,submenus.title as `submenu_title`,posts.post_id,posts.title as`post_title`, posts.status as `post_status` ' );
$this->db->from( 'posts' );
$this->db->join( 'submenus', 'submenus.post_id = posts.post_id' );
$submenu = $this->db->get()->result_array();;


//         echo "<pre>";
//         print_r($menu);   
//                      print_r($submenu);

// die();    

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<meta name="author" content="FIREQUICK"/>
	<meta name="description" content="">
	<!-- Document title -->
	<title>Firequick Products, Inc.</title>
	<!-- Stylesheets & Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,800,700,600|Montserrat:400,500,600,700|Raleway:100,300,600,700,800" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url();?>assets/css/plugins.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/css/custom-style.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/css/responsive.css" rel="stylesheet">
	<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
	
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url();?>assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url();?>assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo base_url();?>assets/favicon/site.webmanifest">


	<script type="text/javascript">
		function googleTranslateElementInit() {
			new google.translate.TranslateElement( {
				pageLanguage: 'en',
				layout: google.translate.TranslateElement.InlineLayout.SIMPLE
			}, 'google_translate_element' );
		}
	</script>

</head>

<body>

	<!--<style>-->
	
	<!--    .marquee-parent {-->
	<!--          position: relative;-->
	<!--          width: 100%;-->
	<!--          overflow: hidden;-->
	<!--          height: 30px;-->
	<!--        }-->
	<!--        .marquee-child {-->
	<!--          display: block;-->
	<!--/*width: 100%;*/-->
	<!--/* width of your text div */-->
	<!--          height: 30px;-->
	<!--/* height of your text div */-->
	<!--          position: absolute;-->
	<!--animation: marquee 30s linear infinite; /* change 5s value to your desired speed */-->
	<!--        }-->
	<!--        .marquee-child:hover {-->
	<!--          animation-play-state: paused;-->
	<!--          cursor: pointer;-->
	<!--        }-->
	<!--        @keyframes marquee {-->
	<!--          0% {-->
	<!--            left: 100%;-->
	<!--          }-->
	<!--          100% {-->
	<!--left: -647px /* same as your text width */-->
	<!--          }-->
	<!--        }-->
	<!--</style>-->


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

	<!--<div class="marquee"><b>In case of Air shipping you need to call the office as the shipping in this situation is quite different.</b>-->
	</div>


	<?php

	$newsbar = $this->db->get_where( 'newsbars', array( 'status' => 1 ) );
	if ( $newsbar->num_rows() > 0 ) {
        
        foreach($newsbar->result_array() as $value){
        ?>
        	<div class="marquee">
        		<b>
        			<?php echo $value['discription']; ?>
        		</b>
        	</div>
        
         <?php   
        }
        
        
     
	}
	?>

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
								<a href="<?php echo base_url();?>" class="logo" data-dark-logo="<?php echo base_url();?>assets/images/services-training/logo.png">
									<img src="<?php echo base_url();?>assets/images/services-training/logo.png" alt="Polo Logo">
								</a>

							</div>
							<!--End: Logo-->
						
						</div>
						<div class="col-xs-12 col-sm-7 col-md-7">
							
							<div class="top-header-right">
								<a href="tel:760-377-5766">Call <?php echo $data2['phone']?></a><span style="color: #fff;">,</span>&nbsp;<a href="tel:855-374-3473"><?php echo $data2['tollfree']; ?></a>
							</div>
							<div class="site_needguns_wrap">
									<div class="top-header-left new-btn-div" style="display:none;>
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

					<?php

					if ( !empty( $this->session->userdata( 'firequick' ) ) ) {
						?>
					<div>
						<a href="<?php echo base_url('page/myaccount');?>">
                                        <i class="fa fa-user"></i><span>My Account</span>
                                    </a>
					

						<a href="<?php echo base_url('action/logout');?>">
                                        <i class="fa fa-sign-out"></i><span>Logout</span>
                                    </a>
					


					</div>

					<?php
					} else {
						?>

					<div>
						<a href="<?php echo base_url('page/login');?>">
                                        <i class="fa fa-sign-in"></i><span>Login</span>
                                    </a>
					

						<a href="<?php echo base_url('page/registration');?>">
                                        <i class="fa fa-user-plus"></i><span>Register</span>
                                    </a>
					


					</div>

					<?php
					}
					?>

				</div>								
							
							</li>
							
							<li class="hidden-xs">
								<!--shopping cart-->
								<div id="shopping-cart">
									<a href="<?php echo base_url('page/cart');?>">
                                        <span class="shopping-cart-items" style="height: 19px;
										   text-align:center;
											padding: 5px;
											right: -11px;
											top: -12px;
											width: 19px;
										"><?php echo $this->cart->total_items();?></span>
                                        <i class="fa fa-shopping-cart"></i></a>
								</div>
								<!--end: shopping cart-->
							</li>
							
							
						</ul>
					</div>
					<!--end: Header Extras-->
						
						
						</div>
					</div>
					

					<!--Top Search Form-->
					<!-- <div id="top-search">
                        <form action="search-results-page.html" method="get">
                            <input type="text" name="q" class="form-control" value="" placeholder="Start typing & press  &quot;Enter&quot;">
                        </form>
                    </div> -->
					<!--end: Top Search Form-->


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
									<li><a href="<?php echo base_url();?>">Home</a>
									</li>
									
									</li>
									<?php
									if ( isset( $menu ) ) {
										foreach ( $menu as $key => $value ) {
											if ( $value[ 'menu_status' ] == 1 ) {
												$string = str_replace( ' ', '-', $value[ 'menu_title' ] ); // Replaces all spaces with hyphens.

												$tit = preg_replace( '/[^A-Za-z0-9\-]/', '', $string );

												$flag = false;
												foreach ( $submenu as $k => $v ) {
													if ( $v[ 'submenu_status' ] == 1 ) {
														if ( $value[ 'menu_id' ] == $v[ 'menu_id' ] ) {

															$flag = true;
														}
													}
												}
												if ( $flag == true ) {
													$a = '<li class="dropdown"><a href="' . base_url( "page/" . $value[ 'post_id' ] . "/" . $tit . "" ) . '">' . $value[ 'menu_title' ] . '</a>';
													echo $a;
												} else {
													$a = '<li ><a href="' . base_url( "page/" . $value[ 'post_id' ] . "/" . $tit . "" ) . '">' . $value[ 'menu_title' ] . '</a>';
													echo $a;
												}


												if ( $flag == true ) {
													echo '<ul class="dropdown-menu">';
												}
												foreach ( $submenu as $k => $v ) {

													$string2 = str_replace( ' ', '-', $v[ 'submenu_title' ] ); // Replaces all spaces with hyphens.

													$tit2 = preg_replace( '/[^A-Za-z0-9\-]/', '', $string2 );
													// echo $tit2;
													if ( $v[ 'submenu_status' ] == 1 ) {
														if ( $value[ 'menu_id' ] == $v[ 'menu_id' ] ) {

															echo '<li><a href="' . base_url( "page/" . $v[ 'post_id' ] . "/" . $tit2 . "" ) . '">' . $v[ 'submenu_title' ] . '</a></li>';
														}
													}
												}
												echo '<li><a href="' . base_url( 'page/documents' ) . '">Documents</a></li>';
												echo '<li><a href="' . base_url( 'page/news' ) . '">News</a></li>';

												if ( $flag == true ) {
													echo '</ul>';
												}
												echo '</li>';

											}

										}



									}
									?>
									<!--<li><a href="<?php echo base_url('page/products');?>">Products</a>-->
									
									
									
									
									<li class="dropdown"><a href="<?php echo base_url('page/products/category/3');?>">Flares</a>
										<ul class="dropdown-menu">
											<li><a href="<?php echo base_url('page/flare-overview');?>">Overview</a>
											</li>
											<li><a href="<?php echo base_url('page/products/category/3');?>">Flares For Sale</a>
											</li>
											<li><a href="<?php echo base_url('page/flare-news');?>">News</a>
											</li>
										</ul>


									</li>
									<li class="dropdown"><a href="<?php echo base_url('page/products/category/2');?>">Launchers</a>
										<ul class="dropdown-menu">
											<li><a href="<?php echo base_url('page/launchers-overview');?>">Overview</a>
											</li>
											<li><a href="<?php echo base_url('page/products/category/2');?>">Launchers For Sale</a>
											</li>
											<li><a href="<?php echo base_url('page/launcher-news');?>">News</a>
											</li>
										</ul>


									</li>
									<li class="dropdown"><a href="<?php echo base_url('page/products/category/4');?>">Fire Accessories</a>
										<ul class="dropdown-menu">
											<li><a href="<?php echo base_url('page/fire-accessories-overview');?>">Overview</a>
											</li>
											<li><a href="<?php echo base_url('page/products/category/4');?>">Fire Accessories For Sale</a>
											</li>
											<li><a href="<?php echo base_url('page/fire-accessories-news');?>">News</a>
											</li>
										</ul>


									</li>
									
									
									
									
									
									
									
									
									<li class="dropdown"><a href="/page/23/Services">Services</a>
										<ul class="dropdown-menu">
											<li><a href="<?php echo base_url('/page/23/Services');?>">Overview</a>
											</li>
											<li><a href="<?php echo base_url('/page/launcher-repair-services');?>">Launcher repair services</a>
											</li>
											<li><a href="<?php echo base_url('page/fire-training-services');?>">Fire Training Services</a>
											</li>
											<li><a href="<?php echo base_url('page/safety-training-videos');?>">Safety Training Videos</a>
										</ul>


									</li>
									<li><a href="<?php echo base_url('page/gallery');?>">Gallery</a>
									</li>
									<li><a href="<?php echo base_url('page/contact-us');?>">Contact Us</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
					<!--end: Navigation-->

		</header>
		<!-- end: Header -->
		<?php 
        if($data['title'] == 'home'){
        // if(1){
            // print_r($data);
        
?>

		<!-- Inspiro Slider -->
		<div id="slider0" class="inspiro-slider0 slider-fullscreen0 arrows-large arrows-creative dots-creative owl-carousel owl-theme" data-height-xs="360">
			<!-- Slide 1 -->
			<div class="slide0 background-overlay-dark item" style="background-image: url(<?php echo base_url('assets/images/banner/Header-1.jpg');?>);">
				<div class="container">
					<div class="slide-captions text-center">
						<!-- Captions -->
						<h2 class="text-light">In the challenging wild land fire environment, stay safer with 300’ flare travel and delayed remote ignition.</h2>
					</div>
				</div>
				<!-- div id="scroll-down" class="scrolldown-animation scrolldown-bottom">

                        <img alt="" src="<?php //echo base_url();?>assets/images/scrolldown.png">

                </div -->
			</div>
			<!-- end: Slide 1 -->
			<!-- Slide 2 -->
			<div class="slide0 background-overlay-dark item" style="background-image: url(<?php echo base_url('assets/images/banner/Header-2.jpg');?>);">
				<div class="container">
					<div class="slide-captions text-center">
						<!-- Captions -->
						<h2 class="text-light">Firequick flares burn hotter, faster, longer than the competition – don’t waste your time with inferior products!</h2>
					</div>
				</div>
				<!-- div id="scroll-down" class="scrolldown-animation scrolldown-bottom">
                    
                        <img alt="" src="<?php //echo base_url();?>assets/images/scrolldown.png">
                    
                </div -->
			</div>
			<!-- end: Slide 2 -->
			<!-- Slide 3 -->
			<div class="slide0 background-overlay-dark item" style="background-image: url(<?php echo base_url('assets/images/banner/Header-3.jpg');?>);">
				<div class="container">
					<div class="slide-captions text-center">
						<!-- Captions -->
						<h2 class="text-light">When you need rugged products designed specifically for your burn operations you need Firequick.</h2>
						<!-- end: Captions -->
					</div>

				</div>
				<!-- div id="scroll-down" class="scrolldown-animation scrolldown-bottom">
                    
                        <img alt="" src="<?php //echo base_url();?>assets/images/scrolldown.png">
                    
                </div -->
			</div>
			<!-- end: Slide 3 -->
			<!-- Slide 4 -->
			<div class="slide0 background-overlay-dark item" style="background-image: url(<?php echo base_url('assets/images/banner/Header-4.jpg');?>);">
				<div class="container">
					<div class="slide-captions text-center">
						<!-- Captions -->
						<h2 class="text-light">
                        For prescribed or control burns, flash to wet and heavy fuels, Firequick has the right flare for the job!</h2>
					
						<!-- end: Captions -->
					</div>

				</div>
				<!-- div id="scroll-down" class="scrolldown-animation scrolldown-bottom">
                    
                        <img alt="" src="<?php //echo base_url();?>assets/images/scrolldown.png">
                    
                </div -->
			</div>
			<!-- end: Slide 4 -->
			
			<!-- Slide 5 -->
			<div class="slide0 background-overlay-dark item" style="background-image: url(<?php echo base_url('assets/images/banner/Header-5.jpg');?>);">
				<div class="container">
					<div class="slide-captions text-center">
						<!-- Captions -->
						<h2 class="text-light">
                        Fight fire with fire! Unprecedented 4000°F burn with a guaranteed 95% ignition rate – We’ve got you covered!</h2>
					
						<!-- end: Captions -->
					</div>

				</div>
				<!-- div id="scroll-down" class="scrolldown-animation scrolldown-bottom">
                    
                        <img alt="" src="<?php //echo base_url();?>assets/images/scrolldown.png">
                    
                </div -->
			</div>
			<!-- end: Slide 5 -->
			
			
			
			<!-- Slide 5 -->
			<!--<div class="slide background-overlay-dark" style="background-image: url(<?php echo base_url('assets/images/banner/banner-4.jpg');?>);">-->
			<!--    <div class="container">-->
			<!--        <div class="slide-captions text-center">-->
			<!-- Captions -->
			<!--            <h2 class="text-light">Fight fire with fire! Unprecedented 4000°F burn with a guaranteed 95% ignition rate – We’ve got you covered!</h2>-->

			<!--        </div>-->

			<!--    </div>-->
			<!--    <div id="scroll-down" class="scrolldown-animation scrolldown-bottom">-->

			<!--            <img alt="" src="<?php echo base_url();?>assets/images/scrolldown.png">-->

			<!--    </div>-->
			<!--</div>-->
			<!-- end: Slide 5 -->
		</div>
		<!--end: Inspiro Slider -->

		<?php
		}
		?>

		<!-- end: Wrapper -->

		<!-- Menu Start Section -->