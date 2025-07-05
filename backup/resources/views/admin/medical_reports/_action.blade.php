<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-cog"></i>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @can('edit_medical_report')
            <a class="dropdown-item" href="{{route('admin.medical_reports.edit',$group['id'])}}">
               <i class="fa fa-flask" aria-hidden="true"></i>
               {{__('Edit Report')}}
            </a>
        @endcan
        @can('sign_medical_report')
            <a class="dropdown-item" href="{{route('admin.medical_reports.sign',$group['id'])}}">
               <i class="fas fa-signature" aria-hidden="true"></i>
               {{__('Sign Report')}}
            </a>
        @endcan
        @can('view_medical_report')
            <a style="cursor: pointer" data-toggle="modal" data-target="#print_barcode_modal{{$group['id']}}" class="dropdown-item print_barcode" group_id="{{$group['id']}}">
                <i class="fa fa-barcode" aria-hidden="true"></i>
                {{__('Print barcode')}}
            </a>
            <a class="dropdown-item" href="{{route('admin.medical_reports.print_report',$group['id'])}}" target="_blank">
                <i class="fa fa-print" aria-hidden="true"></i>
                {{__('Print')}}
            </a>

            <a class="dropdown-item" href="{{route('admin.medical_reports.print_report_2',$group['id'])}}" target="_blank">
                <i class="fa fa-print" aria-hidden="true"></i>
                {{__('Print_WithoutHeaders')}}
            </a>

            <a class="dropdown-item" href="{{route('admin.medical_reports.show',$group['id'])}}">
                <i class="fa fa-eye" aria-hidden="true"></i>
                {{__('Show')}}
            </a>
            @if($whatsapp['report']['active']&&isset($group['report_pdf']))
                <a target="_blank" href="{{whatsapp_notification($group,'report')}}" class="dropdown-item" target="_blank">
                    <i class="fab fa-whatsapp" aria-hidden="true" class="text-success"></i>
                    {{__('Send receipt by WA')}}
                </a>
            @endif
            @if($email['report']['active']&&isset($group['report_pdf']))
                <form action="{{route('admin.medical_reports.send_report_mail',$group['id'])}}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="fa fa-envelope" aria-hidden="true" class="text-success"></i>
                    {{__('Send receipt by mail')}}
                </button>
                </form>
            @endif
        @endcan

        @can('delete_group')
          <form method="POST" action="{{route('admin.medical_reports.destroy',$group['id'])}}" class="d-inline">
             <input type="hidden" name="_method" value="delete">
             <a href="#" class="dropdown-item delete_medical_report">
                <i class="fa fa-trash"></i>
                {{__('Delete')}}
             </a>
          </form>
       @endcan
    </div>
</div>

@php

// get group by id
$group = \App\Models\Group::find($group['id']);

@endphp

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
               <button type="submit" class="btn btn-primary">{{__('Print')}}</button>
            </div>
         </form>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
