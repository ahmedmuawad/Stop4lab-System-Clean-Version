<div class="row">
    <div class="col-lg-4">
      <div class="form-group">
          <label for="">{{__('Category')}}</label>
          <select name="category_id" class="form-control" id="category" required>
              @if(isset($culture)&&isset($culture['category']))
                  <option value="{{$culture['category_id']}}" selected>{{$culture['category']['name']}}</option>
              @endif
          </select>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="form-group">
        <label for="name">{{__('Name')}}</label>
        <input type="text" class="form-control" name="name" id="name" @if(isset($culture)) value="{{$culture->name}}" @endif required>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="form-group">
        <label for="sample_type">{{__('Sample Type')}}</label>
        <input type="text" class="form-control" name="sample_type" id="sample_type" @if(isset($culture)) value="{{$culture->sample_type}}" @endif required>
      </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="sample_type_id">{{ __('Select Sample Type') }}</label>
            <select name="sample_type_id" class="form-control select2" id="sample_type_id" >
                <option label=""></option>
                @if ($samplesTypes)
                    @foreach ($samplesTypes as $sample)
                        <option value="{{ $sample->id }}" @if( isset($culture) && $sample->id == $culture->sample_type_id) selected @endif>{{ $sample->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-lg-4">
      <div class="form-group">
              <label for="price">{{__('Price')}}</label>
              <div class="input-group form-group mb-3">
              <input type="number" class="form-control" name="price" id="price" min="0" 

                    @if (isset($culture))                  
                        @if(isset($culture_price) && $culture_price!=null) 
                            value="{{$culture_price->price}}" 
                        @else
                            value="{{$culture->price}}"
                        @endif 
                    @endif
                required>
              <div class="input-group-append">
                  <span class="input-group-text">
                      {{get_currency()}}
                  </span>
                </div>
            </div>
      </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
             <label for="num_day_receive">{{__('Lab To Lab Status')}}</label>
             <div class="input-group form-group mb-3">
                 <select name="lab_to_lab_status" class="form-control" id="lab_status">
                     <option value="0" @if(isset($culture)) @if($culture['lab_to_lab_status'] == 0) selected  @endif @endif>{{ __('IN') }}</option>
                     <option value="1" @if(isset($culture)) @if($culture['lab_to_lab_status'] == 1) selected  @endif @endif>{{ __('Out') }}</option>
                 </select>
             </div>
        </div>
     </div>

     <div class="col-lg-4 lab_cost @if (isset($culture)) @if ($culture['lab_to_lab_status'] == 0) d-none @else d-block  @endif  @else d-none @endif">
        <div class="form-group">
            <label for="lab_to_lab_cost">{{__('Lab To Lab Cost')}}</label>
            <div class="input-group form-group mb-3">
                <input type="number" class="form-control" id="lab_to_lab_cost" name="lab_to_lab_cost" @if(isset($culture))value="{{$culture['lab_to_lab_cost']}}" @endif  required>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="num_day_receive">{{ __('Num Day Receive') }}</label>
            <div class="input-group form-group mb-3">
                <input type="number" class="form-control" name="num_day_receive" min="0" step="1"
                    id="num_day_receive" value="{{ isset($culture) ? $culture->num_day_receive : 0 }}" required>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="num_hour_receive">{{ __('Num Hour Receive') }}</label>
            <div class="input-group form-group mb-3">
                <input type="number" class="form-control" name="num_hour_receive" min="0" step="1"
                    id="num_hour_receive" value="{{ isset($culture) ? $culture->num_hour_receive : 1 }}" required>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
             <label for="precautions">{{__('Precautions')}}</label>
             <textarea name="precautions" id="precautions" rows="1" class="form-control" placeholder="{{__('Precautions')}}">@if(isset($culture)){{$culture['precautions']}}@endif</textarea>
        </div>
    </div>
    
</div>

@php 
  $count_comments=0;
@endphp
<div class="row">
  <div class="col-lg-12">
      <div class="card card-primary card-outline">
          <div class="card-header">
              <h5 class="card-title">
                  {{__('Result comments')}}
              </h5>
              <button type="button" class="btn btn-primary float-right add_comment">
                <i class="fa fa-plus"></i>
              </button>
          </div>
          <div class="card-body p-0">
              <div class="row">
                  <div class="col-lg-12 table-responsive">
                      <table class="table table-striped table-bordered" id="comments_table">
                          <thead>
                              <tr>
                                  <th>{{__('Comment')}}</th>
                                  <th width="10px">
                                  </th>
                              </tr>
                          </thead>
                          <tbody>
                              @if(isset($culture))
                                  @foreach($culture['comments'] as $comment)
                                      <tr>
                                          <td>
                                              <div class="form-group">
                                                  <textarea name="comments[{{$count_comments}}]" class="form-control" id="" cols="30" rows="3" required>{{$comment['comment']}}</textarea>
                                              </div>
                                          </td>
                                          <td>
                                              <button type="button" class="btn btn-danger btn-sm delete_comment">
                                                  <i class="fa fa-trash"></i>
                                              </button>
                                          </td>
                                      </tr>
                                      @php 
                                          $count_comments++;
                                      @endphp
                                  @endforeach
                              @endif
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

@php 
    $consumption_count=0
@endphp
<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title">
                    {{__('Consumptions')}}
                </h5>
                <button type="button" class="btn btn-primary float-right add_consumption">
                   <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>{{__('Product')}}</th>
                            <th width="100px">{{__('Quantity')}}</th>
                            <th width="10px"></th>
                        </tr>
                    </thead>
                    <tbody class="test_consumptions">
                      @if(isset($culture))
                        @foreach($culture['consumptions'] as $consumption)
                            @php 
                                $consumption_count++;
                            @endphp
                            <tr class="consumption_row">
                                <td>
                                    <div class="form-group">
                                        <select class="form-control product_id" id="consumption_product_{{$consumption_count}}" name="consumptions[{{$consumption_count}}][product_id]" required>
                                            <option value="{{$consumption['product_id']}}" selected>{{$consumption['product']['name']}}</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="consumptions[{{$consumption_count}}][quantity]" placeholder="{{__('Quantity')}}" value="{{$consumption['quantity']}}" required>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger delete_consumption">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td> 
                            </tr>
                        @endforeach
                      @endif  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="consumption_count" value="{{$consumption_count}}">
<input type="hidden" id="count_comments" value="{{$count_comments}}">
