<div class="dropdown">
    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow waves-effect waves-float waves-light" data-toggle="dropdown" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
    </button>
    <div class="dropdown-menu" style="">
        @can('edit_contract')
            <a class="dropdown-item" href="{{route('admin.labs.edit',$lab['id'])}}" class="dropdown-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 mr-50"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                    <span>Edit</span>
            </a>
        @endcan
        @can('delete_contract')
            <a class="dropdown-item" href="javascript:void(0);">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash mr-50"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                <form method="POST" action="{{route('admin.labs.destroy',$lab['id'])}}" class="d-inline" id="delete_form">
                    <input type="hidden" name="_method" value="delete">
                    
                    <span class="delete_contract">Delete</span>
                </form>
                
            </a>
        @endcan
    </div>
</div>