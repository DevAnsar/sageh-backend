<div class='btn-group btn-group-sm'>
    {{--@can('admin.products.show')--}}
    <a data-toggle="tooltip" data-placement="bottom"
       title="مشاهده ی جزییات"
       href="{{ route('admin.products.show',['product'=>$product]) }}"
       class='btn text-dark'>
        <i class="fa fa-eye"></i>
    </a>
    {{--@endcan--}}




    {{--@can('admin.products.edit')--}}
    @if(!$product->trashed())
        <a data-toggle="tooltip" data-placement="bottom"
           title="ویرایش"
           href="{{ route('admin.products.edit',['product'=>$product]) }}"
           class='btn text-info'>
            <i class="fa fa-edit"></i>
        </a>
    @endif
    {{--@endcan--}}

    @if($product->trashed())
        <span  data-toggle="tooltip" data-placement="bottom"
               title='بازیابی محصول'
               onclick="restore_row('{{ route('admin.products.destroy',['product'=>$product]) }}','{{ Session::token() }}','آیا از بازیابی این محصول مطمئن هستین ؟ ')" class="text-success pt-1 btn">
            <i class="fa fa-redo"></i>
        </span>
    @endif

    @if(!$product->trashed())
        <span data-toggle="tooltip" data-placement="bottom"  title='حذف محصول'
              onclick="del_row('{{ route('admin.products.destroy',['product'=>$product]) }}','{{ Session::token() }}','آیا از حذف این محصول مطمئن هستین ؟ ')" class="text-danger pt-1">
             <i class="fa fa-trash"></i>
        </span>
    @else
        <span data-toggle="tooltip"
              data-placement="bottom"
              title='حذف  محصول برای همیشه'
              onclick="del_row('{{ route('admin.products.destroy',['product'=>$product]) }}','{{ Session::token() }}','آیا از حذف این محصول مطمئن هستین ؟ ')"
              class="text-danger pt-1 btn">
            <i class="fa fa-trash"></i>
        </span>
    @endif

    {{--@can('admin.products.destroy')--}}
    {{--<form action="{{route('admin.products.destroy',['product'=>$product])}}" method="post">--}}
        {{--@csrf--}}
        {{--@method('DELETE')--}}
        {{--<button type="submit" class="btn btn-link text-danger pt-1" onclick="return confirm('آیا مطمعن هستید')">--}}
            {{--<i class="fa fa-trash"></i>--}}
        {{--</button>--}}
    {{--</form>--}}
    {{--@endcan--}}

</div>