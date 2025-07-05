    <a class="btn btn-primary btn-sm" href="{{route('admin.fixed_assets.edit',$fixed_asset['id'])}}">
        <i class="fa fa-edit" aria-hidden="true"></i>
    </a>

    <form method="POST" action="{{route('admin.fixed_assets.destroy',$fixed_asset['id'])}}" class="d-inline">
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_fixed_assets">
            <i class="fa fa-trash"></i>
        </button>
    </form>
