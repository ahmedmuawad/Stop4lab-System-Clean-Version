<div class="row">

    @php

    $supplier = \App\Models\Supplier::all();
    $branches = \App\Models\Branch::all();

    @endphp

    <div class="col-lg-12">

        <div class="row">


            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">{{__('Name')}}</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="{{__('Name')}}" name="name" id="name" @if(isset($fixed_asset)) value="{{$fixed_asset->name}}" @elseif(old('name')) value="{{old('name')}}" @endif>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">{{__('Price')}}</label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" placeholder="{{__('Price')}}" name="price" id="price" @if(isset($fixed_asset)) value="{{$fixed_asset->price}}" @elseif(old('price')) value="{{old('price')}}" @endif>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">{{__('Branche')}}</label>
                    <div class="input-group mb-3">
                        <select name="branche_id" id="branche_id" class="form-control">
                            <option value="">{{__('Select Branche')}}</option>
                            @foreach($branches as $branche)
                            <option value="{{$branche->id}}" @if(isset($fixed_asset) && $fixed_asset->branche_id == $branche->id) selected @endif>{{$branche->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- supplier_id -->
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">{{__('Supplier')}}</label>
                    <div class="input-group mb-3">
                        <select name="supplier_id" id="supplier_id" class="form-control">
                            <option value="">{{__('Select Supplier')}}</option>
                            @foreach($supplier as $supplier)
                            <option value="{{$supplier->id}}" @if(isset($fixed_asset) && $fixed_asset->supplier_id == $supplier->id) selected @endif>{{$supplier->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="col-lg-12">

        <div class="card card-primary">
            <div class="card-header">
                <h5 class="text-center m-0 p-0">
                    {{__('Image')}}
                </h5>
            </div>
            <div class="card-footer m-0 p-0 pt-3">
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="avatar" class="custom-file-input" id="avatar">
                                <label class="custom-file-label">{{__('Choose Image')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body m-0 p-0">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <a href="@if(!empty($fixed_asset['image'])){{url('uploads/fixed_assets-avatar/'.$fixed_asset['image'])}}@else{{url('img/avatar.png')}}@endif" data-toggle="lightbox" data-title="Avatar">
                            <img src="@if(!empty($fixed_asset['image'])){{url('uploads/fixed_assets-avatar/'.$fixed_asset['image'])}}@else{{url('img/avatar.png')}}@endif" class="img-thumbnail" id="patient_avatar" alt="">
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>