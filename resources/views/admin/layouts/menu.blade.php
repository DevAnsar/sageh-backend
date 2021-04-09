<div class="vertical-menu">

    <div class="h-100">

        <div class="user-wid text-center py-4">
            <div class="user-img">
                <img src="{{auth()->user()->avatar?getImage(auth()->user()->avatar['url']):asset('admin/assets/images/users/avatar-2.jpg')}}"
                     alt="" class="avatar-md mx-auto rounded-circle">
            </div>

            <div class="mt-3">

                <a href="#" class="text-dark font-weight-medium font-size-16">بیلچه</a>
                <p class="text-body mt-1 mb-0 font-size-13">
                    {{userFullName(auth()->user())}}
                </p>

            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                {{--<li class="menu-title">Menu</li>--}}

                <li>
                    <a href="{{route('admin.dashboard')}}" class=" waves-effect">
                        <i class="mdi mdi-airplay"></i>
                        {{--<span class="badge badge-pill badge-info float-right">2</span>--}}
                        <span>داشبورد</span>
                    </a>
                </li>

                <li class="menu-title">مدیریت اطلاعات</li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect has-arrow">
                        <i class="mdi mdi-comment-text-multiple-outline"></i>

                        <span>پرسش و پاسخ</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.questions.index')}}">لیست پرسش ها</a></li>
                        {{--<li><a href="{{route('admin.questions.awaiting')}}">لیست در انتظار تایید</a></li>--}}
                        {{--<li><a href="{{route('admin.questions.accepted')}}">لیست تایید شده</a></li>--}}
                        {{--<li><a href="{{route('admin.questions.failed')}}">لیست رد شده</a></li>--}}
                    </ul>
                </li>

                <li>
                    <a href="{{route('admin.users.index')}}" class=" waves-effect">
                        <i class="mdi mdi-account"></i>
                        <span>کاربران</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect has-arrow">
                        <i class="mdi mdi-archive"></i>

                        <span>محصولات</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.products.index')}}">لیست محصولات</a></li>
                        <li><a href="{{route('admin.products.create')}}">ایجاد محصول جدید</a></li>
                    </ul>
                </li>


                <li class="menu-title">مدیریت داده ها</li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect has-arrow">
                        <i class="mdi mdi-arm-flex-outline"></i>

                        <span>مهارت های شغلی</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.skills.index')}}">لیست مهارت ها</a></li>
                        <li><a href="{{route('admin.skills.create')}}">ایجاد مهارت جدید</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{route('admin.categories.index')}}" class=" waves-effect">
                        <i class="mdi mdi-animation-outline"></i>
                        <span>دسته بندی</span>
                    </a>
                </li>

                <li class="menu-title"></li>
                <li>
                    <a href="{{route('admin.messages')}}" class="waves-effect">
                        <i class="mdi mdi-chat"></i>
                        <span>چت ها</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>