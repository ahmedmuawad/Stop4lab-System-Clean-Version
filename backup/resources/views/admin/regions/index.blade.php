@extends('layouts.app')

@section('title')
{{__('Regions')}}
@endsection
@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item"><a href="{{route('admin.governments.index')}}">{{__('Governments')}}</a></li>
          <li class="breadcrumb-item active">{{__('Regions')}}</li>
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
                        <section id="advanced-search-datatable">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header border-bottom">
                                            <h4 class="card-title">{{$government->name}}</h4>
                                        {{--                                @can('create_category')--}}
                                            <a href="{{route('admin.regions.create', $government->id)}}" class="btn btn-primary btn-sm float-right">
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
                                                @forelse($regions as $index => $region)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $region->name }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.regions.edit', $region->id) }}">
                                                                <button class="btn btn-outline-info mb-2">{{ __('Edit') }}</button>
                                                            </a>

                                                            <form action="{{ route('admin.regions.destroy', $region->id) }}" method="POST" class="d-none" id="delete_form">
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
                                            {{ $regions->links() }}
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
                title: trans("Are you sure to delete region ?"),
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
