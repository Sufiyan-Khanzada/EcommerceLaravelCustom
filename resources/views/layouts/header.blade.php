    <!-- Start Main Top -->
    <div class="main-top">
        <div class="container-fluid">
            <div class="row">
            <div class="text-slid-box">
                        <div id="offer-box" class="carouselTicker">
                            <ul class="offer-box">
                                <li>
        		                    Our offices are open Monday thru Friday 8.00 am to 4.00 pm PT.  If you have any questions please call the office on 760-377-5766 during these times.
                                </li>
                                <li>
        			                ***PLEASE NOTE THAT OUR WEBSITE ORDERING IS CURRENTLY UNAVAILABLE.  PLEASE CALL THE OFFICE ON 760-377-5766 TO PLACE ANY ORDERS.  WE APOLOGIZE FOR THE INCONVENIENCE***
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					
                    <div class="right-phone-box">
                        <p>Call US <a href="tel:760-377-5766">(760) 377-5766</a>,<a href="tel:855-374-3473">855-FPI-FIRE (855-374-3473)</a></p>
                    </div>
                
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="login-box">
						<select id="basic" class="selectpicker show-tick form-control" data-placeholder="Sign In">
							<option>Register Here</option>
							<option>Sign In</option>
						</select>
					</div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Top -->

    <!-- Start Main Top -->
    <header class="main-header">
        <!-- Start Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default bootsnav">
            <div class="container">
                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                    <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('images/logo.png')}}" class="logo" alt="" height="60" style="margin-left:-76px;"></a>
                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav ml-auto" data-in="fadeInDown" data-out="fadeOutUp">
                        <li class="nav-item active"><a class="nav-link" href="{{route('home')}}">Home</a></li>
                        <!-- <li class="nav-item"><a class="nav-link" href="{{route('about')}}">About Us</a></li> -->

                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle " href="{{route('about')}}" data-toggle="dropdown">About</a>
                            <ul class="dropdown-menu">
								<li><a href="{{route('company.history')}}">Company History</a></li>
								<li><a href="{{route('careers')}}">Careers</a></li>
                                <li><a href="{{asset('testimonials')}}">Testinomials</a></li>
                                <li><a href="{{asset('faq')}}">FAQs</a></li>
                                <li><a href="{{asset('documents')}}">Documents</a></li>
                                <li><a href="{{asset('news')}}">News</a></li>
                            </ul>
                        </li> 


                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle" href="{{route('flares')}}" data-toggle="dropdown">Flares</a>
                            <ul class="dropdown-menu">
								<li><a href="{{route('flares-overview')}}">Overview</a></li>
								<li><a href="{{route('flares')}}">Flares for Sale</a></li>
                                <li><a href="{{asset('flares-news')}}">News</a></li>
                               
                            </ul>
                        </li> 

                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle " href="{{route('launchers')}}" data-toggle="dropdown">Launchers</a>
                            <ul class="dropdown-menu">
								<li><a href="{{route('launchers-overview')}}">Overview</a></li>
								<li><a href="{{route('launchers')}}">Launchers for Sale</a></li>
                                <li><a href="{{asset('launchers-news')}}">News</a></li>
                               
                            </ul>
                        </li> 


                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle " href="{{route('firequick-accessories')}}" data-toggle="dropdown">Fire Items</a>
                            <ul class="dropdown-menu">
								<li><a href="{{route('fire-accessories-overview')}}">Overview</a></li>
								<li><a href="{{route('firequick-accessories')}}">Fire Accessories for Sale</a></li>
                                <li><a href="{{asset('fire-news')}}">News</a></li>
                               
                            </ul>
                        </li> 



                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle " href="{{route('services')}}" data-toggle="dropdown">Services</a>
                            <ul class="dropdown-menu">
								<li><a href="{{route('fire-accessories-overview')}}">Overview</a></li>
								<li><a href="{{route('launcher-repair-services')}}">Launch Repair Services</a></li>
                                <li><a href="{{asset('fire-training-services')}}">Fire Traning Services</a></li>
                                <li><a href="{{asset('safety-training-videos')}}">Safety Traning Videos</a></li>
                                
                               
                            </ul>
                        </li> 

                        <!-- <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle arrow" data-toggle="dropdown">SHOP</a>
                            <ul class="dropdown-menu">
								<li><a href="{{route('shop')}}">Sidebar Shop</a></li>
								<li><a href="{{route('shop-detail')}}">Shop Detail</a></li>
                                <li><a href="{{asset('cart')}}">Cart</a></li>
                                <li><a href="{{asset('checkout')}}">Checkout</a></li>
                                <li><a href="{{asset('my-account')}}">My Account</a></li>
                                <li><a href="{{asset('wishlist')}}">Wishlist</a></li>
                            </ul>
                        </li> -->
                        <li class="nav-item"><a class="nav-link" href="{{asset('gallery')}}">Gallery</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{asset('contact-us')}}">Contact</a></li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->

                <!-- Start Atribute Navigation -->
                <div class="attr-nav">
                    <ul>
                        <!-- <li class="search"><a href="#"><i class="fa fa-search"></i></a></li> -->
                        <li class="side-menu">
							<a href="{{route('cart')}}">
								<i class="fa fa-shopping-bag"></i>
								<span class="badge">3</span>
								<p>My Cart</p>
							</a>
						</li>
                    </ul>
                </div>
                <!-- End Atribute Navigation -->
            </div>
            <!-- Start Side Menu -->
            <div class="side">
                <a href="#" class="close-side"><i class="fa fa-times"></i></a>
                <li class="cart-box">
                    <ul class="cart-list">
                        <li>
                            <a href="#" class="photo"><img src="images/img-pro-01.jpg" class="cart-thumb" alt="" /></a>
                            <h6><a href="#">Delica omtantur </a></h6>
                            <p>1x - <span class="price">$80.00</span></p>
                        </li>
                        <li>
                            <a href="#" class="photo"><img src="images/img-pro-02.jpg" class="cart-thumb" alt="" /></a>
                            <h6><a href="#">Omnes ocurreret</a></h6>
                            <p>1x - <span class="price">$60.00</span></p>
                        </li>
                        <li>
                            <a href="#" class="photo"><img src="images/img-pro-03.jpg" class="cart-thumb" alt="" /></a>
                            <h6><a href="#">Agam facilisis</a></h6>
                            <p>1x - <span class="price">$40.00</span></p>
                        </li>
                        <li class="total">
                            <a href="#" class="btn btn-default hvr-hover btn-cart">VIEW CART</a>
                            <span class="float-right"><strong>Total</strong>: $180.00</span>
                        </li>
                    </ul>
                </li>
            </div>
            <!-- End Side Menu -->
        </nav>
        <!-- End Navigation -->
    </header>
    <!-- End Main Top -->

    <!-- Start Top Search -->
    <div class="top-search">
        <div class="container">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
            </div>
        </div>
    </div>
    <!-- End Top Search -->