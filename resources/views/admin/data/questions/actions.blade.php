
<div class='btn-group btn-group-sm'>
    {{--@can('admin.categories.show')--}}
    <a data-toggle="tooltip" data-placement="bottom"
       title="مشاهده ی جزییات"
       href="{{ route('admin.questions.show',['question'=>$question]) }}"
       class='btn text-dark'>
        <i class="fa fa-eye"></i>
    </a>
    {{--@endcan--}}




    {{--@can('admin.questions.edit')--}}
    @if(!$question->trashed())
        <a data-toggle="tooltip" data-placement="bottom"
           title="ویرایش"
           href="{{ route('admin.questions.edit',['question'=>$question]) }}"
           class='btn text-info'>
            <i class="fa fa-edit"></i>
        </a>
    @endif
    {{--@endcan--}}

    @if($question->trashed())
        <span  data-toggle="tooltip" data-placement="bottom"
               title='بازیابی پرسش'
               onclick="restore_row('{{ route('admin.questions.destroy',['question'=>$question]) }}','{{ Session::token() }}','آیا از بازیابی این پرسش مطمئن هستین ؟ ')" class="text-success pt-1 btn">
            <i class="fa fa-redo"></i>
        </span>
    @endif

    @if(!$question->trashed())
        <span data-toggle="tooltip" data-placement="bottom"  title='حذف پرسش'
              onclick="del_row('{{ route('admin.questions.destroy',['question'=>$question]) }}','{{ Session::token() }}','آیا از حذف این پرسش مطمئن هستین ؟ ')" class="text-danger pt-1">
             <i class="fa fa-trash"></i>
        </span>
    @else
        <span data-toggle="tooltip"
              data-placement="bottom"
              title='حذف  پرسش برای همیشه'
              onclick="del_row('{{ route('admin.questions.destroy',['question'=>$question]) }}','{{ Session::token() }}','آیا از حذف این پرسش مطمئن هستین ؟ ')"
              class="text-danger pt-1 btn">
            <i class="fa fa-trash"></i>
        </span>
    @endif

    {{--@can('admin.questions.destroy')--}}
    {{--<form action="{{route('admin.questions.destroy',['question'=>$question])}}" method="post">--}}
    {{--@csrf--}}
    {{--@method('DELETE')--}}
    {{--<button type="submit" class="btn btn-link text-danger pt-1" onclick="return confirm('آیا مطمعن هستید')">--}}
    {{--<i class="fa fa-trash"></i>--}}
    {{--</button>--}}
    {{--</form>--}}
    {{--@endcan--}}

</div>