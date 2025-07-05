    <a class="btn btn-primary btn-sm" href="{{route('admin.prescriptions.edit',$prescription['id'])}}">
        <i class="fa fa-edit" aria-hidden="true"></i>
    </a>

    <form method="POST" action="{{route('admin.prescriptions.destroy',$prescription['id'])}}" class="d-inline">
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_prescriptions">
            <i class="fa fa-trash"></i>
        </button>
    </form>
