@extends('layouts.app')

@section('title')
{{ __('Create User') }}
@endsection


@section('content')
<div class="app-content content ">

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('Cach in Vault = ') }} {{ get_cash_vault() }} {{get_currency()}}</h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.vault.store')}}">
        @csrf
        <div class="card-body">
            <div class="col-lg-12">
                @include('admin.vault._form')
            </div>
        </div>
        <div class="card-footer">
            <div class="col-lg-12">
                <button type="submit" class="btn btn-primary">
                  <i class="fa fa-check"></i>  {{__('Save')}}
                </button>
                {{-- <div class="float-right">
                    <a>
                        <button type="button" class="btn btn-secondary">
                              {{__('For Main Brach')}}
                        </button>
                    </a>
                    <a>
                        <button type="button" class="btn btn-success">
                              {{__('For Management')}}
                        </button>
                    </a>
                </div> --}}

            </div>
        </div>
    </form>

    <div class="card-body">
        <div class="col-lg-12">
            <form method="POST" action="{{route('admin.vault.custody')}}">
                @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="form-label" for="type">{{__('Custody')}}</label>
                        <input type="number" class="form-control" name="custody"  />
                    </div>
                </div>

            </div> 
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="form-label" for="type">{{__('Status')}}</label>
                        <select  class="form-control select2" name="custody_type" required  >
                            <option value="1">{{ __('Bank') }}</option>
                            <option value="2">{{ __('From Lab') }}</option>
                            <option value="3">{{ __('Main Safe') }}</option>
                            <option value="4">{{ __('branch safe') }}</option>
                        </select>
                    </div>
                </div>
            </div>   
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-check"></i>  {{__('Save')}}
            </button>
            
        </form>
        </div>
    </div>




    <!-- /.card-body -->
</div>

@endsection

@section('scripts')
    <script src="{{url('js/admin/groups.js')}}"></script>
@endsection

