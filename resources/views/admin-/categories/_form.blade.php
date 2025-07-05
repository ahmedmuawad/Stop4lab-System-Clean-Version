<div class="row">
    <div class="col-lg-12">
        <label for="name">{{__('Name')}}</label>
        <input type="text" class="form-control" placeholder="{{__('Name')}}" name="name" @if(isset($category)) value="{{$category['name']}}" @endif required>
    </div>
    {{-- <div class="col-lg-6">
        <label for="name">{{__('Parent')}}</label>
        <select class="form-control select2" name="parent_id">
            <option value=""></option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"> {{ $category->name }}</option>
            @endforeach
        </select>
    </div> --}}
</div>