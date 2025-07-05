@can('edit_test')
    <a href="{{route('admin.rays.edit',$ray['id'])}}" class="btn btn-primary btn-sm">
        <i class="fa fa-edit"></i>
    </a>
@endcan

@can('delete_test')
    <form method="POST" action="{{route('admin.rays.destroy',$ray['id'])}}" class="d-inline">
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_ray">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endcan