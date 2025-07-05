<div style="float: right;
width: 29%;
padding-bottom: 10px;
text-align: center;">

    @php
        use App\Models\Test;
        
        $lymph = '';
        $neu = '';
        $mono = '';
        $plt = '';
        $rbcs = '';
        $pltStatus = '';
        $rbcsStatus = '';
        
        $min = 0;
        
        foreach ($test as $result) {
            if (\Str::slug($result['component']['name']) == 'lymphocytes') {
                $lymph = $result['result'];
            }
            if (\Str::slug($result['component']['name']) == 'neutrophil') {
                $neu = $result['result'];
            }
            if (\Str::slug($result['component']['name']) == 'monocytes') {
                $mono = $result['result'];
                if (count($result['component']->reference_ranges)) {
                    foreach ($result['component']->reference_ranges as $ref_range) {
                        if (($ref_range->gender == $group->patient->gender or $ref_range->gender == 'both') && (int) $group->patient->age <= $ref_range->age_to_days / 365 && (int) $group->patient->age >= $ref_range->age_from_days / 365) {
                            $mono_to = $ref_range->normal_to ;                     
                        }
                    }
                }
            }
            if (\Str::slug($result['component']['name']) == 'rbcs') {
                $rbcs = $result['result'];
        
                if (count($result['component']->reference_ranges)) {
                    foreach ($result['component']->reference_ranges as $ref_range) {
                        if (($ref_range->gender == $group->patient->gender or $ref_range->gender == 'both') && (int) $group->patient->age <= $ref_range->age_to_days / 365 && (int) $group->patient->age >= $ref_range->age_from_days / 365) {
                            $rbcs_from = $ref_range->normal_from ;                      
                        }
                    }
                }
        
                $rbcsStatus = $result['status'];
            }
            if (\Str::slug($result['component']['name']) == 'plateletplt' || \Str::slug($result['component']['name']) == 'platelet-count-plt') {
                $plt = $result['result'];
                $pltStatus = $result['status'];

                if (count($result['component']->reference_ranges)) {
                    foreach ($result['component']->reference_ranges as $ref_range) {
                        if (($ref_range->gender == $group->patient->gender or $ref_range->gender == 'both') && (int) $group->patient->age <= $ref_range->age_to_days / 365 && (int) $group->patient->age >= $ref_range->age_from_days / 365) {
                            $plt_from = $ref_range->normal_from ;                      
                        }
                    }
                }
            }
        }
        
        if ($lymph != null && $neu != null) {
            if ($lymph - $neu <= 0) {
                $min = ($lymph - $neu) * -1;
            } else {
                $min = $lymph - $neu;
            }
        }
        
        // $min = $test->whereHas('component',function($q){return $q->where('name','Hemoglobin (Hb) RBCs');})->first();
        
    @endphp

    <div>
        <table>
            
            @if ($min <= 20)
                @if (isset($mono_to) && $mono > $mono_to)
                    <tr>
                        
                        <td>
                            <img src="{{ public_path('histogram/Mon.png') }}" style="height: 90px; width: 200px; ">
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>
                            <img src="{{ public_path('histogram/eqal.png') }}" style="height: 90px; width: 200px; ">
                        </td>
                    </tr>
                @endif

            @elseif ($lymph > $neu)
                <tr>
                    <td>
                        <img src="{{ public_path('histogram/LM.png') }}" style="height: 90px; width: 200px; ">
                    </td>
                </tr>
            @elseif ($lymph < $neu)
                <tr>
                    <td>
                        <img src="{{ public_path('histogram/NE.png') }}" style="height: 90px; width: 200px; ">
                    </td>
                </tr>
            @endif

            @if (isset($plt_from ) && $plt < $plt_from )
                <tr>
                    <td>
                        <img src="{{ public_path('histogram/PL.png') }}" style="height: 90px; width: 200px; ">
                    </td>
                </tr>
            @else
                <tr>
                    <td>
                        <img src="{{ public_path('histogram/PH.png') }}" style="height: 90px; width: 200px; ">
                    </td>
                </tr>
            @endif

            @if ( isset($rbcs_from ) && $rbcs < $rbcs_from)
                <tr>
                    <td>
                        <img src="{{ public_path('histogram/RLL.png') }}" style="height: 90px; width: 200px; ">
                    </td>
                </tr>
            @else
                <tr>
                    <td>
                        <img src="{{ public_path('histogram/RHH.png') }}" style="height: 90px; width: 200px; ">
                    </td>
                </tr>
            @endif
        </table>
    </div>
</div>
