@extends('layouts.app')

@section('title')
    {{ __('Contract reports') }}
@endsection
@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Contract reports')}}</li>
@endsection
@section('content')

    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body px-2">
            <section class="invoice-list-wrapper">
                <div class="card">

                    <!-- Filtering Form -->
                    <div id="accordion">
                        <div class="card card-info">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                class="btn btn-primary collapsed" aria-expanded="false">
                                <i class="fas fa-filter"></i> {{ __('Filters') }}
                            </a>
                            <form method="get" action="{{ route('admin.reports.contract') }}">
                                <div id="collapseOne" class="panel-collapse in collapse show">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- date range -->
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                <label>{{ __('Date range') }}:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="far fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" name="date"
                                                        class="form-control float-right datepickerrange"
                                                        @if (request()->has('date')) value="{{ request()->get('date') }}" @endif
                                                        id="date" required>
                                                </div>
                                            </div>
                                            <!-- \date range -->

                                    <!-- Contracts -->
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label>{{ __('Contract') }}</label>
                                            <select class="form-control select2" name="contract" id="contract" required>
                                                @foreach ($contracts as $contract)
                                                    <option value="{{ $contract['id'] }}" @if(isset($contractSelected) &&  $contractSelected == $contract['id']  ) selected @endif>
                                                        {{ $contract['title'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- \Contracts -->

                                    <div class="col-lg-3 lab-to-lab d-none @if(isset($government_id)) d-block @else d-none @endif">
                                        <div class="form-group">
                                            <label for="government_id">{{__('Government')}}</label>
                                            <select name="government_id" id="government_id" class="form-control">
                                                <option></option>
                                                @foreach($governments as $government)
                                                    <option value="{{ $government->id }}">{{ $government->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" id="government_name" name="government_name">
                                        </div>
                                    </div>
                
                                    <div class="col-lg-3 lab-to-lab d-none @if(isset($region_id)) d-block @else d-none @endif">
                                        <div class="form-group">
                                            <label for="region_id">{{__('Region')}}</label>
                                            <select name="region_id" id="region_id" class="form-control">
                                                <option></option>
                                            </select>
                                            <input type="hidden" id="region_name" name="region_name">
                
                                        </div>
                                    </div>
                
                                    <div class="col-lg-3 lab-to-lab d-none @if(isset($user_id)) d-block @else d-none @endif">
                                        <div class="form-group">
                                            <label for="user_id_lab">{{__('Lab')}}</label>
                                            <select name="user_id" id="user_id_lab" class="form-control select2">
                                            </select>
                                            <input type="hidden" id="user_name" name="user_name">
                                        </div>
                                    </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-cog"></i>
                                            {{ __('Generate') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Filtering Form -->

                    <section id="advanced-search-datatable">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">{{ __('Contract reports') }}</h4>
                                    </div>
                                    <hr class="my-0">
                                    <div class="card-datatable">
                                        <table class="table table-striped table-bordered" style="width: 100%">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting">#</th>
                                                    <th class="sorting">{{ __('Test Name') }}</th>
                                                    <th class="sorting">{{ __('Number of invoices') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($tests))
                                                    @foreach($tests as $index => $test)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $test->name }}</td>
                                                            <td>{{ $test->testCount}}</td>
                                                            {{-- <td>{{ $rep->rep_groups()->count() }}</td> --}}
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="3">{{ __('No Data') }}</td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                        </table>
                                        <!--Search Form -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </div>
    </div>
@endsection


@section('scripts')
    <script>


        (function($){
          "use strict";


            $(document).on('change', '#contract', function(e) {
                if ($(this).val() == '2') {
                    $('.lab-to-lab').removeClass('d-none').addClass('d-block');
                } else {
                    $('.lab-to-lab').addClass('d-none').removeClass('d-block');
                }
            });
      
            $('#government_id').change(function () {
                $.get("{{ url('admin/visits/') }}" + "/" + jQuery('#government_id').val() + "/get-regions",
                    function(response){
                        let region_base = document.getElementById('region_id')
                        region_base.innerHTML = "";
                        region_base.innerHTML += "<option></option>";
                        response.data.forEach(function(e) {
                            region_base.innerHTML += "<option value='" + e.id +"" + "'>" + e.name + "</option>";
                        })

                        // $('#government_name').val(jQuery('#government_id').val())     
                        // let rep_base = document.getElementById('rep_id')
                        // rep_base.innerHTML = "";
                        // rep_base.innerHTML += "<option></option>";
                        // response.rep.forEach(function(e) {
                        //     rep_base.innerHTML += "<option value='" + e.id +"" + "'>" + e.name + "</option>";
                        // })
                    }
                );
            })
      
            $('#region_id').change(function () {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.visits.get-users') }}",
                    data: {'government_id': jQuery('#government_id').val(), 'region_id': jQuery('#region_id').val()},
                    success: function(response){
                        console.log(response)
                        let user_base = document.getElementById('user_id_lab')
                        user_base.innerHTML = "";
                        user_base.innerHTML += "<option></option>";
                        response.data.forEach(function(e) {
                            user_base.innerHTML += "<option value='" + e.id +"" + "'>" + e.lab_code +'-'+ e.name + "</option>";
                        })
                    }
                });
            })
      
          @if(isset($visit)&&isset($visit['patient']))
              $('#code').append('<option value="{{$visit["patient_id"]}}" selected>{{$visit["patient"]["code"]}}</option>');
              $('#code').trigger({
                  type: 'select2:select',
                  params: {
                      data:{
                          id:"{{$visit['patient_id']}}",
                          text:"{{$visit['patient']['code']}}"
                      }
                  }
              });
          @endif
        })(jQuery);
      
      
        $('#discount').keyup(function(){
          var discount_value = $('#discount_value');
          var subtotal = $('#subtotal').val();
      
          discount_value.val(Math.round(subtotal / 100 * $(this).val()))
      
        })
        $('#discount_value').keyup(function(){
          var discount= $('#discount');
          var subtotal = $('#subtotal').val();
          var total = $('#total');
          var due = $('#due');
      
          discount.val( Math.round($(this).val() * 100 / subtotal) );
      
          total.val(subtotal - Math.round($(this).val()));
          due.val(subtotal - Math.round($(this).val()));
      
      
        })
      
      
    </script>
@endsection