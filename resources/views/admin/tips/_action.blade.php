    <a class="btn btn-primary btn-sm" href="{{route('admin.tips.edit',$tip['id'])}}">
        <i class="fa fa-edit" aria-hidden="true"></i>
    </a>

    <form method="POST" action="{{route('admin.tips.destroy',$tip['id'])}}" class="d-inline">
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_tips">
            <i class="fa fa-trash"></i>
        </button>
    </form>
