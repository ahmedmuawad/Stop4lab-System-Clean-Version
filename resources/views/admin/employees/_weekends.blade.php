<ul class="p-1">
    @foreach($user['weekends'] as $weekend)
        <li>
            @if(isset($weekend['weekend']))
                {{$weekend['weekend']}}
            @endif
        </li>
    @endforeach
</ul>