<div class="trightcbc">
    <table>
        @if ($test->fig_1 != null)
            @php
                $fileName = 'uploads/figures/fig_1_' . $test->id . '.png';
                file_put_contents($fileName, base64_decode($test->fig_1));
            @endphp
            <tr>
                <td>
                    <img src="{{ url("uploads/figures/fig_1_$test->id.png") }}"
                        style="height: 90px; width: 200px; ">
                </td>
            </tr>
        @endif
        @if ($test->fig_2 != null)
            @php
                $fileName = 'uploads/figures/fig_2_' . $test->id . '.png';
                file_put_contents($fileName, base64_decode($test->fig_2));
            @endphp
            <tr>
                <td>
                    <img src="{{ url("uploads/figures/fig_2_$test->id.png") }}"
                        style="height: 90px; width: 200px; ">
                </td>
            </tr>
        @endif
        @if ($test->fig_3 != null)
            @php
                $fileName = 'uploads/figures/fig_3_' . $test->id . '.png';
                file_put_contents($fileName, base64_decode($test->fig_3));
            @endphp
            <tr>
                <td>
                    <img src="{{ url("uploads/figures/fig_3_$test->id.png") }}"
                        style="height: 90px; width: 200px; ">
                </td>
            </tr>
        @endif
        @if ($test->fig_4 != null)
            @php
                $fileName = 'uploads/figures/fig_4_' . $test->id . '.png';
                file_put_contents($fileName, base64_decode($test->fig_4));
            @endphp
            <tr>
                <td>
                    <img src="{{ url("uploads/figures/fig_4_$test->id.png") }}"
                        style="height: 90px; width: 200px; ">
                </td>
            </tr>
        @endif

    </table>
</div>