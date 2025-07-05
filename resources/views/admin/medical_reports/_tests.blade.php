<ul class="pl-3">
    @if($type == 'sample_status')
        @foreach($group['all_tests'] as $test)
            @if($test['sample_status'])
                <li class="@if($test['done']) text-success @endif">{{ isset($test['test']['name']) ? $test['test']['name'] : ''   }}</li>
            @endif
        @endforeach 
    @else
        @foreach($group['all_tests'] as $test)
            <li class="@if($test['done']) text-success @endif">{{isset($test['test']['name']) ? $test['test']['name'] : ''}}</li>
        @endforeach
    @endif
    
    @if($type == 'sample_status')
        @foreach($group['all_cultures'] as $culture)
            @if($culture['sample_status'])
                <li class="@if($culture['done']) text-success @endif">{{$culture['culture']['name']}}</li>
            @endif
        @endforeach
    @else
        @foreach($group['all_cultures'] as $culture)
            <li class="@if($culture['done']) text-success @endif">{{$culture['culture']['name']}}</li>
        @endforeach
    @endif
    
    
    @if (isset($group['rays'] ))
        @foreach($group['rays'] as $ray)
            @if ($ray['ray'])
                <li class="@if($ray['checked']) text-success @endif">{{$ray['ray']['name']}}</li>
            @endif
        @endforeach
    @endif
    </ul>