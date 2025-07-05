<div>
    <div class="" width="80%">
        <h1 style="font-size: 22px;font-weight: bold;  text-decoration: underline;margin-top: -20px;margin-bottom: 0px">
            Collection:
        </h1>
        <table class="withoutBorder" width="100%">
            @foreach ($test['results'] as $result)
                {{-- <div style="clear: both"></div> --}}

                {{-- @foreach ($test['results'] as $result) --}}
                <tr class="withoutBorder">
                    @if ($result['component']['name'] == 'Liquefaction time')
                        <td width="40%" class="withoutBorder">
                            {{ $result['component']['name'] }}
                        </td>
                        <td class="withoutBorder">
                            :
                        </td>
                        <td width="20%" class="withoutBorder">
                            {{ $result['result'] }}

                        </td>
                        <td width="40%" class="withoutBorder">
                            {!! str_replace(['<br>', '<p>', '</p>'], '', $result['component']['reference_range']) !!}
                        </td>
                    @endif
                </tr>
                {{-- @endforeach --}}

                {{-- <div style="clear: both"></div> --}}

                {{-- @foreach ($test['results'] as $result) --}}
                <tr class="withoutBorder">

                    @if ($result['component']['name'] == 'Method of collection')
                        <td width="40%" class="withoutBorder">
                            {{ $result['component']['name'] }}
                        </td>
                        <td class="withoutBorder">
                            :
                        </td>
                        <td width="20%" class="withoutBorder">
                            {{ $result['result'] }}

                        </td>
                        <td width="40%" class="withoutBorder">
                            {!! str_replace(['<br>', '<p>', '</p>'], '', $result['component']['reference_range']) !!}
                        </td>
                    @endif
                </tr>
                {{-- @endforeach --}}
                {{-- <div style="clear: both"></div> --}}

                {{-- @foreach ($test['results'] as $result) --}}
                <tr class="withoutBorder">

                    @if ($result['component']['name'] == 'Abstinence period')
                        <td width="40%" class="withoutBorder">
                            {{ $result['component']['name'] }}
                        </td>
                        <td class="withoutBorder">
                            :
                        </td>
                        <td width="20%" class="withoutBorder">
                            {{ $result['result'] }}

                        </td>
                        <td width="40%" class="withoutBorder">
                            {!! str_replace(['<br>', '<p>', '</p>'], '', $result['component']['reference_range']) !!}
                        </td>
                    @endif
                </tr>
                {{-- @endforeach --}}

                {{-- <div style="clear: both"></div> --}}
                {{-- @foreach ($test['results'] as $result) --}}
                <tr class="withoutBorder">

                    @if ($result['component']['name'] == 'Time Of Collection')
                        <td width="40%" class="withoutBorder">
                            {{ $result['component']['name'] }}
                        </td>
                        <td class="withoutBorder">
                            :
                        </td>
                        <td width="20%" class="withoutBorder">
                            {{ $result['result'] }}

                        </td>
                        <td width="40%" class="withoutBorder">
                            {!! str_replace(['<br>', '<p>', '</p>'], '', $result['component']['reference_range']) !!}
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>


        <h1 style="font-size: 22px;font-weight: bold;  text-decoration: underline;margin-top: 0px;margin-bottom: 0px">
            Macroscopic Examination:
        </h1>
        <table class="withoutBorder" width="100%">
            @foreach ($test['results'] as $result)
                <tr class="withoutBorder">
                    @if ($result['component']['name'] == 'Volume')
                        <td width="40%" class="withoutBorder">
                            {{ $result['component']['name'] }}
                        </td>
                        <td class="withoutBorder">
                            :
                        </td>
                        <td width="20%" class="withoutBorder">
                            {{ $result['result'] }}
                            @php
                                $volume = $result['result'];
                            @endphp

                        </td>
                        <td width="40%" class="withoutBorder">
                            {!! str_replace(['<br>', '<p>', '</p>'], '', $result['component']['reference_range']) !!}
                        </td>
                    @endif
                </tr>

                <tr class="withoutBorder">
                    @if ($result['component']['name'] == 'color')
                        <td width="40%" class="withoutBorder">
                            {{ $result['component']['name'] }}
                        </td>
                        <td class="withoutBorder">
                            :
                        </td>
                        <td width="20%" class="withoutBorder">
                            {{ $result['result'] }}

                        </td>
                        <td width="40%" class="withoutBorder">
                            {!! str_replace(['<br>', '<p>', '</p>'], '', $result['component']['reference_range']) !!}
                        </td>
                    @endif
                </tr>

                {{-- <div style="clear: both"></div> --}}

                {{-- @foreach ($test['results'] as $result) --}}
                <tr class="withoutBorder">
                    @if ($result['component']['name'] == 'Consistincy')
                        <td width="40%" class="withoutBorder">
                            {{ $result['component']['name'] }}
                        </td>
                        <td class="withoutBorder">
                            :
                        </td>
                        <td width="20%" class="withoutBorder">
                            {{ $result['result'] }}

                        </td>
                        <td width="40%" class="withoutBorder">
                            {!! str_replace(['<br>', '<p>', '</p>'], '', $result['component']['reference_range']) !!}
                        </td>
                    @endif
                </tr>
                {{-- @endforeach --}}

                {{-- <div style="clear: both"></div> --}}

                {{-- @foreach ($test['results'] as $result) --}}
                <tr class="withoutBorder">

                    @if ($result['component']['name'] == 'Reaction')
                        <td width="40%" class="withoutBorder">
                            {{ $result['component']['name'] }}
                        </td>
                        <td class="withoutBorder">
                            :
                        </td>
                        <td width="20%" class="withoutBorder">
                            {{ $result['result'] }}

                        </td>
                        <td width="40%" class="withoutBorder">
                            {!! str_replace(['<br>', '<p>', '</p>'], '', $result['component']['reference_range']) !!}
                        </td>
                    @endif
                </tr>
                {{-- @endforeach --}}
                {{-- <div style="clear: both"></div> --}}

                {{-- @foreach ($test['results'] as $result) --}}
                <tr class="withoutBorder">

                    @if ($result['component']['name'] == 'Viscosity')
                        <td width="40%" class="withoutBorder">
                            {{ $result['component']['name'] }}
                        </td>
                        <td class="withoutBorder">
                            :
                        </td>
                        <td width="20%" class="withoutBorder">
                            {{ $result['result'] }}

                        </td>
                        <td width="40%" class="withoutBorder">
                            {!! str_replace(['<br>', '<p>', '</p>'], '', $result['component']['reference_range']) !!}
                        </td>
                    @endif
                </tr>
                {{-- @endforeach --}}
            @endforeach
        </table>


        <h2 style="font-size: 22px;font-weight: bold;  text-decoration: underline;margin-top: 0px;margin-bottom: 0px">
            Microscopic Examination:
        </h2>
        <table class="withoutBorder" width="100%">
            @foreach ($test['results'] as $result)
                <tr class="withoutBorder">
                    @if ($result['component']['name'] == 'Concentration')
                        <td class="withoutBorder" style="margin-left: 40px" width="40%">
                            {{ $result['component']['name'] }}
                        </td>
                        <td class="withoutBorder" align="center">
                            :
                        </td>
                        <td class="withoutBorder" style="margin-top:-20px" width="20%">
                            {{ $result['result'] }}
                            @php
                                $totalLeftSide = $result['result'];
                            @endphp
                        </td>

                        <td class="withoutBorder" width="40%">
                            {!! str_replace(['<br>', '<p>', '</p>'], '', $result['component']['reference_range']) !!}
                        </td>
                    @endif
                </tr>
            @endforeach
            {{-- <div style="clear: both"></div> --}}
            @foreach ($test['results'] as $result)
                <tr class="withoutBorder">
                    @if ($result['component']['name'] == 'Total spermatic count')
                        <td class="withoutBorder" style="margin-left: 40px" width="40%">
                            {{ $result['component']['name'] }}
                        </td>
                        <td class="withoutBorder" align="center">
                            :
                        </td>
                        <td class="withoutBorder" style="margin-top:-20px" width="20%">
                            {{ $totalLeftSide * $volume }}

                        </td>

                        <td class="withoutBorder" width="40%">
                            {!! str_replace(['<br>', '<p>', '</p>'], '', $result['component']['reference_range']) !!}
                        </td>
                        <div class="" style="float: right;margin-top:-20px" width="35%">
                            {{ $totalLeftSide * $volume }}
                        </div>
                    @endif
                </tr>
            @endforeach
            {{-- <div style="clear: both"></div> --}}
            @foreach ($test['results'] as $result)
                @if ($result['component']['name'] == 'Pus cells')
                    <tr class="withoutBorder">

                        <td class="withoutBorder" style="margin-left: 40px" width="40%">
                            {{ $result['component']['name'] }}
                        </td>
                        <td class="withoutBorder" align="center">
                            :
                        </td>
                        <td class="withoutBorder" style="margin-top:-20px" width="20%">
                            {{ $result['result'] }}
                            
                        </td>

                        <td class="withoutBorder" width="40%">
                            {!! str_replace(['<br>', '<p>', '</p>'], '', $result['component']['reference_range']) !!}
                        </td>

                    </tr>
                @endif
            @endforeach
            {{-- <div style="clear: both"></div> --}}
            @foreach ($test['results'] as $result)
                <tr class="withoutBorder">
                    @if ($result['component']['name'] == 'Epithelial cells')
                        <td class="withoutBorder" style="margin-left: 40px" width="40%">
                            {{ $result['component']['name'] }}
                        </td>
                        <td class="withoutBorder" align="center">
                            :
                        </td>
                        <td class="withoutBorder" style="margin-top:-20px" width="20%">
                            {{ $result['result'] }}
                          
                        </td>

                        <td class="withoutBorder" width="40%">
                            {!! str_replace(['<br>', '<p>', '</p>'], '', $result['component']['reference_range']) !!}
                        </td>

                        {{-- @endif --}}
                    @endif
                </tr>
            @endforeach
            {{-- <div style="clear: both"></div> --}}
            @foreach ($test['results'] as $result)
                @if ($result['component']['name'] == 'Sperm agglutination')
                    <tr class="withoutBorder">

                        <td class="withoutBorder" style="margin-left: 40px" width="40%">
                            {{ $result['component']['name'] }}
                        </td>
                        <td class="withoutBorder" align="center">
                            :
                        </td>
                        <td class="withoutBorder" style="margin-top:-20px" width="20%">
                            {{ $result['result'] }}
                            
                        </td>

                        <td class="withoutBorder" width="40%">
                            {!! str_replace(['<br>', '<p>', '</p>'], '', $result['component']['reference_range']) !!}
                        </td>

                    </tr>
                @endif
            @endforeach
            {{-- <div style="clear: both"></div> --}}
            @foreach ($test['results'] as $result)
                @if ($result['component']['name'] == 'Spermatogenic cells')
                    <tr class="withoutBorder">

                        <td class="withoutBorder" style="margin-left: 40px" width="40%">
                            {{ $result['component']['name'] }}
                        </td>
                        <td class="withoutBorder" align="center">
                            :
                        </td>
                        <td class="withoutBorder" style="margin-top:-20px" width="20%">
                            {{ $result['result'] }}
                            
                        </td>

                        <td class="withoutBorder" width="40%">
                            {!! str_replace(['<br>', '<p>', '</p>'], '', $result['component']['reference_range']) !!}
                        </td>

                    </tr>
                @endif
            @endforeach
        </table>

    </div>
    <h1 style="font-size: 22px;font-weight: bold;  text-decoration: underline;margin-top: 0px;margin-bottom: 0px">
        Sperm Vitality:
    </h1>
    <h4 style="margin-bottom: 0px;margin-top:-20px">
        Motility:
    </h4>
    <div class="" style="float: left;" width="60%;padding-left:20px;">
        <table width="60%" style="border: unset">

            <tbody>
                @foreach ($test['results'] as $result)
                    @if ($result['component']['name'] == 'After 1 hour')
                        <tr width="100%" style="margin-left: 40px;border:unset">
                            <td width="40%" style="border:unset">

                                {{ $result['component']['name'] }}

                            </td>

                            <td width="30%" style="border:unset">
                                {{ $result['result'] }} %

                                :
                            </td>
                            <td width="30%" style="border:unset">
                                {{ abs((100 - $result['result']) - $totalLeftSide) }}
                                {{ $result['component']['unit'] }}
                                 @php
                                    $val1 = abs((100 - $result['result']) - $totalLeftSide);
                                @endphp
                            </td>
                        </tr>
                    @endif



                    {{-- <div style="clear: both"></div> --}}

                    @if ($result['component']['name'] == 'After 2 hour')
                        <tr width="100%" style="margin-left: 40px;border:unset">
                            <td width="40%" style="border:unset">

                                {{ $result['component']['name'] }}

                            </td>

                            <td width="30%" style="border:unset">
                                {{ $result['result'] }} %

                                :
                            </td>
                            <td width="30%" style="border:unset">

                                {{ abs((100 - $result['result']) - $totalLeftSide) }}
                                @php
                                    $val2 = abs((100 - $result['result']) - $totalLeftSide);
                                @endphp
                                {{ $result['component']['unit'] }}

                            </td>
                        </tr>
                    @endif
                    <!--{{-- <div style="clear: both"></div> --}}-->
                @endforeach
            <tbody>
        </table>
    </div>
