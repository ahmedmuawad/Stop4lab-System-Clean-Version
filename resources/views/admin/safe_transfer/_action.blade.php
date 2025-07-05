@if($safe->to_branch_id == session('branch_id'))
    @if ($safe->accept == "Pending")

        @can('accept_safe')
            <a href="{{route('admin.safe_transfer.accept',$safe['id'])}}" class="btn btn-primary btn-sm action_safe">
                {{ __('Accept') }}
            </a>            
        @endcan

        @can('refuse_safe')
            <a href="{{route('admin.safe_transfer.refuse',$safe['id'])}}" class="btn btn-danger btn-sm action_safe">
                {{ __('Refuse') }}
            </a>             
        @endcan




            
    @elseif($safe->accept == "Accept" && $safe->export == "Pending")
        @can('accept_safe')
            {{-- <a href="{{route('admin.safe_transfer.refuse',$safe['id'])}}" class="btn btn-danger btn-sm action_safe">
                {{ __('Refuse') }}
            </a>  --}}
            
        @endcan
    @elseif($safe->accept == "Refused" && ($safe->export == "Pending") )
            @can('accept_safe')
                {{-- <a href="{{route('admin.safe_transfer.accept',$safe['id'])}}" class="btn btn-primary btn-sm action_safe">
                    {{ __('Accept') }}
                </a>  --}}
            @endcan
        
    @elseif($safe->accept == "Accept" && $safe->export == "Accept")
        <div class="">
            {{ __('Accepted And Export To Owner') }}
        </div>
    @endif

    @if ($safe->export == "Pending" && $safe->accept == "Accept" && $safe->type =='Outside' )
        @can('export_safe')            
            <a href="{{route('admin.safe_transfer.export',$safe['id'])}}" class="btn btn-success btn-sm action_safe">
                {{ __('Export To Owner') }}
            </a> 
        @endcan
    @endif
@endif

@if ($safe->export == "Refused")
<div class="" style="color: #F00;">
    {{ __('Owner Refused Transfer') }}
</div>
@endif
@if ($safe->export == "Accept")
<div class="" style="color: #0f0;">
    {{ __('Owner Accept Transfer') }}
</div>
@endif


@if ($safe->export == "Send")
    @can('accept_export_safe')
        <a href="{{route('admin.safe_transfer.acceptExport',$safe['id'])}}" class="btn btn-success btn-sm action_safe">
            {{ __('Accept Export') }}
        </a> 
    @endcan

    @can('refuse_export_safe')            
        <a href="{{route('admin.safe_transfer.refuseExport',$safe['id'])}}" class="btn btn-danger btn-sm action_safe">
            {{ __('Refuse Export') }}
        </a> 
    @endcan
@endif

@if ($type == "all")
    @can('delete_safe')            
        <a class="dropdown-item" href="javascript:void(0);">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash mr-50"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            <form method="POST" action="{{route('admin.safe_transfer.destroy',$safe['id'])}}" class="d-inline" id="delete_form">
                <input type="hidden" name="_method" value="delete">
                
                <span class="delete_safe" style="color: #F00;" >Delete</span>
            </form>
            
        </a>
    @endcan
@endif

