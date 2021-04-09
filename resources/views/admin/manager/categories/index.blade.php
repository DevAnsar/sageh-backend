@extends('admin.master')
@section('content')


    <div class="page-content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18">لیست دسته بندی ها</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">

                <div class="card">

                    <div class="panel_content">
                        @include('admin.layouts.navbar',[
                        'count'=>$trash_category_count,
                        'route'=>'admin/categories',
                        'title'=>'دسته بندی'])

                        <div class="card-body">


                            {{--<form method="get" class="search_form">--}}
                            {{--@if(isset($_GET['trashed']) && $_GET['trashed']==true)--}}
                            {{--<input type="hidden" name="trashed" value="true">--}}
                            {{--@endif--}}
                            {{--<input type="text" name="search" class="form-control" value="{{ $request->get('search','') }}" placeholder="">--}}
                            {{--<button class="btn btn-primary" style="margin-right:80px">جست و جو</button>--}}
                            {{--</form>--}}


                            <form method="post" id="data_form">
                                @csrf
                                <table class="table table-hover mb-0">

                                    <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>#</th>
                                        <th>آیکون</th>
                                        <th>عنوان</th>
                                        <th>اسلاگ</th>
                                        {{--<th>مهارت های شغلی مرتبط</th>--}}
                                        <th>تنظیمات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($categories as $key=>$category)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="categories_id[]" class="check_box"
                                                       value="{{ $category->id }}"/>
                                            </td>
                                            <th>{{$key+1}}</th>
                                            <th>
                                                @include('admin.layouts.img',['url'=>$category->icon['url']])
                                            </th>
                                            <th>{{$category->title}}</th>
                                            <th>{{$category->slug}}</th>
                                            {{--<th>--}}
                                                {{--<button class="btn btn-sm ">--}}
                                                    {{--<one-to-many--}}
                                                            {{--title=" مهارت های شغلی دسته {{$category->title}}  "--}}
                                                            {{--:one="{{json_encode($category)}}"--}}
                                                            {{--:one_many="{{json_encode($category->skills)}}"--}}
                                                            {{--:many="{{json_encode($allSkills)}}"--}}
                                                            {{--:submit_url="{{json_encode(route('admin.categories.skills.sync',['category_id'=>$category->id]))}}"--}}
                                                            {{--submit_title="ذخیره مهارت ها"--}}
                                                    {{--></one-to-many>--}}
                                                {{--</button>--}}
                                            {{--</th>--}}
                                            <th>
                                                @include('admin.manager.categories.actions',['category'=>$category])
                                            </th>
                                        </tr>
                                    @endforeach

                                    @if(sizeof($categories)==0)
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <span class="badge badge-pill badge-light p-3">
                                                رکوردی برای نمایش وجود ندارد
                                                    </span>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </form>

                        </div>
                        <div class="card-footer">
                            @include('admin.layouts.paginate',['paginator'=>$categories])
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- end row -->

        {{--<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>--}}
        {{--<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>--}}

    </div>
@endsection