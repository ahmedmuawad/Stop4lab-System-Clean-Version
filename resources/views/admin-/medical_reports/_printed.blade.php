@foreach ($group['all_tests'] as $test)
    @if($test['is_printed'])
        <div class="text-center"><i class="fa fa-check-double text-success"></i></div>
    @else
        <div class="text-center"><i class="fa fa-times-circle text-danger"></i></div>
    @endif   
@endforeach




