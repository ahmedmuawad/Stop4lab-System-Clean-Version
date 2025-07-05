@can('edit_test')
    <a href="{{route('admin.sample_types.edit',$sample['id'])}}" class="btn btn-primary btn-sm">
        <i class="fa fa-edit"></i>
    </a>
@endcan

@can('delete_test')
    <form method="POST" action="{{route('admin.sample_types.destroy',$sample['id'])}}" class="d-inline">
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_sample">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endcan