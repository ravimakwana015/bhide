<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Concierge') }} | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/front') }}/css/wickedpicker.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    
    <link rel="stylesheet" href="{{ asset('public/front') }}/css/datepicker/datepicker.css">
    <link rel="stylesheet" href="{{ asset('public/front') }}/css/datepicker/main.css">
    <link rel="stylesheet" href="{{ asset('public/front') }}/css/wickedpicker.css">

    <link rel="stylesheet" href="{{ asset('public/admin/css/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/summernote-bs4.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css?v=2.6.2">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
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
    .error{
        color: red;
    }
</style>
<div id="loading" style="display: none">

    <img src="{{ URL::asset('public/front/images/loader.gif') }}" style=" z-index: +1;"/>
</div>
<div class="wrapper">

    @include('admin.include.navbar')
    @include('admin.include.sidebar')

    @yield('content')

    @include('admin.include.footer')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
@include('admin.include.delete_modal')
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('public/admin/js/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('public/admin/js/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/admin/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('public/admin/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/admin/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/admin/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/admin/js/responsive.bootstrap4.min.js') }}"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap4.min.js"></script>
{{ Html::style('https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css') }}
<!-- jquery-validation -->
<script src="{{ asset('public/admin/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('public/admin/js/additional-methods.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('public/admin/js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('public/admin/js/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
{{-- <script src="{{ asset('public/admin/js/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('public/admin/js/jquery.vmap.usa.js') }}"></script> --}}
<!-- jQuery Knob Chart -->
{{-- <script src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script> --}}
<script src="https://cdn.tiny.cloud/1/icxyna8gg10p40cpe1re3ahtwu0d5eacmu22mlbgl2r5f2xg/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


<script src="{{ asset('public/admin/js/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('public/admin/js/moment.min.js') }}"></script>
<script src="{{ asset('public/admin/js/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/front') }}/js/wickedpicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('public/admin/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('public/admin/js/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('public/admin/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/admin/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('public/front') }}/js/datepicker.js"></script>
<script src="{{ asset('public/admin/js/dashboard.js') }}"></script>
<script src="{{ asset('public/front/js/add_remove.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script type="text/javascript" src="{{ asset('public/front') }}/js/custom.js?v=4.0.0"></script>
<script type="text/javascript" src="{{ asset('public/admin') }}/js/custom.js?v=4.0.0"></script>
<script src="{{ asset('public/admin/js/demo.js') }}"></script>


@yield('after-scripts')
<script>
    function deletePopup(id){
        var url = $('#delete_'+id).data('url');
        $('#delete_form').attr('action',url);
        $('#deleteModalCenter').modal('show');
    }
</script>
</body>

</html>
