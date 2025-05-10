
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('backend.layouts.partials.meta_tags')
    <title>@yield('title', config('app.name'))</title>
    @include('backend.layouts.partials.styles')
    @yield('styles')    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id="></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '');
    </script>  

    <!--Ckeditor4 -->
<script src="{{ asset('public/js/ckeditor/ckeditor.js') }}"></script>
<!--This page Ckeditor4 -->
</head>
<body>
    @include('backend.layouts.partials.preloader')
    <div id="main-wrapper">
        @include('backend.layouts.partials.header')        
        @include('backend.layouts.partials.sidebar')        
        <div class="page-wrapper"> 
            @yield('admin-content')
            @include('backend.layouts.partials.footer')           
        </div>       
    </div> 
    @include('backend.layouts.partials.theme-options')
    {{--<div class="chat-windows"></div>--}}
    @include('backend.layouts.partials.scripts')
    @yield('scripts')
</body>
</html>