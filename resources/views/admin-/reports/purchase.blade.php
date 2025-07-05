@extends('layouts.app')

@section('title')
    {{__('Purchase report')}}
@endsection
@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Purchase report')}}</li>
@endsection

@section('content')
<div class="app-content content ">
  <div class="content-overlay"></div>
  <div class="header-navbar-shadow"></div>
  <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="card-body">

        <!-- Filtering Form -->
        <div id="accordion">
          <div class="card card-info">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-primary collapsed"
                  aria-expanded="false">
                  <i class="fas fa-filter"></i> {{__('Filters')}}
              </a>
              <form method="get" action="{{route('admin.reports.purchase')}}">
                <div id="collapseOne" class="panel-collapse in collapse show">
                    <div class="card-body">
                      <div class="row">
                          <!-- date range -->
                          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                              <label>{{__('Date range')}}:</label>
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text">
                                          <i class="far fa-calendar-alt"></i>
                                      </span>
                                  </div>
                                  <input type="text" name="date" class="form-control float-right datepickerrange"
                                      @if(request()->has('date')) value="{{request()->get('date')}}" @endif id="date" required>
                              </div>
                          </div>
                          <!-- \date range -->

                          <!-- branches -->
                          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                              <div class="form-group">
                                  <label>{{__('Branch')}}</label>
                                  <select class="form-control" name="branch_id[]" id="branch">
                                      @if(isset($branches))
                                        @foreach($branches as $branch)
                                          <option value="{{$branch['id']}}" selected>{{$branch['name']}}</option>
                                        @endforeach
                                      @endif
                                  </select>
                              </div>
                          </div>
                          <!-- \branches -->

                          <!-- suppliers -->
                          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                              <div class="form-group">
                                  <label>{{__('Supplier')}}</label>
                                  <select class="form-control" name="supplier_id[]" id="supplier">
                                      @if(isset($suppliers))
                                        @foreach($suppliers as $supplier)
                                          <option value="{{$supplier['id']}}" selected>{{$supplier['name']}}</option>
                                        @endforeach
                                      @endif
                                  </select>
                              </div>
                          </div>
                          <!-- \suppliers -->
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

        @if(request()->has('date'))
        <div class="printable">

          <!-- Report summary -->
          <div class="card card-primary">
            <div class="card-header">
              <h5 class="card-title">
                {{__('Summary')}}
              </h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-info-box">
                  <div class="row">
                    <div class="col-3 col-sm-4 col-xs-4">
                      <span class="icon">
                        <span class="text-center">
                          <i class="fa fa-money-bill-wave"></i>
                        </span>
                      </span>
                    </div>
                    <div class="col-7 col-sm-8 col-xs-8">
                      <h4 class="m-0">
                        {{formated_price($total)}}
                      </h4>
                      <span>
                        {{__('Total')}}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-success-box">
                  <div class="row">
                    <div class="col-3 col-sm-4 col-xs-4">
                      <span class="icon">
                        <span class="text-center">
                          <i class="fa fa-money-bill-wave"></i>
                        </span>
                      </span>
                    </div>
                    <div class="col-7 col-sm-8 col-xs-8">
                      <h4 class="m-0">
                        {{formated_price($paid)}}
                      </h4>
                      <span>
                        {{__('Paid')}}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-danger-box">
                  <div class="row">
                    <div class="col-3 col-sm-4 col-xs-4">
                      <span class="icon">
                        <span class="text-center">
                          <i class="fa fa-money-bill-wave"></i>
                        </span>
                      </span>
                    </div>
                    <div class="col-7 col-sm-8 col-xs-8">
                      <h4 class="m-0">
                        {{formated_price($due)}}
                      </h4>
                      <span>
                        {{__('Due')}}
                      </span>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <!-- \Report summary -->

          <!-- Report Details -->
          <div class="card card-primary card-tabs">
            <div class="card-header p-0">
              <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-one-purchases-tab" data-toggle="pill" href="#custom-tabs-one-purchases" role="tab" aria-controls="custom-tabs-one-purchases" aria-selected="false">{{__('Purchases')}}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-payments-tab" data-toggle="pill" href="#custom-tabs-one-payments" role="tab" aria-controls="custom-tabs-one-payments" aria-selected="false">{{__('Payments')}}</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade active show" id="custom-tabs-one-purchases" role="tabpanel" aria-labelledby="custom-tabs-one-purchases-tab">
                  <div class="row">
                    <div class="col-lg-12 table-responsive">
                      <table class="table table-striped table-bordered datatable">
                        <thead>
                          <tr>
                            <th width="10px">#</th>
                            <th>{{__('Supplier')}}</th>
                            <th>{{__('Branch')}}</th>
                            <th>{{__('Date')}}</th>
                            <th>{{__('Total')}}</th>
                            <th>{{__('Paid')}}</th>
                            <th>{{__('Due')}}</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($purchases as $purchase)
                          <tr>
                            <td class="text-center">{{$purchase['id']}}</td>
                            <td>{{$purchase['supplier']['name']}}</td>
                            <td>{{$purchase['branch']['name']}}</td>
                            <td>
                              {{$purchase['date']}}
                            </td>
                            <td>{{formated_price($purchase['total'])}}</td>
                            <td>{{formated_price($purchase['paid'])}}</td>
                            <td>{{formated_price($purchase['due'])}}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-payments" role="tabpanel" aria-labelledby="custom-tabs-one-payments-tab">
                  <div class="row">
                    <div class="col-lg-12 table-responsive">
                      <table class="table table-striped table-bordered datatable">
                        <thead>
                          <tr>
                            <th width="10px" class="text-center">#</th>
                            <th width="10px" class="text-center">#{{__('Purchase')}}</th>
                            <th class="text-center">{{__('Supplier')}}</th>
                            <th class="text-center">{{__('Branch')}}</th>
                            <th>{{__('Date')}}</th>
                            <th>{{__('Amount')}}</th>
                            <th>{{__('Payment method')}}</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($payments as $payment)
                          <tr>
                            <td class="text-center">{{$payment['id']}}</td>
                            <td class="text-center">{{$payment['purchase_id']}}</td>
                            <td class="text-center">{{$payment['purchase']['supplier']['name']}}</td>
                            <td class="text-center">{{$payment['purchase']['branch']['name']}}</td>
                            <td>{{date('Y-m-d',strtotime($payment['date']))}}</td>
                            <td>{{formated_price($payment['amount'])}}</td>
                            <td>{{$payment['payment_method']['name']}}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- \Report Details -->
        </div>
        @endif
      </div>
      @if(request()->has('date'))
      <div class="card-footer">
        <a href="{{request()->fullUrl()}}&pdf=true" class="btn btn-danger" target="_blank">
          <i class="fas fa-file-pdf"></i> {{__('PDF')}}
        </a>
      </div>
    @endif
      {{-- <div class="content-body">
        <section class="invoice-list-wrapper">
            <div class="card">
                <section id="advanced-search-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">{{ __('Transfers table') }}</h4>
                                @can('create_transfer')
                                  <a href="{{route('admin.inventory.transfers.create')}}" class="btn btn-primary btn-sm float-right">
                                    <i class="fa fa-plus"></i> {{ __('Create') }}
                                  </a>
                                @endcan
                            </div>
                            <hr class="my-0">
                            <div class="card-datatable px-2">
                                <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper dt-bootstrap4 table-responsive">
                                  <table class="dt-advanced-search table dataTable dtr-column" id="transfers_table" role="grid" aria-describedby="DataTables_Table_2_info">
                                    <thead>
                                        <tr role="row">
                                          <th width="10px">
                                            <input type="checkbox" class="check_all" name="" id="">
                                          </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" style="width: 138.688px;" aria-label="#: activate to sort column ascending">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" style="width: 142.438px;" aria-label="Created By: activate to sort column ascending">{{__('Date')}}</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" style="width: 142.438px;" aria-label="Created By: activate to sort column ascending">{{__('From branch')}}</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" style="width: 142.438px;" aria-label="Created By: activate to sort column ascending">{{__('To branch')}}</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" style="width: 128.844px;" aria-label="Barcode: activate to sort column ascending">{{__('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                        </tr>
                                    </tfoot>
                              </table>
                            </div>
                            <!--Search Form -->
                        </div>
                    </div>
                </div>
            </section>
            </div>
        </section>
      </div> --}}
  </div>
