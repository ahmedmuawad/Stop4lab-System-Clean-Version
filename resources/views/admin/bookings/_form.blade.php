<div class="row">



    {{-- <div class="col-lg-12">

        <div class="row">


            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">{{__('Title AR')}}</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="{{__('Title AR')}}" name="title_ar" id="title_ar" @if(isset($booking)) value="{{$booking->title_ar}}" @elseif(old('title_ar')) value="{{old('title_ar')}}" @endif>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">{{__('Title EN')}}</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="{{__('Title EN')}}" name="title_en" id="title_en" @if(isset($booking)) value="{{$booking->title_en}}" @elseif(old('title_en')) value="{{old('title_en')}}" @endif>
                    </div>
                </div>
            </div>

        </div>

    </div> --}}

    <div class="col-lg-12">

        <div class="card card-primary">
            <div class="card-header">
                <h5 class="text-center m-0 p-0">
                    {{__('Image')}}
                </h5>
            </div>

            <div class="card-body m-0 p-0">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <img src="@if(!empty($booking['image'])){{url('uploads/booking/'.$booking['image'])}}@else{{url('img/avatar.png')}}@endif" class="img-thumbnail" id="patient_avatar" alt="">

                    </div>
                </div>
            </div>

        </div>

    </div>

</div>