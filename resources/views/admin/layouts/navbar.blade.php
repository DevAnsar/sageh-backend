<div class="card-header">
    <?php
    $create_param='';
    $trash_param='';
    if(isset($queryString) && is_array($queryString))
    {
        $create_param='?'.$queryString['param'].'='.$queryString['value'];
        $trash_param='&'.$queryString['param'].'='.$queryString['value'];
    }
    ?>

    <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
        <li class="nav-item ">
            <a class="nav-link {{url()->current() == url($route).$create_param ?'active':''}}"
               href="{!! url($route).$create_param !!}"><i
                        class="fa fa-list mr-2"></i>

                لیست {{ $title }}
            </a>
        </li>



        <li class="nav-item ">
            <div class="btn-group">
                <a class="nav-link dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    عملیات
                    <i class="mdi mdi-chevron-down"></i>
                </a>
                <div class="dropdown-menu"
                     style="position: absolute; will-change: transform; top: 20px; left: 0px; transform: translate3d(0px, 31px, 0px);"
                     x-placement="top-start">

                    @if(!isset($remove_new_record))
                        <a class="dropdown-item" href="{{ url($route.'/create').$create_param }}">

                            <span>افزودن {{ $title }} جدید</span>
                            <span class="fa fa-plus"></span>
                        </a>
                    @endif

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ url($route.'?trashed=true').$trash_param }}">

                            <span>سطل زباله ({{ replace_number($count) }})</span>
                            <span class="fa fa-trash"></span>
                        </a>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item off item_form" id="destroy_items" msg="آیا از حذف {{ $title }} های انتخابی مطمئن هستید ؟‌">

                            <span>حذف {{ $title }} ها</span>
                            <span class="fa fa-trash"></span>
                        </a>

                        @if(isset($_GET['trashed']) && $_GET['trashed']=='true')
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item off item_form" id="restore_items" msg="آیا از بازیابی {{ $title }} های انتخابی مطمئن هستید ؟‌">
                                <span>بازیابی {{ $title }} ها</span>
                                <span class="fa fa-redo"></span>

                            </a>
                        @endif
                </div>
            </div>

        </li>

    </ul>
</div>