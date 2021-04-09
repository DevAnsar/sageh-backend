@extends('admin.master')
@section('content')
    <div class="page-content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18">
                        داشبورد
                    </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            {{--<li class="breadcrumb-item active">Welcome to Qovex Dashboard</li>--}}
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm font-size-20 mr-3">
                                <a href="{{route('admin.users.index')}}">
                                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                                    <i class="mdi mdi-account"></i>
                                                </span>
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="font-size-16 mt-2">کاربران</div>
                            </div>
                        </div>
                        <h4 class="mt-4">{{number_format($usersCount)}}</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm font-size-20 mr-3">
                                <a href="{{route('admin.categories.index')}}">
                                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                                    <i class="mdi mdi-animation-outline"></i>
                                                </span>
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="font-size-16 mt-2">دسته ها / اصناف</div>
                            </div>
                        </div>
                        <h4 class="mt-4">{{number_format($categoriesCount)}}</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm font-size-20 mr-3">
                                <a href="{{route('admin.skills.index')}}">
                                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                                    <i class="mdi mdi-arm-flex-outline"></i>
                                                </span>
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="font-size-16 mt-2">مهارت های شغلی</div>
                            </div>
                        </div>
                        <h4 class="mt-4">{{number_format($skillsCount)}}</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm font-size-20 mr-3">
                                <a href="{{route('admin.questions.index')}}">
                                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                                    <i class="mdi mdi-comment-text-multiple-outline"></i>
                                                </span>
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="font-size-16 mt-2">کل سوالات</div>
                            </div>
                        </div>
                        <h4 class="mt-4">{{number_format($questionsCount)}}</h4>
                    </div>
                </div>
            </div>


        </div>
        <!-- end row -->

        <!-- end row -->

        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm font-size-20 mr-3">
                                <a href="{{route('admin.products.index')}}">
                                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                                    <i class="mdi mdi-archive"></i>
                                            </span>
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="font-size-16 mt-2">محصولات و خدمات ثبت شده</div>
                            </div>
                        </div>
                        <h4 class="mt-4">{{number_format($productsCount)}}</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">آخرین کاربران</h4>

                        <div class="table-responsive">
                            <table class="table table-centered">
                                <thead>
                                <tr>
                                    <th scope="col">تاریخ ثبت</th>
                                    <th scope="col">نام کاربری</th>
                                    <th scope="col">نام</th>
                                    <th scope="col">موبایل</th>
                                    <th scope="col" colspan="2">دسته</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($lastUsers as $user)
                                    <tr>
                                        <td>{{\Hekmatinasser\Verta\Verta::instance($user->created_at)->format('Y-m-d')}}</td>
                                        <td>
                                            <a href="#" class="text-body font-weight-medium">{{$user->username}}</a>
                                        </td>
                                        <td>{{$user->name}} {{$user->family}}</td>
                                        <td>{{$user->mobile}}</td>
                                        <td><span class="badge badge-soft-success font-size-12">
                                                {{--{{$user->category->title}}--}}
                                                -
                                            </span>
                                        </td>
                                        <td><a href="{{route('admin.users.show',['user'=>$user])}}"
                                               class="btn btn-primary btn-sm">مشاهده</a></td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <ul class="pagination pagination-rounded justify-content-center mb-0">
                                <li class="page-item">
                                    <a class="page-link" href="{{route('admin.users.index')}}">همه</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div>
@endsection