</div>
<div class="" width="100%" style="float: left;margin-left: 40px">
    Normal: motile spermatic count in first hour > 60 %
</div>
<div style="clear: both"></div>
<div align="center" width="100%" style="margin-top:10px">
    <div class="" style="float: left;margin-left: 5%" width="40%" align="center">
        <p class="pos" style="margin:0">{{ $val1 }} %</p>
        <img src="{{ url('uploads/semen/semen_2_image.png') }}" style="height: 150px;margin-top:0px">

    </div>


    <div style="float: right;margin-left:5%" align="center" width="40%">
        @php
            $chart2 = new QuickChart([
                'width' => 500,
                'height' => 280,
            ]);
            $fal = false;
            if (isset($val1) && isset($val2)) {
                $chart2->setConfig("{
    type: 'line',
    
    data: {
        labels: ['After 1 hour', 'After 2 hour'],
        datasets: [{
        label:'Normal',
        data: [$val1 ,$val2],
        borderColor: 'rgb(255, 99, 132)'
        }]
    }
    }");
            }
        @endphp
        @if (isset($val1) && isset($val2))
            <img src="{{ $chart2->getUrl() }}" width="100%">
        @endif



    </div>
</div>

<div style="clear: both"></div>
<div class="" width="60%" style="float: left">
    <div class="heading">
        <h1 style="font-size: 22px;font-weight: bold;  text-decoration: underline;margin-top: 2px;margin-bottom: 2px">
            First Hour Profile:
        </h1>
        <div class="" style="float: left;" width="65%;padding-left:20px">
            <table style="border: unset">

                @foreach ($test['results'] as $result)
                    <tr style="border:unset" width="100%">

                        @if ($result['component']['name'] == 'Grade A')
                            <td class="" style="margin-left: 40px;border:unset" width="65%" align="left">
                                <b>{{ $result['component']['name'] }}</b>
                                (rapid linear progression)
        </div>
        </td>
        <td style="border:unset">
            <span class="" align="center">
                :
            </span>
        </td>
        <td width="15%" style="border:unset">
            {{ $result['result'] }} %
        </td>
        <td style="border:unset" width="15%">
            <div class="" style="margin-top:-20px">
                @php
                   
                    $gardeA = abs((100 - $result['result']) - $val1);
                    $gradeAValue = $result['result'];
                @endphp
                {{ $gardeA }}
                {{ $result['component']['unit'] }}
            </div>
        </td>
        @endif
        </tr>
        <tr style="border:unset">

            @if ($result['component']['name'] == 'Grade B')
                <td style="margin-left: 40px;border:unset" width="65%" align="left">
                    <b>{{ $result['component']['name'] }}</b>
                    (slow linear or non-linear)
                </td>
                <td style="border:unset">
                    <span class="" align="center">
                        :
                    </span>
                </td>
                <td style="border:unset" width="15%">
                    {{ $result['result'] }} %
                </td>
                <td class="" style="border:unset;margin-top:-20px" width="15%">
                    @php
                   
                        $gardeB = abs((100 - $result['result']) - $val1);
                        $gradeBValue = $result['result'];
                    @endphp
                    {{ $gardeB }}
                    {{ $result['component']['unit'] }}

                </td>
            @endif
        </tr>
        <tr>
        <tr style="border: unset">
            @if ($result['component']['name'] == 'Grade C')
                <td class="" style="margin-left: 40px;border:unset;margin-top:-20px" width="65%" align="left">
                    <b>{{ $result['component']['name'] }}</b>
                    (non-progressive motility)
                </td>
                <td style="border:unset">
                    <span class="" align="center">
                        :
                    </span>
                </td>
                <td style="border: unset" width="15%">
                    {{ $result['result'] }} %
                </td>
                <td class="" style="border:unset;margin-top:-20px" width="15%">
                    @php
                        $gardeC = abs((100 - $result['result']) - $val1);
                        $gradeCValue = $result['result'];
                    @endphp
                    {{ $gardeC }}
                    {{ $result['component']['unit'] }}

                </td>
            @endif
        </tr>

        <tr style="border:unset">
            @if ($result['component']['name'] == 'Grade D')
                <td class="" style="border:unset;margin-left: 40px" width="65%" align="left">
                    <b>{{ $result['component']['name'] }}</b>
                    (immotile spermatozoa)
                </td>
                <td style="border:unset;">
                    <span class="" align="center">
                        :
                    </span>
                </td>

                <td style="border:unset;float: right;margin-top:-20px" width="15%">
                    {{ $result['result'] }} %
                </td>

                <td class="" style="border:unset;margin-top:-20px" width="15%">
                     {{ abs((100 - $result['result']) -  $val1) }}
                    {{ $result['component']['unit'] }}
                </td>
            @endif
        </tr>

        <tr style="border:unset">
            @if ($result['component']['name'] == 'Grade A+B')
                <td class="" style="border:unset;margin-left: 40px" width="65%" align="left">
                    <b>Grade A+B</b>
                    (forward progression)
                </td>
                <td style="border: unset">
                    <span class="" align="center">
                        :
                    </span>
                </td>
                <td style="border:unset" width="15%">
                    <div class="" style="float: right;margin-top:-20px" width="35%">
                        {{ $gradeAValue + $gradeBValue }} %
                    </div>
                </td>
            @endif
            @endforeach
        </tr>
        </table>
    </div>
