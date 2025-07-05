<div class="row">
    <div class="col-lg-12">
        <label for="name">{{__('Prefix')}}</label>
        <input type="text" class="form-control" placeholder="{{__('Prefix')}}" name="name" @if(isset($prefix)) value="{{$prefix['name']}}" @endif required>
    </div>
</div>
