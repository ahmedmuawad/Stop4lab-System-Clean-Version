@extends('layouts.app')

@section('title')
    {{ __('Details') }}
@endsection

@section('content')
    <div class="content-body">
        <div class="card-header border-bottom">
            <h4 class="card-title">{{ __('Details') }}</h4>
        </div>
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                            aria-controls="collapseTwo">
                            {{ __('Invoice') }}
                        </button>
                    </h5>
                </div>

                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        {{ __('Created By') }}
                        <button type="button" class="btn btn-info">{{ $activity->causer->name }}</button>
                        <br>
                        <br>
                        {{ __($activity->log_name) }} #ID
                        <button type="button" class="btn btn-info">{{ $activity->subject_id }}</button>
                        <br>
                        <br>
                        {{ __('Created At') }}
                        <button type="button" class="btn btn-info">{{  date('Y-m-d g:i A' , strtotime($activity->created_at)) }}</button>
                       
                        <br>
                        <br>
                        {{ __('Name') }}
                        @if($activity->subject_type == "App\Models\TestReferenceRange")
                            <button type="button" class="btn btn-info">{{ (isset($activity->subject->test->name))?$activity->subject->test->name:'' }}</button>
                        @elseif($activity->subject_type == "App\Models\Test")
                            <button type="button" class="btn btn-info">{{ isset($activity->subject->name)?$activity->subject->name:'' }}</button>
                        @endif

                    </div>
                </div>
            </div>

            @foreach ($activity->changes as $key => $item)





            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                            aria-expanded="false" aria-controls="collapseTwo">
                            {{ __($key) }} 
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">


                        @foreach ($item as $key2 => $item2)
                            <button type="button" class="btn btn-info">{{ __($key2) }} : {{ $item2 }}</button>
                        @endforeach

                        <br>
                        <br>

                    </div>
                </div>
            </div>

            @endforeach

            
                {{-- {{ $key }} 
                <br>
                <br>
                @foreach ($item as $k => $it)
                    {{ $k }} => {{ $it }}
                @endforeach
            @endforeach --}}



            
                {{-- <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree"
                                aria-expanded="false" aria-controls="collapseThree">
                                {{ __('Old Data') }}
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            @foreach ($activity->getExtraProperty('old') as $key => $item)
                                <button type="button" class="btn btn-info">{{ $key }} :
                                    {{ $item }}</button>
                            @endforeach

                            <br>
                            <br>
                        </div>
                    </div>
                </div> --}}
            

        </div>
    </div>




@endsection
