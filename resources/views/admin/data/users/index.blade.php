@extends('admin.master')
@section('content')


    <div class="page-content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18">لیست کاربران</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">

                <div class="card">

                    <div class="panel_content">
                        @include('admin.layouts.navbar',[
                        'count'=>$trash_user_count,
                        'route'=>'admin/users',
                        'title'=>'کاربر'])

                        <div class="card-body">


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
                                               placeholder="بر اساس نام و نام خانوادگی و ... جستجو کنید">

                                    </div>
                                    <div class="col-6">
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

                                    <th>تصویر</th>
                                    <th>نام</th>
                                    <th>نام خ</th>
                                    <th>موبایل</th>
                                    <th>دسته / صنف</th>
                                    {{--<th>مهارت های شغلی</th>--}}
                                    <th>تنظیمات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $key=>$user)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="users_id[]" class="check_box"
                                                   value="{{ $user->id }}"/>
                                        </td>
                                        <th>{{$key+1}}</th>
                                        <th>
                                            @include('admin.layouts.img',['url'=>$user->avatar['url']])
                                        </th>
                                        <th>{{$user->name}}</th>
                                        <th>{{$user->family}}</th>
                                        <th>{{$user->mobile}}</th>
                                        <th>
                                            <one-to-many
                                                    title=" دسته ی فعالیت کاربر {{$user->name}}  "
                                                    :one="{{json_encode($user)}}"
                                                    :one_many="{{json_encode($user->categories)}}"
                                                    :many="{{json_encode($allCategories)}}"
                                                    :submit_url="{{json_encode(route('admin.users.categories.sync',['user_id'=>$user->id]))}}"
                                                    submit_title="ثبت دسته ها برای کاربر"
                                            ></one-to-many>
                                        </th>
                                        {{--<th>--}}
                                        {{--<button class="btn btn-sm ">--}}
                                        {{--<one-to-many--}}
                                        {{--title=" مهارت های شغلی کاربر {{$user->name}}  "--}}
                                        {{--:one="{{json_encode($user)}}"--}}
                                        {{--:one_many="{{json_encode($user->skills)}}"--}}
                                        {{--:many="{{json_encode($allSkills)}}"--}}
                                        {{--:submit_url="{{json_encode(route('admin.users.skills.sync',['user_id'=>$user->id]))}}"--}}
                                        {{--submit_title="ذخیره مهارت ها"--}}
                                        {{--></one-to-many>--}}
                                        {{--</button>--}}
                                        {{--</th>--}}
                                        <th>
                                            @include('admin.data.users.actions',['user'=>$user])
                                        </th>
                                    </tr>
                                @endforeach

                                @if(sizeof($users)==0)
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


                        </div>
                        <div class="card-footer">
                            @include('admin.layouts.paginate',['paginator'=>$users,'request'=>$request])
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