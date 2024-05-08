<!DOCTYPE html>
<html lang="en" id="html-mode" >
  <head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Any config settings you want to fetch you will get in $config array, -->
    <?php //echo $config['COMPANY']; ?>
    <title>{{isset($title)?$title:''}}</title>
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{asset('assets/images/apple-touch-icon.png')}}">
  
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.links')
    @yield('css')
  </head>
  <body >
    
    <input type="hidden" id="web_base_url" value="{{url('/')}}"/>
    @include('layouts.header') 
    @yield('content')
    @include('layouts.footer') 
    @include('layouts.scripts')
    @yield('js')
    <script type="text/javascript">
(()=>{
  

		@if (session('notify_success'))
		$.toast({
				heading: 'Success!',
				position: 'bottom-right',
				text:  '{{session('notify_success')}}',
				loaderBg: '#ff6849',
				icon: 'success',
				hideAfter: 2000,
				stack: 6
			});
      @elseif (session('notify_error'))
      $.toast({
						heading: 'Error!',
						position: 'bottom-right',
						text:  '{{session('notify_error')}}',
						loaderBg: '#ff6849',
						icon: 'error',
						hideAfter: 2000,
						stack: 6
					});
        @endif



})()
    </script>
    @include('layouts.errorhandler')
  
  </body>
  <div id="preloader" style="display:none;">  
    <div class="loading">
        <span>Loading...</span>
    </div>
    
</html>