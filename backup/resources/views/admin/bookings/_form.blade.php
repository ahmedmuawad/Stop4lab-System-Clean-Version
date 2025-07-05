<div class="row">



    <div class="col-lg-12">

        <div class="row">


            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">{{__('Title AR')}}</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="{{__('Title AR')}}" name="title_ar" id="title_ar" @if(isset($slider)) value="{{$slider->title_ar}}" @elseif(old('title_ar')) value="{{old('title_ar')}}" @endif>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">{{__('Title EN')}}</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="{{__('Title EN')}}" name="title_en" id="title_en" @if(isset($slider)) value="{{$slider->title_en}}" @elseif(old('title_en')) value="{{old('title_en')}}" @endif>
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
                        <a href="@if(!empty($slider['image'])){{url('uploads/sliders-avatar/'.$slider['image'])}}@else{{url('img/avatar.png')}}@endif" data-toggle="lightbox" data-title="Avatar">
                            <img src="@if(!empty($slider['image'])){{url('uploads/sliders-avatar/'.$slider['image'])}}@else{{url('img/avatar.png')}}@endif" class="img-thumbnail" id="patient_avatar" alt="">
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>