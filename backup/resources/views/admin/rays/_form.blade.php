<div class="row">
     <div class="col-lg-3">
         <div class="form-group">
             <label for="">{{__('Category')}}</label>
             <select name="category_id" class="form-control" id="category" required>
                 @if(isset($test) && $test['category'])
                     <option value="{{$test['category_id']}}" selected>{{$test['category']['name']}}</option>
                 @endif
             </select>
         </div>
     </div>
     <div class="col-lg-3">
       <div class="form-group">
         <label for="name">{{__('Name')}}</label>
         <input type="text" class="form-control" name="name" id="name" @if(isset($test)) value="{{$test->name}}" @endif required>
       </div> 
     </div>
     <div class="col-lg-3">
       <div class="form-group">
         <label for="shortcut">{{__('Shortcut')}}</label>
         <input type="text" class="form-control" name="shortcut" id="shortcut" @if(isset($test)) value="{{$test->shortcut}}" @endif required>
       </div>
     </div>
     {{-- <div class="col-lg-3">
       <div class="form-group">
         <label for="sample_type">{{__('Sample Type')}}</label>
         <input type="text" class="form-control" name="sample_type" id="sample_type" @if(isset($test)) value="{{$test->sample_type}}" @endif required>
       </div>
     </div> --}}
     <div class="col-lg-3">
        <div class="form-group">
             <label for="price">{{__('Price')}}</label>
             <div class="input-group form-group mb-3">
                 <input type="number" class="form-control" name="price" min="0" id="price" @if(isset($test)) value="{{$test->price}}" @endif required>
                 <div class="input-group-append">
                 <span class="input-group-text">
                     {{get_currency()}}
                 </span>
                 </div>
             </div>
        </div>
     </div>
     <div class="col-lg-3">
        <div class="form-group">
             <label for="num_day_receive">{{__('Num Day Receive')}}</label>
             <div class="input-group form-group mb-3">
                 <input type="number" class="form-control" name="num_day_receive" min="1" step="1" id="num_day_receive" value="{{isset($test) ? $test->num_day_receive : 1 }}" required>
             </div>
        </div>
     </div>
</div>
 
 