<div class='btn-group btn-group-sm'>
    {{--@can('admin.users.show')--}}
    <a data-toggle="tooltip" data-placement="bottom"
       title="مشاهده ی جزییات"
       href="{{ route('admin.users.show',['user'=>$user]) }}"
       class='btn text-dark'>
        <i class="fa fa-eye"></i>
    </a>
    {{--@endcan--}}




    {{--@can('admin.users.edit')--}}
    @if(!$user->trashed())
        <a data-toggle="tooltip" data-placement="bottom"
           title="ویرایش"
           href="{{ route('admin.users.edit',['user'=>$user]) }}"
           class='btn text-info'>
            <i class="fa fa-edit"></i>
        </a>
    @endif
    {{--@endcan--}}

    @if($user->trashed())
        <span  data-toggle="tooltip" data-placement="bottom"
               title='بازیابی کاربر'
               onclick="restore_row('{{ route('admin.users.destroy',['user'=>$user]) }}','{{ Session::token() }}','آیا از بازیابی این کاربر مطمئن هستین ؟ ')" class="text-success pt-1 btn">
            <i class="fa fa-redo"></i>
        </span>
    @endif

    @if(!$user->trashed())
        <span data-toggle="tooltip" data-placement="bottom"  title='حذف کاربر'
              onclick="del_row('{{ route('admin.users.destroy',['user'=>$user]) }}','{{ Session::token() }}','آیا از حذف این کاربر مطمئن هستین ؟ ')" class="text-danger pt-1">
             <i class="fa fa-trash"></i>
        </span>
    @else
        <span data-toggle="tooltip"
              data-placement="bottom"
              title='حذف  کاربر برای همیشه'
              onclick="del_row('{{ route('admin.users.destroy',['user'=>$user]) }}','{{ Session::token() }}','آیا از حذف این کاربر مطمئن هستین ؟ ')"
              class="text-danger pt-1 btn">
            <i class="fa fa-trash"></i>
        </span>
    @endif

    {{--@can('admin.users.destroy')--}}
    {{--<form action="{{route('admin.users.destroy',['user'=>$user])}}" method="post">--}}
        {{--@csrf--}}
        {{--@method('DELETE')--}}
        {{--<button type="submit" class="btn btn-link text-danger pt-1" onclick="return confirm('آیا مطمعن هستید')">--}}
            {{--<i class="fa fa-trash"></i>--}}
        {{--</button>--}}
    {{--</form>--}}
    {{--@endcan--}}

</div>