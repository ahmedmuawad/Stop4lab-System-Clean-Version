@if(session()->has('success'))
    <div class="alert alert-light-primary border-0 mb-4" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        {{ session()->get('success') }}
    </div>
@elseif(session()->has('error'))
    <div class="alert alert-light-danger border-0 mb-4" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>  {{ session()->get('error') }}
    </div>
@endif






