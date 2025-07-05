<div class="row">
     <div class="col-lg-12">
         <div class="form-group">
             <label class="form-label" for="type">{{__('Status')}}</label>
             <select  class="form-control" name="type" id="type" required >
                 <option selected disabled>{{__('Status')}}</option>
                 <option value="0">{{__('Start')}}</option>
                 <option value="1">{{__('End')}}</option>
             </select>
             
         </div>
     </div>
 </div>
 <div class="row">
     <div class="col-lg-12">
     <!-- Payments -->
             <div class="card">
               <div class="card-header">
                   <div class="row">
                       <div class="col-lg-12">
                           <h5 class="card-title">
                               {{__('Payments')}}
                           </h5>
                           <button type="button" class="btn btn-primary d-inline float-right" id="add_payment">
                               <i class="fa fa-plus"></i> {{__('Payment')}}
                           </button>
                       </div>
                   </div>
               </div>
               <div class="card-body">
                   <div class="row">
                       <div class="col-lg-12 table-responsive">
                           @php
                               $payments_count=0;
                           @endphp
                           <table class="table table-striped table-bordered" id="payments_table">
                               <thead>
                                   <th width="30%">{{__('Date')}}</th>
                                   <th width="30%">{{__('Amount')}}</th>
                                   <th>{{__('Payment method')}}</th>
                                   <th width="10px"></th>
                               </thead>
                               <tbody>
                               </tbody>
                           </table>
                           <input type="hidden" id="payments_count" value="{{$payments_count}}">
                       </div>
                   </div>
               </div>
           </div>
           <!--\Payments -->
     </div>          
</div>
