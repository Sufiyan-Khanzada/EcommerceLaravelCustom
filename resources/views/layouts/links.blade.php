
	<!-- Stylesheets & Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,800,700,600|Montserrat:400,500,600,700|Raleway:100,300,600,700,800" rel="stylesheet" type="text/css"/>
	<link href="{{asset('css/plugins.css')}}" rel="stylesheet">
	<link href="{{asset('css/style.css')}}" rel="stylesheet">
	<link href="{{asset('css/custom-style.css')}}" rel="stylesheet">
	<link href="{{asset('css/responsive.css')}}" rel="stylesheet">
	<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
	
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('favicon/site.webmanifest">

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
