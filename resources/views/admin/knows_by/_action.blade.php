@can('edit_group')
    <a href="{{route('admin.knows.edit',$knows['id'])}}" class="btn btn-primary btn-sm">
        <i class="fa fa-edit"></i>
    </a>
@endcan

@can('delete_group')
    <form method="POST" action="{{route('admin.knows.destroy',$knows['id'])}}"  class="d-inline">
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_knows">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endcan