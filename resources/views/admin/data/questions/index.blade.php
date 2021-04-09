@extends('admin.master')
@section('content')


    <div class="page-content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18">لیست پرسش و پاسخ ها</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">

                <div class="card">

                    @include('admin.layouts.navbar',[
                        'count'=>$trash_question_count,
                        'route'=>'admin/questions',
                        'title'=>'سوال'])

                    <div class="card-body">
                        <div class="">

                            {{--<form method="get" class="search_form">--}}
                            {{--@if(isset($_GET['trashed']) && $_GET['trashed']==true)--}}
                            {{--<input type="hidden" name="trashed" value="true">--}}
                            {{--@endif--}}
                            {{--<input type="text" name="search" class="form-control" value="{{ $request->get('search','') }}" placeholder="">--}}
                            {{--<button class="btn btn-primary" style="margin-right:80px">جست و جو</button>--}}
                            {{--</form>--}}


                            <form method="get" id="data_form">
                                {{--@csrf--}}
                                <div class="form-group row ">
                                    <div class="col-6">
                                        <input name="string" type="text"
                                               value="{{isset($_GET['string'])?$_GET['string']:''}}"
                                               class="form-control "
                                               placeholder="  جستجو کنید ...">

                                    </div>
                                    <div class="col-3">
                                        <select name="category_id" class="form-control ">
                                            <option value="0"
                                                    @if( !isset($_GET['category_id']) || $_GET['category_id']==0)selected @endif>
                                                همه ی دسته ها
                                            </option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}"
                                                        @if(isset($_GET['category_id']) && $_GET['category_id']==$category->id)selected @endif>
                                                    {{$category->title}}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-warning">
                                            جستجو
                                        </button>

                                    </div>
                                </div>
                            </form>
                            <table class="table table-hover mb-0">

                                <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>#</th>
                                    <th style="width: 320px">متن پرسش</th>
                                    <th class="text-center">پاسخ ها</th>
                                    <th class="text-center">تعداد لایک</th>
                                    <th class="text-center">بهترین پاسخ</th>
                                    <th class="text-center">تاریخ ثبت</th>
                                    <th class="text-center">تنظیمات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($questions as $key=>$question)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="questions_id[]" class="check_box"
                                                   value="{{ $question->id }}"/>
                                        </td>
                                        <th>{{$key+1}}</th>
                                        <th>
                                            <div>
                                                {!! \Illuminate\Support\Str::limit($question->content,200) !!}
                                                {{--<hr class="my-1"/>--}}
                                                {{--@foreach($question->skills as $skill)--}}
                                                {{--<a href="{{route('admin.skills.show',['skill'=>$skill])}}"--}}
                                                {{--style="font-size: 0.6rem"--}}
                                                {{--class="badge badge-pill badge-soft-danger py-1 px-2 m-1">--}}
                                                {{--{{$skill->title}}--}}
                                                {{--</a>--}}
                                                {{--@endforeach--}}

                                                <hr class="my-1"/>

                                                @if($question->category)
                                                    <a href="{{route('admin.questions.index',['category_id'=>$question->category_id])}}"
                                                       style="font-size: 0.6rem"
                                                       class="badge badge-pill badge-soft-success py-1 px-2 m-1">
                                                        {{$question->category->title}}
                                                    </a>
                                                @else

                                                    <a href="#"
                                                       style="font-size: 0.6rem"
                                                       class="badge badge-pill badge-soft-danger py-1 px-2 m-1">
                                                        بدون دسته
                                                    </a>
                                                @endif

                                            </div>
                                        </th>
                                        <th class="text-center">
                                            <a href="{{route('admin.answers.index',['question'=>$question])}}"
                                               class="text-white badge badge-pill badge-soft-dark px-2 py-1">
                                                    <span class="align-text-top ml-1 mr-2">
                                                    {{number_format($question->answerCount)}}
                                                    </span>
                                                <i class="mdi mdi-18px mdi-animation-outline"></i>
                                            </a>
                                        </th>
                                        <th class="text-center">
                                                <span class="text-white badge badge-pill badge-light px-2 py-1">

                                                    <span class="align-text-top ml-1 mr-2">
                                                    {{number_format($question->likeCount)}}
                                                    </span>
                                                    <i class="mdi mdi-18px mdi-heart text-danger"></i>
                                                </span>
                                        </th>

                                        <th class="text-center">
                                            @if($question->best_answer_id==0)
                                                <i class="mdi mdi-24px mdi-checkbox-blank-outline text-danger"></i>
                                            @else
                                                <i class="mdi mdi-24px mdi-checkbox-marked text-success"></i>
                                            @endif
                                        </th>
                                        <td class="text-center" style="direction: ltr">
                                            <?php
                                            $t = \Hekmatinasser\Verta\Verta::instance($question->created_at);
                                            ?>
                                            {{$t->format("Y/m/d  H:i")}}
                                            <br/>
                                            <span class="badge badge-pill badge-soft-dark px-2 py-1 "
                                                  style="font-size: 0.52rem;">
                                                    {{$t->formatDifference()}}
                                                </span>
                                        </td>
                                        <th class="text-center">
                                            @include('admin.data.questions.actions',['question'=>$question])
                                        </th>
                                    </tr>
                                @endforeach

                                @if(sizeof($questions)==0)
                                    <tr>
                                        <td colspan="8" class="text-center">
                                                <span class="badge badge-pill badge-light p-3">
                                                رکوردی برای نمایش وجود ندارد
                                                    </span>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="card-footer">
                        @include('admin.layouts.paginate',['paginator'=>$questions])
                    </div>
                </div>

            </div>

        </div>
        <!-- end row -->

        {{--<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>--}}
        {{--<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>--}}

    </div>
@endsection