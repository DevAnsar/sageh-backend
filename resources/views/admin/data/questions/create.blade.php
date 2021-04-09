@extends('admin.master')
@section('content')
    <div class="page-content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18">
                        ایجاد مهارت شغلی جدید
                    </h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">

                @include('admin.layouts.errors')
                <div class="card">
                    {{--@include('admin.data.questions.navbar')--}}
                    <div class="card-body">
                        <form action="{{route('admin.questions.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="row">
                            @include('admin.data.questions.fields')
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
        <!-- end row -->


        <!-- parsley plugin -->
        {{--<script src="{{asset('assets/libs/parsleyjs/parsley.min.js')}}"></script>--}}

        <!-- validation init -->
        {{--<script src="{{asset('assets/js/pages/form-validation.init.js')}}"></script>--}}
    </div>
@endsection
@section('js')
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('.question_skills').select2({
                placeholder: 'مهارت های انتخابی برای پرسش'
            });
        });
    </script>
@endsection
@section('css')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
@endsection