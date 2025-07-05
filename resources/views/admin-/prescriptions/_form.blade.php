<div class="row">



    <div class="col-lg-12">

        <div class="row">


            <div class="col-lg-12">
                <div class="form-group">
                    <label for="">{{__('Price')}}</label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" placeholder="{{__('Price')}}" name="price" id="price" @if(isset($prescription)) value="{{$prescription->price}}" @elseif(old('price')) value="{{old('price')}}" @endif>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>