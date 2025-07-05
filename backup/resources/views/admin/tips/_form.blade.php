<div class="row">



    <div class="col-lg-12">

        <div class="row">

            <div class="col-lg-12">
                <div class="form-group">
                    <label for="">{{__('Select Type')}}</label>
                    <div class="input-group mb-3">
                        <select class="form-control" name="type" id="type">
                            <option value="">{{__('Select Type')}}</option>
                            <option value="tips" {{ isset($tip) && $tip->type == 'tips' ? 'selected' : '' }}>{{ __('Tips') }}</option>
                            <option value="offer" {{ isset($tip) && $tip->type == 'offer' ? 'selected' : '' }}>{{ __('Offer') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">{{__('Title AR')}}</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="{{__('Title AR')}}" name="title_ar" id="title_ar" @if(isset($tip)) value="{{$tip->title_ar}}" @elseif(old('title_ar')) value="{{old('title_ar')}}" @endif>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">{{__('Title EN')}}</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="{{__('Title EN')}}" name="title_en" id="title_en" @if(isset($tip)) value="{{$tip->title_en}}" @elseif(old('title_en')) value="{{old('title_en')}}" @endif>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">{{__('Description AR')}}</label>
                    <div class="input-group mb-3">
                        <textarea class="form-control" placeholder="{{__('Description AR')}}" name="description_ar" id="description_ar">@if(isset($tip)) {{$tip->description_ar}} @elseif(old('description_ar')) {{old('description_ar')}} @endif</textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">{{__('Description EN')}}</label>
                    <div class="input-group mb-3">
                        <textarea class="form-control" placeholder="{{__('Description AR')}}" name="description_en" id="description_en">@if(isset($tip)) {{$tip->description_en}} @elseif(old('description_en')) {{old('description_en')}} @endif</textarea>
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
                        <a href="@if(!empty($tip['image'])){{url('uploads/tips-avatar/'.$tip['image'])}}@else{{url('img/avatar.png')}}@endif" data-toggle="lightbox" data-title="Avatar">
                            <img src="@if(!empty($tip['image'])){{url('uploads/tips-avatar/'.$tip['image'])}}@else{{url('img/avatar.png')}}@endif" class="img-thumbnail" id="patient_avatar" alt="">
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>