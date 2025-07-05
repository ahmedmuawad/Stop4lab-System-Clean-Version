<ul class="p-1">
    @if(isset($package['tests']))
    @foreach($package['tests'] as $test)
    <li>
        {{isset($test['test']) ? $test['test']['name'] : ''}}
    </li>
    @endforeach
    @endif

    @if(isset($package['cultures']))
    @foreach($package['cultures'] as $culture)
    <li>
        {{isset($culture['culture']) ? $culture['culture']['name'] : ''}}
    </li>
    @endforeach
    @endif
</ul>