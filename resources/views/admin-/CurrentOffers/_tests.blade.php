<ul class="p-1">
    @if (isset($offer['tests']))
        @foreach ($offer['tests'] as $offer)
            <li>
                {{ isset($offer['test']) ? $offer['test']['name'] : '' }}
            </li>
        @endforeach
    @endif

    @if (isset($offer['culturies']))
        @foreach ($offer['culturies'] as $culture)
            <li>
                {{ isset($culture['culture']) ? $culture['culture']['name'] : '' }}
            </li>
        @endforeach
    @endif
    @if (isset($offer['rays']))
        @foreach ($offer['rays'] as $ray)
            <li>
                {{ isset($ray['ray']) ? $ray['ray']['name'] : '' }}
            </li>
        @endforeach
    @endif

    @if (isset($offer['packages']))
    @foreach ($offer['packages'] as $package)
        <li>
            {{ isset($package['package']) ? $package['package']['name'] : '' }}
        </li>
    @endforeach
@endif
</ul>
