<div class="card-body">
     @csrf
     <div class="row">
        <div class="col-lg-12">
           <div class="form-group">
            <div class="input-group mb-6">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                      <i class="fa fa-user"></i>
                  </span>
                </div>
                <input type="text" class="form-control" placeholder="{{__('Doctor Name')}}" name="name" id="name" @if(isset($doctor)) value="{{$doctor->name}}" @endif required>
            </div>
           </div>
        </div>
   </div>
   <div class="row">
        <div class="col-lg-12">
          <div class="form-group">
           <div class="input-group mb-6">
               <div class="input-group-prepend">
                 <span class="input-group-text" id="basic-addon1">
                     <i class="fa fa-user"></i>
                 </span>
               </div>
               <input type="text" class="form-control" placeholder="{{__('Specialization')}}" name="code" id="code" @if(isset($doctor)) value="{{$doctor->code}}" @endif>
           </div>
          </div>
       </div>
     
    </div>
      
 </div>