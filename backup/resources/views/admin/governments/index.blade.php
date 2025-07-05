@extends('layouts.app')

@section('title')
{{__('Governments')}}
@endsection
@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item"><a href="{{route('admin.contracts.index')}}">{{__('Contracts')}}</a></li>
          <li class="breadcrumb-item active">{{__('Governments')}}</li>
@endsection
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body px-2">
                <section class="invoice-list-wrapper">
                    <div class="card">
                        <section id="advanced-search-datatable">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header border-bottom">
                                            <h4 class="card-title"></h4>
                                        {{--                                @can('create_category')--}}
                                            <a href="{{route('admin.governments.create')}}" class="btn btn-primary btn-sm float-right">
                                            <i class="fa fa-plus"></i> {{ __('Create') }}
                                            </a>
                                        {{--                                @endcan--}}
                                        </div>
                                        <hr class="my-0">
                                        <div class="card-datatable">
                                            <table class="table table-striped table-bordered" style="width: 100%">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting">#</th>
                                                        <th class="sorting">{{__('Title')}}</th>
                                                        <th class="sorting">{{__('Action')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($governments as $index => $government)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $government->name }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.governments.edit', $government->id) }}">
                                                                <button class="btn btn-outline-info mb-2">{{ __('Edit') }}</button>
                                                            </a>

                                                            <a href="{{ route('admin.regions.index', $government->id) }}">
                                                                <button class="btn btn-primary mb-2">{{ __('Regions') }}</button>
                                                            </a>
                                                            <form action="{{ route('admin.governments.destroy', $government->id) }}" method="POST" class="d-none" id="delete_form">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                            <a href="#">

                                                                <button class="btn btn-danger delete-alert mb-2 RTL">
                                                                    {{ __('Delete') }}</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3">{{ __('No Data') }}</td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                            {{ $governments->links() }}
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
        $('.delete-alert').on('click', function (event) {
            event.preventDefault()
            swal({
                title: trans("Are you sure to delete government ?"),
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: trans("Delete"),
                cancelButtonText: trans("Cancel"),
                closeOnConfirm: false
            },
            function(){
                $('#delete_form').submit();
            });
        })
    </script>
@stop
