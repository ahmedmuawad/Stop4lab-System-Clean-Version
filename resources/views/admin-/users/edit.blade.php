@extends('layouts.app')

@section('title')
{{ __('Edit User') }}
@endsection



@section('breadcrumb')
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.users.index')}}">{{ __('Users') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('Edit User') }}</li>
@endsection

@section('content')
    <div class="app-content content ">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"</h3>
            </div>
            <!-- /.card-header -->
            <form method="POST" action="{{route('admin.users.update',$user['id'])}}">
                @csrf
                @method('put')
                <input type="hidden" id="user_roles" value="{{$user['roles']}}">
                <input type="hidden" id="user_branches" value="{{$user['branches']}}">
                <div class="card-body">
                    <div class="col-lg-12">
                        @include('admin.users._form')
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary">
                          <i class="fa fa-check"></i>  {{__('Save')}}
                        </button>
                    </div>
                </div>
            </form>

            <!-- /.card-body -->
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{url('js/admin/users.js')}}"></script>
    <script>
        $('#government_id').change(function () {
            $.get("{{ url('admin/visits/') }}" + "/" + jQuery('#government_id').val() + "/get-regions",
                function(response){
                    let region_base = document.getElementById('region_id')
                    region_base.innerHTML = "";
                    region_base.innerHTML += "<option></option>";
                    response.data.forEach(function(e) {
                        region_base.innerHTML += "<option value='" + e.id +"" + "'>" + e.name + "</option>";
                    })
                }
            );
        })
    </script>
@endsection
