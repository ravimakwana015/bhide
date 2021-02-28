<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name', 'Aptly Managed') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="{{ asset('public/front/') }}/images/favicon.png" rel="icon" type="image/png">
    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
    integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <!-- CSS -->
    <link href="{{ asset('public/front') }}/css/main.css?v=3.0.0" rel="stylesheet">
    <link href="{{ asset('public/front') }}/css-thirdparty/bootstrap.min.css?v=1.0.0" rel="stylesheet">
    <link href="{{ asset('public/front') }}/css-thirdparty/owl.carousel.css?v=1.0.0" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('public/front') }}/css/datepicker/datepicker.css">
    <link rel="stylesheet" href="{{ asset('public/front') }}/css/datepicker/main.css">
    <link rel="stylesheet" href="{{ asset('public/front') }}/css/wickedpicker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css?v=2.6.2">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">


    <link href="{{ asset('public/front') }}/css/main.css?v=4.5.0" rel="stylesheet">
    <link href="{{ asset('public/front') }}/css/custom.css?v=4.5.0" rel="stylesheet">
    @stack('css')
    <style type="text/css">
    .invalid-div {
        color: #ff0000;
    }
</style>
</head>

@auth
<body id="example" class="login-header @if($settings->dashboard_view == 2) newdashboard @endif ">
    @endauth
    @guest
    <body class="">
    @endguest
    <style>
    #loading {
        color: #666666;
        position: fixed;
        height: 100%;
        width: 100%;
        z-index: 5000;
        top: 0;
        left: 0;
        float: left;
        text-align: center;
        padding-top: 25%;
    }
</style>
<div id="loading" style="display: none">

    <img src="{{ URL::asset('public/front/images/loader.gif') }}" style=" z-index: +1;"/>
</div>

@auth
@if($settings->dashboard_view == 1)
@include('include.header')
@include('include.sidebar')
@else
@include('include.header_new')
@include('include.sidebar_new')
@endif
@endauth
@guest
@include('include.header')
@include('include.sidebar')
@endguest

@yield('content')
@include('admin.include.delete_modal')
@include('include.modals')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="{{ asset('public/front') }}/js/thirdparty/jquery-3.2.1.min.js"></script>
<script type="text/javascript"
src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script type="text/javascript"
src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
<script type="text/javascript" src="{{ asset('public/front') }}/js/thirdparty/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ asset('public/front') }}/js/thirdparty/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
crossorigin="anonymous"></script>
<script src="{{ asset('public/front') }}/js/datepicker.js"></script>
<script src="{{ asset('public/front') }}/js/main.js"></script>
<script src="{{ asset('public/front') }}/js/add_remove.js?v=1.0.0"></script>
<!-- App JS -->
<script type="text/javascript" src="{{ asset('public/front') }}/js/timepicki.js"></script>
<script type="text/javascript" src="{{ asset('public/front') }}/js/wickedpicker.js"></script>
<script type="text/javascript" src="{{ asset('public/front') }}/js/app.min.js?v=4.0.0"></script>
<script type="text/javascript" src="{{ asset('public/front') }}/js/custom.js?v=4.0.0"></script>
@stack('js')
<script>
    $('.select2').select2();
    function deletePopup(id){
        var url = $('#delete_'+id).data('url');
        $('#delete_form').attr('action',url);
        $('#deleteModalCenter').modal('show');
    }
</script>
<script type="text/javascript">
    $('#loginpopup').click(function(){
        $('#exampleModalCenter').modal('show');
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#login-btn').click(function(event) {

            var locurrentURL = $(location).attr("href").split('/').pop();
            console.log(locurrentURL);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('login.user') }}',
                type: 'POST',
                dataType: 'json',
                data: $('#login-form').serialize(),
            })
            .done(function(res) {
                console.log(res);
                if(res.status==false){
                    $('.form-errors').html('');
                    $( '.form-errors' ).html('<div class="alert alert-danger">'+res.msg+'</div>');
                    setTimeout(function(){
                        $('.form-errors').html('');
                    }, 3000);
                }else{
                    $( '.form-errors' ).html('');
                    $('.form-errors').html('<div class="alert alert-success">'+res.msg+'</div>');
                    setTimeout(function(){
                        window.location.href="{{ route('home') }}";
                    }, 700);
                }
            });
        });

    });
</script>
<script>
   $('#login-form').keypress(function (e) {
      if(e.keyCode=='13')
      {
         $('#login-btn').click();
     }
 });
</script>
@include('include.footer')
</body>

</html>
