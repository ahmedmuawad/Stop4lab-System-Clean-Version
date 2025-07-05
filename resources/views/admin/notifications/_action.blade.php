    <!-- <a class="btn btn-primary btn-sm" href="{{route('admin.bookings.edit',$notification['id'])}}">
        <i class="fa fa-edit" aria-hidden="true"></i>
    </a> -->

    <form method="POST" action="{{route('admin.notifications.destroy',$notification['id'])}}" class="d-inline">
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_bookings">
            <i class="fa fa-trash"></i>
        </button>
    </form>
