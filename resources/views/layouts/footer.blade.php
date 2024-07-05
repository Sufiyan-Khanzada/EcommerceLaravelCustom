<!-- Start footer -->
<footer class="footer-section">
    <div class="container">
        <div class="row">
            <div class="Subscribe">
                <h1>SIGNUP FOR PRODUCT UPDATES</h1>
                <input type="text" name="" placeholder="Enter your email address">
                <button type="button">Subscribe</button>
            </div>
            <div class="social-link">
                <a href="https://www.facebook.com/Firequickproducts/" title="" target="_blank"><i class="fa fa-facebook"></i></a>
                <a href="https://www.instagram.com/firequick/" title="" target="_blank"><i class="fa fa-instagram"></i></a>
                <a href="https://www.linkedin.com/company/firequick-products-inc-/" title="" target="_blank"><i class="fa fa-linkedin"></i></a>
            </div>
        </div>

        <?php
        $siteinfo = \App\Models\BottomMenu::where('status', 1)
            ->where('place', 'siteinfo')
            ->orderBy('order', 'asc')
            ->get();

        $customerservices = \App\Models\BottomMenu::where('status', 1)
            ->where('place', 'customerservices')
            ->orderBy('order', 'asc')
            ->get();

        ?>
        <div class="row">
            <div class="col-md-4">
                <div class="widget">
                    <h4>Site Info</h4>
                    <ul>

                        <li><a href=""></a></li>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{route('products', ['categoryId' => 2])}}">Flares</a></li>
                        <li><a href="{{route('products', ['categoryId' => 3])}}">Launchers</a></li>
                        <li><a href="{{route('products', ['categoryId' => 4])}}">Firequick Accessories</a></li>

                        @foreach($siteinfo as $value)
                        @php
                        $string = str_replace(' ', '-', $value->title); // Replaces all spaces with hyphens.
                        $tit = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special characters.
                        @endphp
                        <li>
                            <a href="{{ url('page/' . $value->page_id . '/' . $tit) }}">{{ $value->title }}</a>
                        </li>
                        @endforeach




                        <!-- <li> <a href="{{route('services')}}" >Services</a></li>
                                                        
                            
        <li> <a href="{{ route('faq') }}" >FAQ</a></li> -->
                        <li><a href="{{route('gallery')}}">Gallery</a></li>

                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="widget">
                    <h4>Customer Service</h4>
                    <ul>
                        @foreach($customerservices as $value)
                        @php
                        $string = str_replace(' ', '-', $value->title); // Replaces all spaces with hyphens.
                        $tit = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special characters.
                        @endphp
                        <li>
                            <a href="{{ url('page/' . $value->page_id . '/' . $tit) }}">{{ $value->title }}</a>
                        </li>
                        @endforeach
                        <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                    </ul>
                </div>
            </div>


            <style>
                .teltoll {
                    color: #cbc9c8;
                }
            </style>
            <div class="col-md-4">
                <div class="widget">
                    <h4>Contact Us</h4>
                    <p><span>Address : </span>{{ $admin->address}}</p>


                    <p><span>Phone: </span> <a class="teltoll" href="tel:{{ $admin->phone }}" target="_blank">{{ $admin->phone }}</a> </p>
                    <p><span>Toll Free: </span> <a class="teltoll" href="tel:{{ $admin->tollfree}}" target="_blank"> {{ $admin->tollfree}}</a> </p>




                    <p> <span>Fax: </span> {{ $admin->fax}} </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <p>Copyright © 2020. Firequick Products Inc. All rights reserved.</p>
            </div>
            <div class="col-md-2">
                <div class="payment pull-right">
                    <i class="fa fa-cc-visa"></i>
                    <i class="fa fa-cc-mastercard"></i>
                </div>
            </div>
        </div>
    </div>
</div>