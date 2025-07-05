<td>
    <ul class="pl-2 m-0">
      @foreach($group['tests'] as $test)
        <li>{{formated_price($test->price)}}</li>
      @endforeach
      @foreach($group['rays'] as $ray)
        <li>{{formated_price($ray->price)}}</li>
      @endforeach
      @foreach($group['cultures'] as $culture)
        <li>{{formated_price($culture->price)}}</li>
      @endforeach
    </ul>
    @foreach($group['packages'] as $package)
    @if (isset($package['package']))
      <b class="p-0 m-0">
        {{ formated_price($package['package']['price']) }}
      </b>
      
    @endif
    @endforeach
</td>