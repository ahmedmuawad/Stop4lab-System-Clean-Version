
    <a href="{{route('admin.labs_out.edit',$lab_out['id'])}}" class="btn btn-primary btn-sm">
        <i class="fa fa-edit"></i>
    </a>



    <form method="POST" action="{{route('admin.labs_out.destroy',$lab_out['id'])}}"  class="d-inline">
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_lab_out">
            <i class="fa fa-trash"></i>
        </button>
    </form>
