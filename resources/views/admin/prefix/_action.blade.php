
    <a href="{{route('admin.prefix.edit',$prefix['id'])}}" class="btn btn-primary btn-sm">
        <i class="fa fa-edit"></i>
    </a>



    <form method="POST" action="{{route('admin.prefix.destroy',$prefix['id'])}}"  class="d-inline">
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_prefix">
            <i class="fa fa-trash"></i>
        </button>
    </form>