</div>
{{-- <div class="card card-primary">
  <!-- card-header -->
  <div class="card-header">
    <h3 class="card-title">{{__('Purchase report')}}</h3>
  </div>
  <!-- /.card-header -->
  <!-- card-body -->
  <div class="card-body">

    <!-- Filtering Form -->
    <div id="accordion">
      <div class="card card-info">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-primary collapsed"
              aria-expanded="false">
              <i class="fas fa-filter"></i> {{__('Filters')}}
          </a>
          <form method="get" action="{{route('admin.reports.purchase')}}">
            <div id="collapseOne" class="panel-collapse in collapse show">
                <div class="card-body">
                  <div class="row">
                      <!-- date range -->
                      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                          <label>{{__('Date range')}}:</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                  </span>
                              </div>
                              <input type="text" name="date" class="form-control float-right datepickerrange"
                                  @if(request()->has('date')) value="{{request()->get('date')}}" @endif id="date" required>
                          </div>
                      </div>
                      <!-- \date range -->

                      <!-- branches -->
                      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                          <div class="form-group">
                              <label>{{__('Branch')}}</label>
                              <select class="form-control" name="branch_id[]" id="branch">
                                  @if(isset($branches))
                                    @foreach($branches as $branch)
                                      <option value="{{$branch['id']}}" selected>{{$branch['name']}}</option>
                                    @endforeach
                                  @endif
                              </select>
                          </div>
                      </div>
                      <!-- \branches -->

                      <!-- suppliers -->
                      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                          <div class="form-group">
                              <label>{{__('Supplier')}}</label>
                              <select class="form-control" name="supplier_id[]" id="supplier">
                                  @if(isset($suppliers))
                                    @foreach($suppliers as $supplier)
                                      <option value="{{$supplier['id']}}" selected>{{$supplier['name']}}</option>
                                    @endforeach
                                  @endif
                              </select>
                          </div>
                      </div>
                      <!-- \suppliers -->
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

    @if(request()->has('date'))
    <div class="printable">

      <!-- Report summary -->
      <div class="card card-primary">
        <div class="card-header">
          <h5 class="card-title">
            {{__('Summary')}}
          </h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-info-box">
              <div class="row">
                <div class="col-3 col-sm-4 col-xs-4">
                  <span class="icon">
                    <span class="text-center">
                      <i class="fa fa-money-bill-wave"></i>
                    </span>
                  </span>
                </div>
                <div class="col-7 col-sm-8 col-xs-8">
                  <h4 class="m-0">
                    {{formated_price($total)}}
                  </h4>
                  <span>
                    {{__('Total')}}
                  </span>
                </div>
              </div>
            </div>
            <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-success-box">
              <div class="row">
                <div class="col-3 col-sm-4 col-xs-4">
                  <span class="icon">
                    <span class="text-center">
                      <i class="fa fa-money-bill-wave"></i>
                    </span>
                  </span>
                </div>
                <div class="col-7 col-sm-8 col-xs-8">
                  <h4 class="m-0">
                    {{formated_price($paid)}}
                  </h4>
                  <span>
                    {{__('Paid')}}
                  </span>
                </div>
              </div>
            </div>
            <div class="col-lg-2 col-sm-12 col-xs-12 mt-4 mb-4 custom-danger-box">
              <div class="row">
                <div class="col-3 col-sm-4 col-xs-4">
                  <span class="icon">
                    <span class="text-center">
                      <i class="fa fa-money-bill-wave"></i>
                    </span>
                  </span>
                </div>
                <div class="col-7 col-sm-8 col-xs-8">
                  <h4 class="m-0">
                    {{formated_price($due)}}
                  </h4>
                  <span>
                    {{__('Due')}}
                  </span>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <!-- \Report summary -->

      <!-- Report Details -->
      <div class="card card-primary card-tabs">
        <div class="card-header p-0">
          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="custom-tabs-one-purchases-tab" data-toggle="pill" href="#custom-tabs-one-purchases" role="tab" aria-controls="custom-tabs-one-purchases" aria-selected="false">{{__('Purchases')}}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-one-payments-tab" data-toggle="pill" href="#custom-tabs-one-payments" role="tab" aria-controls="custom-tabs-one-payments" aria-selected="false">{{__('Payments')}}</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="custom-tabs-one-tabContent">
            <div class="tab-pane fade active show" id="custom-tabs-one-purchases" role="tabpanel" aria-labelledby="custom-tabs-one-purchases-tab">
              <div class="row">
                <div class="col-lg-12 table-responsive">
                  <table class="table table-striped table-bordered datatable">
                    <thead>
                      <tr>
                        <th width="10px">#</th>
                        <th>{{__('Supplier')}}</th>
                        <th>{{__('Branch')}}</th>
                        <th>{{__('Date')}}</th>
                        <th>{{__('Total')}}</th>
                        <th>{{__('Paid')}}</th>
                        <th>{{__('Due')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($purchases as $purchase)
                      <tr>
                        <td class="text-center">{{$purchase['id']}}</td>
                        <td>{{$purchase['supplier']['name']}}</td>
                        <td>{{$purchase['branch']['name']}}</td>
                        <td>
                          {{$purchase['date']}}
                        </td>
                        <td>{{formated_price($purchase['total'])}}</td>
                        <td>{{formated_price($purchase['paid'])}}</td>
                        <td>{{formated_price($purchase['due'])}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="custom-tabs-one-payments" role="tabpanel" aria-labelledby="custom-tabs-one-payments-tab">
              <div class="row">
                <div class="col-lg-12 table-responsive">
                  <table class="table table-striped table-bordered datatable">
                    <thead>
                      <tr>
                        <th width="10px" class="text-center">#</th>
                        <th width="10px" class="text-center">#{{__('Purchase')}}</th>
                        <th class="text-center">{{__('Supplier')}}</th>
                        <th class="text-center">{{__('Branch')}}</th>
                        <th>{{__('Date')}}</th>
                        <th>{{__('Amount')}}</th>
                        <th>{{__('Payment method')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($payments as $payment)
                      <tr>
                        <td class="text-center">{{$payment['id']}}</td>
                        <td class="text-center">{{$payment['purchase_id']}}</td>
                        <td class="text-center">{{$payment['purchase']['supplier']['name']}}</td>
                        <td class="text-center">{{$payment['purchase']['branch']['name']}}</td>
                        <td>{{date('Y-m-d',strtotime($payment['date']))}}</td>
                        <td>{{formated_price($payment['amount'])}}</td>
                        <td>{{$payment['payment_method']['name']}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- \Report Details -->
    </div>
    @endif
  </div>
  <!-- /.card-body -->

  <!-- card-footer -->
  @if(request()->has('date'))
    <div class="card-footer">
      <a href="{{request()->fullUrl()}}&pdf=true" class="btn btn-danger" target="_blank">
        <i class="fas fa-file-pdf"></i> {{__('PDF')}}
      </a>
    </div>
  @endif
  <!-- /.card-footer -->
</div> --}}

@endsection
@section('scripts')
    <script src="{{url('plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{url('js/admin/purchase_report.js')}}"></script>
@endsection
