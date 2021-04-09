<div class='btn-group btn-group-sm'>
    {{--@can('admin.skills.show')--}}
    <a data-toggle="tooltip" data-placement="bottom"
       title="مشاهده ی جزییات"
       href="{{ route('admin.skills.show',['skill'=>$skill]) }}"
       class='btn text-dark'>
        <i class="fa fa-eye"></i>
    </a>
    {{--@endcan--}}




    {{--@can('admin.skills.edit')--}}
    @if(!$skill->trashed())
        <a data-toggle="tooltip" data-placement="bottom"
           title="ویرایش"
           href="{{ route('admin.skills.edit',['skill'=>$skill]) }}"
           class='btn text-info'>
            <i class="fa fa-edit"></i>
        </a>
    @endif
    {{--@endcan--}}

    @if($skill->trashed())
        <span  data-toggle="tooltip" data-placement="bottom"
               title='بازیابی مهارت شغلی'
               onclick="restore_row('{{ route('admin.skills.destroy',['skill'=>$skill]) }}','{{ Session::token() }}','آیا از بازیابی این مهارت شغلی مطمئن هستین ؟ ')" class="text-success pt-1 btn">
            <i class="fa fa-redo"></i>
        </span>
    @endif

    @if(!$skill->trashed())
        <span data-toggle="tooltip" data-placement="bottom"  title='حذف مهارت شغلی'
              onclick="del_row('{{ route('admin.skills.destroy',['skill'=>$skill]) }}','{{ Session::token() }}','آیا از حذف این مهارت شغلی مطمئن هستین ؟ ')" class="text-danger pt-1">
             <i class="fa fa-trash"></i>
        </span>
    @else
        <span data-toggle="tooltip"
              data-placement="bottom"
              title='حذف  مهارت شغلی برای همیشه'
              onclick="del_row('{{ route('admin.skills.destroy',['skill'=>$skill]) }}','{{ Session::token() }}','آیا از حذف این مهارت شغلی مطمئن هستین ؟ ')"
              class="text-danger pt-1 btn">
            <i class="fa fa-trash"></i>
        </span>
    @endif

    {{--@can('admin.skills.destroy')--}}
    {{--<form action="{{route('admin.skills.destroy',['skill'=>$skill])}}" method="post">--}}
        {{--@csrf--}}
        {{--@method('DELETE')--}}
        {{--<button type="submit" class="btn btn-link text-danger pt-1" onclick="return confirm('آیا مطمعن هستید')">--}}
            {{--<i class="fa fa-trash"></i>--}}
        {{--</button>--}}
    {{--</form>--}}
    {{--@endcan--}}

</div>