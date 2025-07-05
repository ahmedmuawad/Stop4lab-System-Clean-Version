@php

    $test_settings =   $test['setting'] == null ? setting('reports') : json_decode($test['setting'], true);
@endphp
@if (isset($test))
    <x-setting-component :test="$test" :settings="$test_settings" />
@endif

