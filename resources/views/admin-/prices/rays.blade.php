@extends('layouts.app')

@section('title')
{{ __('Rays Price List') }}
@endsection

@section('css')

@endsection

@section('breadcrumb')
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item active">{{ __('Rays Price List') }}</li>
@endsection

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            {{--  {{ __('rays Table') }}  --}}
        </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
@if (auth()->guard('admin')->user()->lab_id == null)
        <!-- Tool -->
        <div class="row">
            <div class="col-lg-12">
                <div id="accordion">
                    <div class="card card-info">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                            class="btn btn-primary collapsed" aria-expanded="false">
                            <i class="fas fa-file-excel"></i>
                            {{__('Import / Export')}}
                        </a>
                        <div id="collapseOne" class="panel-collapse in collapse">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <a href="{{route('admin.prices.rays_prices_export')}}" class="btn btn-success">
                                            <i class="fa fa-file-excel"></i>
                                            {{__('Export')}}
                                        </a>
                                    </div>
                                    @can('update_test_prices') 
                                        <div class="col-lg-12">
                                            <!-- import form -->
                                            <form action="{{route('admin.prices.rays_prices_import')}}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row mt-3">
                                                    <div class="col-lg-12">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h5 class="card-title">{{__('Import rays')}}</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input"
                                                                            id="exampleInputFile" name="import">
                                                                        <label class="custom-file-label"
                                                                            for="exampleInputFile">{{__('Choose file')}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer">
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="fa fa-check"></i>
                                                                    {{__('Import')}}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- /import form -->
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- \Tool -->    
@endif


        <div class="row">
            <div class="col-lg-12  p-0">
                <form action="{{route('admin.prices.rays_submit')}}" method="POST">
                    @csrf
                    <table id="rays_prices_table" class="table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th width="10px">#</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Category') }}</th>
                                <th width="200px">{{ __('Price') }}</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                        @can('update_test_prices')    
                            <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <button type="submit" class="btn btn-primary">
                                            {{__('Update')}}
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        @endcan

                    </table>
                    <div id="hidden_prices">

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

@endsection
@section('scripts')
    <script src="{{url('js/admin/rays_prices.js')}}"></script>
@endsection
