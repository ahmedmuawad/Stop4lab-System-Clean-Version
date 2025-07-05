@if(isset($group['receipt_pdf']))
    <a href="{{$group['receipt_pdf']}}" class="btn btn-danger btn-sm">
        <i class="fa fa-print"></i>
    </a>
@endif

@if(isset($group['report_pdf'])&&$group['done'])
    @if($group['due'] == 0)
    <a href="{{$group['report_pdf']}}" class="btn btn-primary btn-sm">
        <i class="fa fa-flask"></i>
    </a>
    @else
    <a href="" class="btn btn-primary btn-sm found_due">
        <i class="fa fa-flask"></i>
    </a>
    @endif
@endif
