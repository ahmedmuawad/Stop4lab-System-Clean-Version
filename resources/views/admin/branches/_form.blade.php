<div class="row">
    <div class="col-lg-3">
       <div class="form-group">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">
                    <i  class="fas fa-map-marked-alt nav-icon"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('Branch name')}}" name="name" id="name" @if(isset($branch)) value="{{$branch->name}}" @endif required>
        </div>
       </div>
    </div>

    

    <div class="col-lg-3">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-phone-alt"></i>
                  </span>
                </div>
                <input type="text" class="form-control" placeholder="{{__('Phone number')}}" name="phone" id="phone" @if(isset($branch)) value="{{$branch->phone}}" @endif required>
            </div>
        </div>
    </div>


    
    <div class="col-lg-3">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="country">
                    <i class="fas fa-map-marker-alt"></i>
                  </span>
                </div>
                <input type="text" class="form-control" placeholder="{{__('country')}}" name="country" id="country" @if(isset($branch)) value="{{$branch->country}}" @endif required>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="gov">
                    <i class="fas fa-map-marker-alt"></i>
                  </span>
                </div>
                <input type="text" class="form-control" placeholder="{{__('gov')}}" name="gov" id="gov" @if(isset($branch)) value="{{$branch->gov}}" @endif required>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="city">
                    <i class="fas fa-map-marker-alt"></i>
                  </span>
                </div>
                <input type="text" class="form-control" placeholder="{{__('city')}}" name="city" id="city" @if(isset($branch)) value="{{$branch->city}}" @endif required>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="street">
                    <i class="fas fa-map-marker-alt"></i>
                  </span>
                </div>
                <input type="text" class="form-control" placeholder="{{__('street')}}" name="street" id="street" @if(isset($branch)) value="{{$branch->street}}" @endif required>
            </div>
        </div>
    </div>


    <div class="col-lg-3">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="building">
                    <i class="fas fa-map-marker-alt"></i>
                  </span>
                </div>
                <input type="text" class="form-control" placeholder="{{__('building')}}" name="building" id="building" @if(isset($branch)) value="{{$branch->building}}" @endif required>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-map-marker-alt"></i>
                  </span>
                </div>
                <input type="text" class="form-control" placeholder="{{__('Address')}}" name="address" id="address" @if(isset($branch)) value="{{$branch->address}}" @endif required>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                    <i class="nav-icon fas fa-flask"></i>
                  </span>
                </div>
                <select name="ray_status" class="form-control">
                    <option value="0" @if(isset($branch) && $branch->ray_status == 0) selected @endif >{{ __('Without Rays') }}</option>
                    <option value="1" @if(isset($branch) && $branch->ray_status == 1) selected @endif>{{ __('With Rays') }}</option>
                </select>
            </div>
        </div>
    </div>

</div>


<div class="row">
   <div class="col-lg-12">
        <div class="card card-danger">
            <div class="card-header">
                <h5 class="card-title">
                    <i  class="fas fa-map-marked-alt nav-icon"></i>
                    {{__('Location on map')}}
                </h5>
            </div>
            <div class="card-body p-0">
                <input type="hidden" name="lat" id="branch_lat" @if(isset($branch)) value="{{$branch['lat']}}" @endif>
                <input type="hidden" name="lng" id="branch_lng" @if(isset($branch)) value="{{$branch['lng']}}" @endif>
                <input type="hidden" name="zoom_level" id="zoom_level" @if(isset($branch)) value="{{$branch['zoom_level']}}" @endif>
                <div id="map" style="min-height:500px"></div>
            </div>
        </div>
   </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{__('Product')}}</th>
                    <th width="150px">{{__('Initial quantity')}}</th>
                    <th width="150px">{{__('Stock alert')}}</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($branch))
                    @foreach($branch['products'] as $product)
                        @if (isset($product['product']))
                           <tr>
                                <td>
                                    {{$product['product']['name']}}
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="products[{{$product['product_id']}}][initial_quantity]" id="product_initial_quantity_{{$product['product_id']}}" value="{{$product['initial_quantity']}}" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control"  name="products[{{$product['product_id']}}][alert_quantity]" id="product_alert_quantity_{{$product['product_id']}}" value="{{$product['alert_quantity']}}" required>
                                </td>
                            </tr> 
                        @endif
                    @endforeach
                @else
                    @foreach($products as $product)
                        <tr>
                            <td>
                                {{$product['name']}}
                            </td>
                            <td>
                                <input type="number" class="form-control"  name="products[{{$product['id']}}][initial_quantity]" id="branch_initial_quantity_{{$product['id']}}" value="0" required>
                            </td>
                            <td>
                                <input type="number" class="form-control"  name="products[{{$product['id']}}][alert_quantity]" id="branch_alert_quantity_{{$product['id']}}" value="0" required>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
