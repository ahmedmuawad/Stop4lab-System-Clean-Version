<div class="row">
    {{-- <div class="col-lg-4">
        <div class="form-group">
            <label class="form-label" for="login-name">{{__('Name')}}</label>
            <select name="user_id" id="user_id" placeholder="{{__('Branches')}}" class="form-control select2" required>
                <option value="" disabled selected>{{__('Employee')}}</option>
                @foreach($users as $user)
                     <option @if(isset($employee)) @if($employee->user_id == $user['id']) selected @endif @endif  value="{{$user['id']}}">{{$user['name']}}</option>
                @endforeach
            </select>
        </div>
    </div> --}}

    {{-- {{$employee}} --}}

    <div class="col-lg-4">
        <div class="form-group">
            <label class="form-label" for="Name">{{__('Service Name')}}</label>
            <input type="text" class="form-control" placeholder="{{__('Name')}}" name="Name" id="Name" @if(isset($extraService)) value="{{$extraService->name}}" @endif required>
        </div>
    </div>


     <div class="col-lg-4">
        <div class="form-group">
            <label class="form-label" for="Description">{{__('Service Description')}}</label>
            <textarea class="form-control" placeholder="{{__('Description')}}" name="Description" id="Description" required>@if(isset($extraService)) {{$extraService->descript}} @endif </textarea>
        </div>
    </div>


    <div class="col-lg-4">
        <div class="form-group">
            <label class="form-label" for="Price">{{__('Service Price')}}</label>
            <input type="number" min="1"  class="form-control" placeholder="{{__('Price')}}" name="Price" id="Price" @if(isset($extraService)) value="{{$extraService->price}}" @endif required>
        </div>
    </div>

</div>
