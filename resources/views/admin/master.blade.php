<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>Biilche</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('admin/assets/images/favicon.ico')}}">

    <!-- jquery.vectormap css -->
    {{--<link href="{{asset('admin/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}"--}}
          {{--rel="stylesheet"--}}
          {{--type="text/css"/>--}}


    <!-- Icons Css -->
    <link href="{{asset('admin/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('fontiran/fontiran.css')}}" rel="stylesheet" type="text/css"/>

    {{--//light--}}
{{--    <link href="{{asset('admin/assets/css/bootstrap.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css"/>--}}
{{--    <link href="{{asset('admin/assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css"/>--}}

    {{--//dark--}}
    <link href="{{asset('admin/assets/css/bootstrap-dark.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin/assets/css/app-dark.min.css')}}" id="app-style" rel="stylesheet" type="text/css"/>

    <link href="{{asset('admin/admin_them.css')}}" id="app-style" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/admin.css')}}" rel="stylesheet" type="text/css"/>


    @yield('css')


</head>

<body data-layout="detached" data-topbar="colored" >


<div >
    <div class="container-fluid" id="app">
        <!-- Begin page -->
        <div id="layout-wrapper" >


        @include('admin.layouts.header')
        @include('admin.layouts.menu')
        <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

            @yield('content')
            <!-- End Page-content -->

                {{--@include('admin.layouts.footer')--}}
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->


    </div>
    <!-- end container-fluid -->
    @include('admin.layouts.sub_menu')

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <div class="message_div">
        <div class="message_box">
            <p id="msg"></p>
            <a class="alert alert-success" onclick="delete_row()">بله</a>
            <a class="alert alert-danger" onclick="hide_box()">خیر</a>
        </div>
    </div>

    {{--<div id="loading_box">--}}
        {{--<div class="loading_div">--}}
            {{--<div class="loading"></div>--}}
            {{--<span>در حال ارسال اطلاعات</span>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="server_error_box" id="server_error_box">--}}
        {{--<div>--}}
            {{--<span class="fa fa-warning"></span>--}}
            {{--<span id="message">خطا در ارسال درخواست - مجددا تلاش نمایید</span>--}}
        {{--</div>--}}
    {{--</div>--}}
</div>
<script src="{{asset('js/adminVue.js')}}"></script>



<!-- JAVASCRIPT -->
<script src="{{asset('admin/assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/node-waves/waves.min.js')}}"></script>

<script src="{{asset('admin/assets/js/app.js')}}"></script>


@yield('js')
<script src="{{asset('js/admin.js')}}"></script>

{{--<script src="{{asset('js/socket.io.min.js')}}" ></script>--}}
{{--<script src="{{asset('js/client.js')}}"></script>--}}
</body>

</html>