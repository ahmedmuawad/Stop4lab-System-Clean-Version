@extends('layouts.app')

@section('title')
{{__('Representative reports')}}
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
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-primary collapsed"
                                   aria-expanded="false">
                                    <i class="fas fa-filter"></i> {{__('Filters')}}
                                </a>
                                <form method="get" action="{{route('admin.reports.rep')}}">
                                    <div id="collapseOne" class="panel-collapse in collapse show">
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- date range -->
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <label>{{__('Date range')}}:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                                        </div>
                                                        <input type="text" name="date" class="form-control float-right datepickerrange"
                                                               @if(request()->has('date')) value="{{request()->get('date')}}" @endif id="date"
                                                               required>
                                                    </div>
                                                </div>
                                                <!-- \date range -->

                                                <!-- representative -->
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="form-group">
                                                        <label>{{__('Representative')}}</label>
                                                        <select class="form-control" name="rep[]" id="rep" multiple>
                                                            @foreach($labs_users as $lab_user)
                                                                <option value="{{$lab_user['id']}}" selected>{{$lab_user['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- \representative -->

                                                <!-- Branch -->
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="form-group">
                                                        <label>{{__('Lab')}}</label>
                                                        <select class="form-control" name="lab[]" id="lab" multiple>
                                                            @foreach($reps_users as $rep_user)
                                                                <option value="{{$rep_user['id']}}" selected>{{$rep_user['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- \Branch -->
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-cog"></i>
                                                {{__('Generate')}}
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
                                            <h4 class="card-title">{{__('Representative reports')}}</h4>
                                        </div>
                                        <hr class="my-0">
                                        <div class="card-datatable">
                                            <table class="table table-striped table-bordered" style="width: 100%">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting">#</th>
                                                        <th class="sorting">{{__('Name')}}</th>
                                                        <th class="sorting">{{__('Number of invoices')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($reps as $index => $rep)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $rep->name }}</td>
                                                        <td>{{ $rep->rep_groups()->count() }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3">{{ __('No Data') }}</td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                            {{ $reps->links() }}
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