</div>
<div style="clear: both"></div>
<div style="margin-left: 40px;text-decoration: underline">
    <b>Normal: Grade A > 25% or Grade (A+B) >= 50%</b>
</div>
<div style="clear: both"></div>
<div style="margin-left: 40px">
    <span>
        Dead Forms In First Hour:
    </span>
    <span style="margin-left:50px">
        <input type="text" value="{{ 100 - ($gradeAValue + $gradeBValue + $gradeCValue) }} %">
    </span>
</div>
</div>
<div style="float: left;margin-left:5%" align="center" width="40%">
    @php
        foreach ($test['results'] as $result) {
            if (isset($result['component'])) {
                if ($result['component']['name'] == 'Grade A') {
                    $val1 = $result['result'];
                }
        
                if ($result['component']['name'] == 'Grade B') {
                    $val2 = $result['result'];
                }
        
                if ($result['component']['name'] == 'Grade C') {
                    $val3 = $result['result'];
                }
        
                if ($result['component']['name'] == 'Grade D') {
                    $val4 = $result['result'];
                }
            }
        }
        
        $chart2 = new QuickChart([
            'width' => 500,
            'height' => 280,
        ]);
        $fal = false;
        if (isset($val1) && isset($val2) && isset($val3)) {
            $chart2->setConfig("{
type: 'bar',

data: {
    labels: ['Grade A', 'Grade B', 'Grade C' , 'Grade D'],
    datasets: [{
    label:'Normal',
    data: [$val1 ,$val2 , $val3 , $val4],
    borderColor: 'rgb(255, 99, 132)',
    }]
}
}");
        }
    @endphp
    @if (isset($val1) && isset($val2) && isset($val3))
        <img src="{{ $chart2->getUrl() }}" width="100%">
    @endif
