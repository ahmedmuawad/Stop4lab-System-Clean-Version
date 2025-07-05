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

                                            <!-- representative -->
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                <div class="form-group">
                                                    <label>{{ __('Contract') }}</label>
                                                    <select class="form-control select2" name="contract[]" id="contract" multiple>
                                                        @foreach ($contracts as $contract)
                                                            <option value="{{ $contract['id'] }}" @if(isset($contractSelected) && in_array($contract['id'] , $contractSelected)) selected @endif>
                                                                {{ $contract['title'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- \representative -->
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
                                                    @forelse($tests as $index => $test)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $test->name }}</td>
                                                            <td>{{ $test->testCount}}</td>
                                                            {{-- <td>{{ $rep->rep_groups()->count() }}</td> --}}
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3">{{ __('No Data') }}</td>
                                                        </tr>
                                                    @endforelse
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
