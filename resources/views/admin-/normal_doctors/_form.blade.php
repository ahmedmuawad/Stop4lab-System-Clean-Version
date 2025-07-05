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

  <div class="row">

    <div class="col-lg-12">
        <div class="form-group">
            <div class="input-group mb-6">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-envelope"></i>
                  </span>
                </div>
                <input type="text" class="form-control" placeholder="{{__('Email Address')}}" name="email" id="email" @if(isset($doctor->email)) value="{{$doctor->email}}" @endif>
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
                  <i class="fas fa-phone-alt"></i>
                </span>
              </div>
              <input type="text" class="form-control" placeholder="{{__('Phone number')}}" name="phone" id="phone"  @if(isset($doctor->phone)) value="{{$doctor->phone}}" @endif>
          </div>
      </div>
    </div>
  </div>

  <div class="row">

    <div class="col-lg-12">
        <div class="form-group">
            <div class="form-group">
                <div class="input-group mb-6">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">
                        <i class="fas fa-map-marker-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="{{__('Address')}}" name="address" id="address" @if(isset($doctor->address)) value="{{$doctor->address}}" @endif>
                </div>
            </div>
        </div>
    </div>
  </div>

  <div class="row">

    <div class="col-lg-12">
      <div class="form-group">
          <div class="form-group">
              <div class="input-group mb-6">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                      <i class="fas fa-percentage"></i>
                    </span>
                  </div>
                  <input type="number" class="form-control" placeholder="{{__('Commission')}}" name="commission" id="commission" @if(isset($doctor->commission)) value="{{$doctor->commission}}" @endif min="0" max="100" required>
              </div>
          </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="form-group">
          <div class="form-group">
              <div class="input-group mb-6">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                      <i class="fas fa-percentage"></i>
                    </span>
                  </div>
                  <input type="password" class="form-control" placeholder="{{__('Password')}}" name="password" id="password" minlength="6">
              </div>
          </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3">
      <div class="form-group d-flex ">
          <input type="checkbox" name="convert" id="convert">
          <label for="convert" class="mx-3"> {{__('Convert')}}</label>
      </div>
    </div>
  </div>
      
 </div>