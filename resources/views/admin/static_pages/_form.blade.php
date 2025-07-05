<div class="row">


    <div class="col-lg-12">

        <div class="row">
            @foreach($static_pages as $static_page)
            @if($static_page->type == 'number')
            <div class="col-lg-8">
                <div class="form-group">
                    <label for="">{{__($static_page->neckname)}}</label>
                    <div class="input-group mb-3">
                        <input type="{{ $static_page->type }}" class="form-control" placeholder="{{__($static_page->neckname)}}" value="{{ $static_page->value }}" name="{{ $static_page->key }}" id="{{ $static_page->key }}">
                    </div>
                </div>
            </div>
            @elseif($static_page->type == 'text')
            <div class="col-lg-8">
                <div class="form-group">
                    <label for="">{{__($static_page->neckname)}}</label>
                    <div class="input-group mb-3">
                        <input type="{{ $static_page->type }}" class="form-control" placeholder="{{__($static_page->neckname)}}" value="{{ $static_page->value }}" name="{{ $static_page->key }}" id="{{ $static_page->key }}">
                    </div>
                </div>
            </div>
            @elseif($static_page->type == 'textarea')
            <div class="col-lg-8">
                <div class="form-group">
                    <label for="">{{__($static_page->neckname)}}</label>
                    <div class="input-group mb-3">
                        <textarea class="form-control" placeholder="{{__($static_page->neckname)}}" name="{{ $static_page->key }}" id="{{ $static_page->key }}">{{ $static_page->value }}</textarea>
                    </div>
                </div>
            </div>
            @elseif($static_page->type == 'file')
            <div class="col-lg-8">

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
                                        <input type="file" name="{{ $static_page->key }}" class="avatar custom-file-input" id="{{$static_page->key}}">
                                        <label class="custom-file-label">{{__('Choose Image')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body m-0 p-0">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <a href="@if(!empty($static_page->value)){{url($static_page->value)}}@else{{url('img/avatar.png')}}@endif" data-toggle="lightbox" data-title="Avatar">
                                    <img src="@if(!empty($static_page->value)){{url($static_page->value)}}@else{{url('img/avatar.png')}}@endif" class="img-thumbnail" id="{{$static_page->key}}_preview" alt="">
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            @elseif($static_page->type == 'url')
            <div class="col-lg-8">
                <div class="form-group">
                    <label for="">{{__($static_page->neckname)}}</label>
                    <div class="input-group mb-3">
                        <textarea class="form-control" placeholder="{{__($static_page->neckname)}}" name="{{ $static_page->key }}" id="{{ $static_page->key }}">{{ $static_page->value }}</textarea>
                    </div>
                </div>
            </div>
            @endif

            @endforeach



        </div>

    </div>

</div>