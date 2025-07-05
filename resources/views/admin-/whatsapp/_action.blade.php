@can('edit_whatsapp')
    <a href="{{route('admin.whatsapp.edit',$whatsapp['id'])}}" class="btn btn-primary btn-sm">
        <i class="fa fa-edit"></i>
    </a>
@endcan

@can('delete_whatsapp')
    <form method="POST" action="{{route('admin.whatsapp.destroy',$whatsapp['id'])}}"  class="d-inline">
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_whatsapp">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endcan