</div>
<div style="clear: both"></div>

@foreach ($test['results'] as $result)
    @if ($result['component']['name'] == 'Head defects')
        @php $var1 = $result['result'] @endphp
    @endif

    @if ($result['component']['name'] == 'Mid piece defects')
        @php $var2 = $result['result'] @endphp
    @endif

    @if ($result['component']['name'] == 'Tail defects')
        @php $var3 = $result['result'] @endphp
    @endif
    @if ($result['component']['name'] == 'Micro spermia')
        @php $var4 = $result['result'] @endphp
    @endif
@endforeach
<div class="heading">
    <div width="50%" align="left">
        <span
            style="font-size: 18px;font-weight: bold; float: left; text-decoration: underline;margin-top: 2px;margin-bottom: 2px">
            Abnormal Forms:
        </span>
        <input type="text" value="{{ $var1 + $var2 + $var3 + $var4 }}%" style="margin-left:10px">
    </div>
    <div style="clear: both"></div>
   
</div>
<div class="" style="float: left;" width="40%;padding-left:20px">
    <table class="withoutBorder">
        @foreach ($test['results'] as $result)
            <tr class="withoutBorder">
                @if ($result['component']['name'] == 'Head Defects')
                    <td class="withoutBorder" style="margin-left: 40px" width="40%" align="left">
                        <b>{{ $result['component']['name'] }}</b>
                        {{-- (rapid linear progression) --}}
                    </td>

                    <td class="withoutBorder" style="margin-top:-20px" width="20%">
                        <span class="" align="center">
                            :
                        </span>
                        {{ $result['result'] }}

                    </td>
                @endif
            </tr>
            {{-- @endforeach --}}
            {{-- <div style="clear: both"></div> --}}
            {{-- @foreach ($test['results'] as $result) --}}
            <tr class="withoutBorder">
                @if ($result['component']['name'] == 'Mid piece defects')
                    <td class="withoutBorder" style="margin-left: 40px" width="40%" align="left">
                        <b>{{ $result['component']['name'] }}</b>

                    </td>

                    <td class="withoutBorder" style="margin-top:-20px" width="20%">
                        <span class="" align="center">
                            :
                        </span>
                        {{ $result['result'] }}


                    </td>
                @endif
            </tr>
            {{-- @endforeach --}}

            {{-- <div style="clear: both"></div> --}}
            {{-- @foreach ($test['results'] as $result) --}}
            <tr class="withoutBorder">
                @if ($result['component']['name'] == 'Tail defects')
                    <td class="withoutBorder" style="margin-left: 40px" width="40%" align="left">
                        <b>{{ $result['component']['name'] }}</b>

                    </td>

                    <td class="withoutBorder" style="margin-top:-20px" width="20%">
                        <span class="" align="center">
                            :
                        </span>
                        {{ $result['result'] }}
                    </td>
                @endif
                {{-- @endforeach --}}
            </tr>
            {{-- <div style="clear: both"></div> --}}
            {{-- @foreach ($test['results'] as $result) --}}
            <tr class="withoutBorder">
                @if ($result['component']['name'] == 'Micro spermia')
                    <td class="withoutBorder" style="margin-left: 40px" width="40%" align="left">
                        <b>{{ $result['component']['name'] }}</b>

                    </td>

                    <td class="withoutBorder" style="margin-top:-20px" width="20%">
                        <span class="" align="center">
                            :
                        </span>
                        {{ $result['result'] }}
                    </td>
                @endif
            </tr>
        @endforeach
    </table>
    {{-- <div style="clear: both"></div> --}}
