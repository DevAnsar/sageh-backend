{{--<div class='btn-group btn-group-sm'>--}}
    {{--@can('admin.answers.show')--}}
    {{--<a data-toggle="tooltip" data-placement="bottom"--}}
       {{--title="مشاهده ی جزییات"--}}
       {{--href="{{ route('admin.answers.show',['answer'=>$answer,'question'=>$question]) }}"--}}
       {{--class='btn btn-link'>--}}
        {{--<i class="fa fa-eye"></i>--}}
    {{--</a>--}}
    {{--@endcan--}}

    {{--@can('admin.answers.edit')--}}
    {{--<a data-toggle="tooltip" data-placement="bottom"--}}
       {{--title="ویرایش"--}}
       {{--href="{{ route('admin.answers.edit',['answer'=>$answer,'question'=>$question]) }}"--}}
       {{--class='btn btn-link'>--}}
        {{--<i class="fa fa-edit"></i>--}}
    {{--</a>--}}
    {{--@endcan--}}

    {{--@can('admin.answers.destroy')--}}
    {{--<form action="{{route('admin.answers.destroy',['answer'=>$answer,'question'=>$question])}}" method="post">--}}
        {{--@csrf--}}
        {{--@method('delete')--}}
        {{--<button type="submit" class="btn btn-link text-danger pt-1" onclick="return confirm('آیا مطمعن هستید')">--}}
            {{--<i class="fa fa-trash"></i>--}}
        {{--</button>--}}
    {{--</form>--}}
    {{--@endcan--}}

{{--</div>--}}


<div class='btn-group btn-group-sm'>
    {{--@can('admin.categories.show')--}}
    <a data-toggle="tooltip" data-placement="bottom"
       title="مشاهده ی جزییات"
       href="{{ route('admin.answers.show',['answer'=>$answer,'question'=>$question]) }}"
       class='btn text-dark'>
        <i class="fa fa-eye"></i>
    </a>
    {{--@endcan--}}




    {{--@can('admin.answers.edit')--}}
    @if(!$answer->trashed())
        <a data-toggle="tooltip" data-placement="bottom"
           title="ویرایش"
           href="{{ route('admin.answers.edit',['answer'=>$answer,'question'=>$question]) }}"
           class='btn text-info'>
            <i class="fa fa-edit"></i>
        </a>
    @endif
    {{--@endcan--}}

    @if($answer->trashed())
        <span  data-toggle="tooltip" data-placement="bottom"
               title='بازیابی پرسش'
               onclick="restore_row('{{ route('admin.answers.destroy',['answer'=>$answer,'question'=>$question]) }}','{{ Session::token() }}','آیا از بازیابی این پرسش مطمئن هستین ؟ ')" class="text-success pt-1 btn">
            <i class="fa fa-redo"></i>
        </span>
    @endif

    @if(!$answer->trashed())
        <span data-toggle="tooltip" data-placement="bottom"  title='حذف پرسش'
              onclick="del_row('{{ route('admin.answers.destroy',['answer'=>$answer,'question'=>$question]) }}','{{ Session::token() }}','آیا از حذف این پرسش مطمئن هستین ؟ ' )" class="text-danger pt-1">
             <i class="fa fa-trash"></i>
        </span>
    @else
        <span data-toggle="tooltip"
              data-placement="bottom"
              title='حذف  پرسش برای همیشه'
              onclick="del_row('{{ route('admin.answers.destroy',['answer'=>$answer,'question'=>$question]) }}','{{ Session::token() }}','آیا از حذف این پرسش مطمئن هستین ؟ ')"
              class="text-danger pt-1 btn">
            <i class="fa fa-trash"></i>
        </span>
    @endif

    {{--@can('admin.answers.destroy')--}}
    {{--<form action="{{route('admin.answers.destroy',['answer'=>$answer])}}" method="post">--}}
    {{--@csrf--}}
    {{--@method('DELETE')--}}
    {{--<button type="submit" class="btn btn-link text-danger pt-1" onclick="return confirm('آیا مطمعن هستید')">--}}
    {{--<i class="fa fa-trash"></i>--}}
    {{--</button>--}}
    {{--</form>--}}
    {{--@endcan--}}

</div>