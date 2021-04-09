@extends('admin.master')
@section('content')


    <div class="page-content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18">چت ها</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">

                <div class="card">

                    <div class="card-body">
                        <div class="">

                            <form>

                                <input id="message" type="text" placeholder="message">
                                {{--<input type="file" id="imagefile" name="files" style="width:80px">--}}
                                {{--<input type="hidden" id="imgPreview">--}}
                                {{--<input type="hidden" id="imgName">--}}
                                {{--<input type="hidden" id="imgBuffer">--}}
                                <input id="send" type="button" value="ارسال">
                            </form>

                        </div>
                    </div>

                </div>

            </div>

        </div>
        <!-- end row -->


    </div>
@endsection
@section('js')

{{--    <script src="{{asset('js/socket.io.min.js')}}"  crossorigin="anonymous"></script>--}}
    {{--<script src="{{asset('js/client.js')}}"></script>--}}
@endsection