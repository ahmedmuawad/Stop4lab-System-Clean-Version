<div class="row">
    <div class="col-lg-12">
        <label for="name">{{__('Name')}}</label>
        <input type="text" class="form-control" placeholder="{{__('Name')}}" name="name" @if(isset($lab_out)) value="{{$lab_out['name']}}" @endif required>
    </div>
</div>