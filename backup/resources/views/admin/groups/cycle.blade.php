@extends('layouts.app')

@section('title')
{{__('Cycle')}}
@endsection

@section('content')
<div class="content-body">
     <div class="card-header border-bottom">
          <h4 class="card-title">{{ __('Cycle') }} - # {{ $group->id }} </h4>
     </div>
     <div id="accordion">
          <div class="card">
            <div class="card-header" id="headingOne">
              <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  {{ __('Invoice') }}
                </button>
              </h5>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
              <div class="card-body">
               {{ __('Created By') }}
               <button type="button" class="btn btn-info">{{ $group->created_by_user->name }}</button>
               <br>
               <br>
               {{ __('Created Date') }}
               <button type="button" class="btn btn-info">{{ $group->created_at }}</button>

              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" id="headingTwo">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  {{ __('Sample Receipt') }}
                </button>
              </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
              <div class="card-body">
                    @foreach ($group->all_tests as $test)
                         @if($test->check_test_by != null)
                              <i class="fa fa-check"></i>
                              {{ $test->test->name }}
                              <button type="button" class="btn btn-info">{{ $test->checked_by_user->name }}</button>
                              <button type="button" class="btn btn-info">{{ $test->check_test_date }}</button>
                         @else
                              <i class="fa fa-ban"></i>
                              {{ $test->test->name }}
                         @endif
                         <br>
                         <br>
                    @endforeach
                    @foreach ($group->all_cultures as $test)
                         @if($test->check_test_by != null)
                              <i class="fa fa-check"></i>
                              {{ $test->culture->name }}
                              <button type="button" class="btn btn-info">{{ $test->checked_by_user->name }}</button>
                              <button type="button" class="btn btn-info">{{ $test->check_test_date }}</button>
                         @else
                              <i class="fa fa-ban"></i>
                              {{ $test->culture->name }}
                         @endif
                         <br>
                         <br>
                    @endforeach
               </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" id="headingThree">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  {{ __('barcode') }}
                </button>
              </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
              <div class="card-body">
                    @if ($group->barcoded_by != null)
                         {{ __('Print Barcode By') }}
                         <button type="button" class="btn btn-info">{{ $group->barcoded_by_user->name }}</button>
                         <br>
                         <br>
                         {{ __('Print Barcode Date') }}
                         <button type="button" class="btn btn-info">{{ $group->barcoded_date }}</button>
                    @endif
              </div>
            </div>
          </div>
          <div class="card">
               <div class="card-header" id="headingfor">
                 <h5 class="mb-0">
                   <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefor" aria-expanded="false" aria-controls="collapsefor">
                     {{ __('Working paper') }}
                   </button>
                 </h5>
               </div>
               <div id="collapsefor" class="collapse" aria-labelledby="headingfor" data-parent="#accordion">
                 <div class="card-body">
                       @if ($group->working_paper_by != null)
                            {{ __('Print Working paper By') }}
                            <button type="button" class="btn btn-info">{{ $group->working_paper_by_user->name }}</button>
                            <br>
                            <br>
                            {{ __('Print Working paper Date') }}
                            <button type="button" class="btn btn-info">{{ $group->working_paper_date }}</button>
                       @endif
                 </div>
               </div>
          </div>
          <div class="card">
               <div class="card-header" id="headingFive">
                 <h5 class="mb-0">
                   <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                     {{ __('Tests Resultes') }}
                   </button>
                 </h5>
               </div>
               <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                 <div class="card-body">
                    @foreach ($group->all_tests as $test)
                         @if($test->results_by != null)
                              <i class="fa fa-check"></i>
                              {{ $test->test->name }}
                              <button type="button" class="btn btn-info">{{ $test->results_by_user->name }}</button>
                              <button type="button" class="btn btn-info">{{ $test->updated_at }}</button>
                         @else
                              <i class="fa fa-ban"></i>
                              {{ $test->test->name }}
                         @endif
                         <br>
                         <br>
                    @endforeach
                    @foreach ($group->all_cultures as $test)
                         @if($test->results_by != null)
                              <i class="fa fa-check"></i>
                              {{ $test->culture->name }}
                              <button type="button" class="btn btn-info">{{ $test->results_by_user->name }}</button>
                              <button type="button" class="btn btn-info">{{ $test->updated_at }}</button>
                         @else
                              <i class="fa fa-ban"></i>
                              {{ $test->culture->name }}
                         @endif
                         <br>
                         <br>
                    @endforeach
                 </div>
               </div>
          </div>
          <div class="card">
               <div class="card-header" id="headingSex">
                 <h5 class="mb-0">
                   <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSex" aria-expanded="false" aria-controls="collapseSex">
                     {{ __('Review') }}
                   </button>
                 </h5>
               </div>
               <div id="collapseSex" class="collapse" aria-labelledby="headingSex" data-parent="#accordion">
                 <div class="card-body">
                       @if ($group->review_by != null)
                            {{ __('Reviewed By') }}
                            <button type="button" class="btn btn-info">{{ $group->review_by_user->name }}</button>
                            <br>
                            <br>
                            {{ __('Reviewed Date') }}
                            <button type="button" class="btn btn-info">{{ $group->review_date }}</button>
                       @endif
                 </div>
               </div>
          </div>
          <div class="card">
               <div class="card-header" id="headingSefin">
                 <h5 class="mb-0">
                   <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSefin" aria-expanded="false" aria-controls="collapseSefin">
                     {{ __('Sign') }}
                   </button>
                 </h5>
               </div>
               <div id="collapseSefin" class="collapse" aria-labelledby="headingSefin" data-parent="#accordion">
                 <div class="card-body">
                       @if ($group->signed_by != null)
                            {{ __('Signed By') }}
                            <button type="button" class="btn btn-info">{{ $group->signed_by_user->name }}</button>
                            <br>
                            <br>
                            {{ __('Signed Date') }}
                            <button type="button" class="btn btn-info">{{ $group->signed_date }}</button>
                       @endif
                 </div>
               </div>
          </div>
          <div class="card">
               <div class="card-header" id="headingAit">
                 <h5 class="mb-0">
                   <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseAit" aria-expanded="false" aria-controls="collapseAit">
                     {{ __('Print') }}
                   </button>
                 </h5>
               </div>
               <div id="collapseAit" class="collapse" aria-labelledby="headingAit" data-parent="#accordion">
                 <div class="card-body">
                       @if ($group->medical_print_by != null)
                            {{ __('Printed By') }}
                            <button type="button" class="btn btn-info">{{ $group->medical_print_by_user->name }}</button>
                            <br>
                            <br>
                            {{ __('Printed Date') }}
                            <button type="button" class="btn btn-info">{{ $group->medical_print_date }}</button>
                       @endif
                 </div>
               </div>
          </div>
     </div>
</div>


@endsection

