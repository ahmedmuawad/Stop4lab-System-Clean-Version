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

@php
    $consumption_count = 0;
@endphp
<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title">
                    {{ __('Consumptions') }}
                </h5>
                <button type="button" class="btn btn-primary float-right add_consumption">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('Product') }}</th>
                            <th width="100px">{{ __('Quantity') }}</th>
                            <th width="10px"></th>
                        </tr>
                    </thead>
                    <tbody class="test_consumptions">
                        @if (isset($test))
                            @foreach ($test['consumptions'] as $consumption)
                                @php
                                    $consumption_count++;
                                @endphp
                                <tr class="consumption_row">
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control product_id"
                                                id="consumption_product_{{ $consumption_count }}"
                                                name="consumptions[{{ $consumption_count }}][product_id]" required>
                                                <option value="{{ $consumption['product_id'] }}" selected>
                                                    {{ $consumption['product'] ? $consumption['product']['name'] : '' }}</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" class="form-control"
                                                name="consumptions[{{ $consumption_count }}][quantity]"
                                                placeholder="{{ __('Quantity') }}"
                                                value="{{ $consumption['quantity'] }}" required>
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

<input type="hidden" id="consumption_count" value="{{ $consumption_count }}">
 
 