</div>
<div style="float: right;margin-top:-140px" width="35%">
    @php
        $chart2 = new QuickChart([
            'width' => 500,
            'height' => 280,
        ]);
        $fal = false;
        if (isset($val1) && isset($val2) && isset($val3)) {
            $chart2->setConfig("{
    type: 'bar',
    
    data: {
        labels: ['Head Defects', 'Mid piece defects', 'Tail defects' , 'Micro spermia'],
        datasets: [{
        label:'Abnormal',
        data: [$var1 ,$var2 , $var3 , $var4],
        borderColor: 'rgb(255, 99, 132)',
        }]
    }
    }");
        }
    @endphp
    @if (isset($val1) && isset($val2) && isset($val3))
        <img src="{{ $chart2->getUrl() }}" width="100%">
    @endif

</div>
{{-- <div style="clear: both"></div> --}}

{{-- <div style="clear: both"></div> --}}
</div>


<div style="clear: both;margin-top: 10px"></div>
<div>
    <div align="center" width="100%" style="margin-top:10px">
        <div class="" style="float: left;margin-left: 8%" width="40%" align="center">

            <p class="pos">{{ $var1 }} %</p>
            <img src="{{ url('uploads/semen/firstleft.png') }}" style="height: 150px;margin-top:0px">

        </div>
        <div style="float: left;margin-left:8%" align="center" width="40%">

            <p class="pos">{{ $var2 }} %</p>
            <img src="{{ url('uploads/semen/leftSecond.png') }}" style="height: 150px;margin-top:0px">

        </div>
    </div>
</div>


<div style="clear: both;margin-top: 10px"></div>
<div>
    <div align="center" width="100%" style="margin-top:10px">
        <div class="" style="float: left;margin-left: 8%" width="40%" align="center">

            <p class="pos">{{ $var3 }} %</p>
            <img src="{{ url('uploads/semen/rightLeft.png') }}" style="height: 150px;margin-top:0px">

        </div>
        <div style="float: left;margin-left:8%" align="center" width="40%">

            {{-- @if (isset($group->images[1])) --}}
            <p class="pos">{{ $var4 }} %</p>

            <img src="{{ url('uploads/semen/rightSecond.png') }}" style="height: 150px;margin-top:0px">
            {{-- @endif --}}
        </div>

    </div>
</div>