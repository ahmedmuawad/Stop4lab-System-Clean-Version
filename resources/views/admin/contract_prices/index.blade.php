@extends('layouts.app')

@section('title')
    {{ __('Tests Price List') }}
@endsection

@section('css')
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css"> --}}

@endsection

@section('breadcrumb')
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Tests Price List') }}</li>
@endsection

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                {{ __('Tests Table') }}
            </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <!-- Tool -->
            <div class="row">
                <div class="col-lg-12">
                    <div id="accordion">
                        <div class="card card-info">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                class="btn btn-primary collapsed" aria-expanded="false">
                                <i class="fas fa-file-excel"></i>
                                {{ __('Import / Export') }}
                            </a>
                            <div id="collapseOne" class="panel-collapse in collapse">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 text-center">
                                            <a href="{{ route('admin.contractes_prices_export') }}"
                                                class="btn btn-success">
                                                <i class="fa fa-file-excel"></i>
                                                {{ __('Export') }}
                                            </a>
                                        </div>
                                        <div class="col-lg-12">
                                            <!-- import form -->
                                            <form action="{{ route('admin.contractes_prices_import') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row mt-3">
                                                    <div class="col-lg-12">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h5 class="card-title">{{ __('Import tests') }}</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input"
                                                                            id="exampleInputFile" name="import">
                                                                        <label class="custom-file-label"
                                                                            for="exampleInputFile">{{ __('Choose file') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer">
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="fa fa-check"></i>
                                                                    {{ __('Import') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- /import form -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- \Tool -->

            {{-- test --}}
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <form action="{{ route('admin.contract_prices_submit') }}" method="POST" id="tests_form">
                        @csrf
                        <table id="table_contract_tests" class=" table table-striped table-bordered components">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="15%">{{ __('Name') }}</th>
                                    <th width="15%">{{ __('Category') }}</th>
                                    <th width="20%">{{ __('Price') }}</th>
                                    @foreach ($contracts as $contract)
                                        <th>{{ $contract->title }}</th>
                                    @endforeach
                                </tr>
                            </thead>



                            <tbody>
                                   {{-- {{ dd($testPrice->toArray()) }} --}}
                                @foreach ($testPrice as $key => $test)
                                    <tr>
                                        <td>{{ $test->id }}</td>
                                        <td>{{ $test->name }}</td>
                                        <td>{{ $test->category->name }}</td>
                                        <td>{{ $test->price }} </td>
                                        {{-- {{ dd($contract->tests->toArray()) }} --}}
                                        @foreach ($contracts as $contract)
                                             <td><input type="number" value="{{ $contract->tests[$key]->price}}" name="price[{{ $contract->id }}][{{ $test->id }}]" required/> </td>
                                        @endforeach
                                   </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <button type="submit" class="btn btn-primary save_tests">
                                            {{ __('Update') }}
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div id="hidden_prices">

                        </div>
                    </form>
                </div>
            </div>
            {{-- end test --}}

        </div>
        <!-- /.card-body -->
    </div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                {{ __('Cultures Table') }}
            </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <!-- Tool -->
            <div class="row">
                <div class="col-lg-12">
                    <div id="accordion">
                        <div class="card card-info">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                class="btn btn-primary collapsed" aria-expanded="false">
                                <i class="fas fa-file-excel"></i>
                                {{ __('Import / Export') }}
                            </a>
                            <div id="collapseOne" class="panel-collapse in collapse">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 text-center">
                                            <a href="{{ route('admin.contractes_cultures_export') }}"
                                                class="btn btn-success">
                                                <i class="fa fa-file-excel"></i>
                                                {{ __('Export') }}
                                            </a>
                                        </div>
                                        {{-- <div class="col-lg-12">
                                            <!-- import form -->
                                            <form action="{{ route('admin.contractes_prices_import') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row mt-3">
                                                    <div class="col-lg-12">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h5 class="card-title">{{ __('Import tests') }}</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input"
                                                                            id="exampleInputFile" name="import">
                                                                        <label class="custom-file-label"
                                                                            for="exampleInputFile">{{ __('Choose file') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer">
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="fa fa-check"></i>
                                                                    {{ __('Import') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- /import form -->
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- \Tool -->

            {{-- culture --}}
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <form action="{{ route('admin.contract_prices_culture_submit') }}" method="POST" id="cultures_form">
                        @csrf
                        <table id="table_contract_culture" class=" table table-striped table-bordered components">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="15%">{{ __('Name') }}</th>
                                    <th width="20%">{{ __('Price') }}</th>
                                    @foreach ($contracts as $contract)
                                        <th>{{ $contract->title }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($cultures as $key => $culture)
                                    <tr>
                                        <td>{{ $culture->id }}</td>
                                        <td>{{ $culture->name }}</td>
                                        <td>{{ $culture->price }} </td>

                                        @foreach ($contracts as $contract)
                                             <td><input type="number" value="{{ $contract->cultures[$key]->price}}" name="price[{{ $contract->id }}][{{ $culture->id }}]" required/> </td>
                                        @endforeach
                                   </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <button type="submit" class="btn btn-primary save_cultures">
                                            {{ __('Update') }}
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div id="hidden_prices">

                        </div>
                    </form>
                </div>
            </div>
            {{-- end culture --}}

        </div>
        <!-- /.card-body -->
    </div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                {{ __('Package Table') }}
            </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <!-- Tool -->
            <div class="row">
                <div class="col-lg-12">
                    <div id="accordion">
                        <div class="card card-info">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                class="btn btn-primary collapsed" aria-expanded="false">
                                <i class="fas fa-file-excel"></i>
                                {{ __('Import / Export') }}
                            </a>
                            <div id="collapseOne" class="panel-collapse in collapse">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 text-center">
                                            <a href="{{ route('admin.contractes_packages_export') }}"
                                                class="btn btn-success">
                                                <i class="fa fa-file-excel"></i>
                                                {{ __('Export') }}
                                            </a>
                                        </div>
                                        <div class="col-lg-12">
                                            <!-- import form -->
                                            {{-- <form action="{{ route('admin.contractes_prices_import') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row mt-3">
                                                    <div class="col-lg-12">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h5 class="card-title">{{ __('Import tests') }}</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input"
                                                                            id="exampleInputFile" name="import">
                                                                        <label class="custom-file-label"
                                                                            for="exampleInputFile">{{ __('Choose file') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer">
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="fa fa-check"></i>
                                                                    {{ __('Import') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form> --}}
                                            <!-- /import form -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- \Tool -->

            {{-- package --}}
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <form action="{{ route('admin.contract_prices_package_submit') }}" method="POST" id="packages_form">
                        @csrf
                        <table id="table_contract_package" class=" table table-striped table-bordered components">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="15%">{{ __('Name') }}</th>
                                    <th width="20%">{{ __('Price') }}</th>
                                    @foreach ($contracts as $contract)
                                        <th>{{ $contract->title }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($packages as $key => $package)
                                    <tr>
                                        <td>{{ $package->id }}</td>
                                        <td>{{ $package->name }}</td>
                                        <td>{{ $package->price }} </td>

                                        @foreach ($contracts as $contract)
                                             <td><input type="number" value="{{ $contract->packages[$key]->price}}" name="price[{{ $contract->id }}][{{ $package->id }}]" required/> </td>
                                        @endforeach
                                   </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <button type="submit" class="btn btn-primary save_packages">
                                            {{ __('Update') }}
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div id="hidden_prices">

                        </div>
                    </form>
                </div>
            </div>
            {{-- end package --}}

        </div>
        <!-- /.card-body -->
    </div>
@endsection
@section('scripts')
    <script src="{{ url('js/admin/contract_prices.js') }}"></script>
@endsection
