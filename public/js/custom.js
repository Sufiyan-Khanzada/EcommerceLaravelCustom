/* 

1. Add your custom JavaScript code below
2. Place the this code in your template:

*/


$(function () {
    $('#cc').mask('0000000000000000');
    $('#year').mask('0000');
    $('#csc').mask('0000');
    $('#CheckOutPaytrace').click(function () {
        
        $('.paytrace-checkout-container').slideDown('slow');
    });

    var owl = $('.owl-carousel');
    owl.owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 8000,
        autoplayHoverPause: false,
        nav: false,
		dots: false,
        navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"]
    });

});