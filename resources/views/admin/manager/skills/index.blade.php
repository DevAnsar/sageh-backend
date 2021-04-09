@extends('admin.master')
@section('content')


    <div class="page-content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18">لیست مهارت های شغلی</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">

                <div class="card">

                    <div class="panel_content">
                        @include('admin.layouts.navbar',[
                        'count'=>$trash_skill_count,
                        'route'=>'admin/skills',
                        'title'=>'مهارت شغلی'])

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
                                        <th>تنظیمات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($skills as $key=>$skill)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="skills_id[]" class="check_box"
                                                       value="{{ $skill->id }}"/>
                                            </td>

                                            <th>{{$key+1}}</th>
                                            <td>
                                                @include('admin.layouts.img',['url'=>$skill->icon['url']])
                                            </td>
                                            <th>{{$skill->title}}</th>
                                            <th>{{$skill->slug}}</th>


                                            <th>
                                                @include('admin.manager.skills.actions',['skill'=>$skill])
                                            </th>
                                        </tr>
                                    @endforeach

                                    @if(sizeof($skills)==0)
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
                            </form>

                        </div>
                        <div class="card-footer">
                            @include('admin.layouts.paginate',['paginator'=>$skills])
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection