<div class="dropdown">
   <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fa fa-cog"></i>
   </button>

   <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

      @can('edit_group')
      @if($group->rays->isNotEmpty())
         <a href="{{route('admin.ray_groups.edit',$group['id'])}}" class="dropdown-item">
            <i class="fa fa-edit"></i>
            {{__('Edit')}}
         </a>
      @else
         <a href="{{route('admin.groups.edit',$group['id'])}}" class="dropdown-item">
            <i class="fa fa-edit"></i>
            {{__('Edit')}}
         </a>
      @endif
      @endcan

      @can('view_group')
      <a style="cursor: pointer" data-toggle="modal" data-target="#print_barcode_modal{{$group['id']}}" class="dropdown-item print_barcode" group_id="{{$group['id']}}">
         <i class="fa fa-barcode" aria-hidden="true"></i>
         {{__('Print barcode')}}
      </a>
      {{--  <a style="cursor: pointer" data-toggle="modal" data-target="#print_barcode_modal{{$group['id']}}" class="dropdown-item print_barcode" group_id="{{$group['id']}}">
         <i class="fa fa-barcode" aria-hidden="true"></i>
         {{__('Print barcode Rirect')}}
      </a>  --}}
      <a href="{{route('admin.groups.working_paper',$group['id'])}}" class="dropdown-item">
         <i class="fas fa-file-word" aria-hidden="true"></i>
         {{__('Working paper')}}
      </a>
      {{--  <a href="{{route('admin.groups.working_paper',$group['id'])}}" class="dropdown-item">
         <i class="fas fa-file-word" aria-hidden="true"></i>
         {{__('Working paper Rirect')}}
      </a>  --}}
      <a href="{{$group['receipt_pdf']}}" class="dropdown-item" target="_blank">
         <i class="fa fa-print" aria-hidden="true"></i>
         {{__('Print receipt')}}
      </a>
      {{--  <a href="{{$group['receipt_pdf']}}" class="dropdown-item" target="_blank">
         <i class="fa fa-print" aria-hidden="true"></i>
         {{__('Print receipt Rirect')}}
      </a>  --}}
      <a href="{{route('admin.groups.show',$group['id'])}}" class="dropdown-item">
         <i class="fa fa-eye" aria-hidden="true"></i>
         {{__('Show receipt')}}
      </a>
      @if($whatsapp['receipt']['active']&&isset($group['receipt_pdf']))
      <a target="_blank" href="{{whatsapp_notification($group,'receipt')}}" class="dropdown-item">
         <i class="fab fa-whatsapp" aria-hidden="true" class="text-success"></i>
         {{__('Send receipt by WA')}}
      </a>
      @endif
      @if($email['receipt']['active']&&isset($group['receipt_pdf']))
      <form action="{{route('admin.groups.send_receipt_mail',$group['id'])}}" method="POST" class="d-inline">
         @csrf
         <button type="submit" class="dropdown-item">
            <i class="fa fa-envelope" aria-hidden="true" class="text-success"></i>
            {{__('Send receipt by mail')}}
         </button>
      </form>
      @endif
      @endcan

      @can('edit_medical_report')
      <a href="{{route('admin.medical_reports.edit',$group['id'])}}" class="dropdown-item">
         <i class="fa fa-flag"></i>
         {{__('Enter report')}}
      </a>
      @endcan

      @can('delete_group')
         <form method="POST" action="{{route('admin.groups.destroy',$group['id'])}}" class="d-inline">
            <input type="hidden" name="_method" value="delete">
            <a href="#" class="dropdown-item delete_group">
               <i class="fa fa-trash"></i>
               {{__('Delete')}}
            </a>
         </form>
      @endcan
      @can('retrieve_group')
         @if ($group['done'] == 0)
            <form method="POST" action="{{route('admin.group.retrieve',$group['id'])}}" class="d-inline">
               @csrf
               {{-- <input type="hidden" name="_method" value="delete"> --}}
               <a href="#" class="dropdown-item delete_group">
                  <i class="fa fa-trash"></i>
                  {{__('Retrieve')}}
               </a>
            </form>
         @endif
      @endcan
      @can('edit_medical_report')
      <a href="#" data-toggle="modal" data-target="#exampleModalCenter{{$group['id']}}" class="dropdown-item">
         <i class="fa fa-check"></i>
         {{__('Check Test')}}
      </a>
      @endcan
        <a href="{{ route('admin.cycle',$group['id']) }}" class="dropdown-item" >
         <i class="fa fa-recycle"></i>
         {{__('Cycle')}}
        </a>
   </div>
</div>

@php

// get group by id
$group = \App\Models\Group::find($group['id']);

@endphp

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter{{$group['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">{{__('Check Test')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="{{route('admin.group.check.test' , $group['id'])}}" method="post">
               @csrf()
               @foreach($group->all_tests as $test)
               <div class="form-group">
                  <label for="">{{$test->test->name}}</label>
                  <input type="hidden" class="form-control" name="test_id[]" value="{{$test->id}}">
                  <input type="checkbox" class="form-control check-test" {{ $test->check_test == 1 ? 'checked' : '' }} name="" value="{{ $test->id }}">
                  <input type="hidden" class="form-control check_test" name="check_test[]" value="{{ $test->check_test == 1 ? $test->id : '' }}">
               </div>
               @endforeach
               @foreach($group->all_cultures as $culture)
               <div class="form-group">
                  <label for="">{{$culture->culture->name}}</label>
                  <input type="hidden" class="form-control" name="culture_id[]" value="{{$culture->id}}">
                  <input type="checkbox" class="form-control check-test" {{ $culture->check_test == 1 ? 'checked' : '' }} name="" value="{{ $culture->id }}">
                  <input type="hidden" class="form-control check_test" name="check_test[]" value="{{ $culture->check_test == 1 ? $culture->id : '' }}">
               </div>
               @endforeach
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                  <button class="btn btn-primary">{{__('Save')}}</button>
               </div>
            </form>

         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="print_barcode_modal{{$group['id']}}" aria-hidden="true">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">{{__('Print barcode')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
         </div>
         <form action="{{ route('admin.groups.print_barcode',$group['id']) }}" method="POST" id="print_barcode_form" target="_blank">
            @csrf
            <div class="modal-body">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="form-group">
                        <label for="number">{{__('Number of samples')}}</label>
                        @php
                           $sample_type_arr = [];
                           foreach ($group->all_tests as $value) {
                              if(!in_array($value->test->sample_type,$sample_type_arr)){
                                 array_push($sample_type_arr,$value->test->sample_type);
                              }
                           }
                           foreach ($group->all_cultures as $value) {
                              if(!in_array($value->culture->sample_type,$sample_type_arr)){
                                 array_push($sample_type_arr,$value->culture->sample_type);
                              }
                           }
                        @endphp
                        <input type="number" id="number" name="number" placeholder="{{__('Number of samples')}}" class="form-control" value="{{ count($sample_type_arr) }}" min="1" max="{{
                           // get test and groupBy sample type use map
                           count($sample_type_arr)
                        }}" required>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('Close')}}</button>
               <button type="submit" class="btn btn-primary">Print</button>
            </div>
         </form>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
