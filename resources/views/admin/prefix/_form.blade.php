<div class="row">
    <div class="col-lg-6">
        <label for="name">{{__('Prefix')}}</label>
        <input type="text" class="form-control" placeholder="{{__('Prefix')}}" name="name" @if(isset($prefix)) value="{{$prefix['name']}}" @endif required>
    </div>

    <div class="col-lg-6">
        <label for="gender">{{__('Prefix')}}</label>
        <select class="form-control"  name="gender">
            <option value="male" 
           @if( isset($prefix))
                @if($prefix->gender=='male')
                    selected
                @endif
           @endif
            )>{{__('Male')}}</option>
            <option value="female"
            @if( isset($prefix))
                @if($prefix->gender=='female')
                    selected
                @endif
           @endif
            >{{__('Female')}}</option>
            <option value="pregnant"
            @if( isset($prefix))
                @if($prefix->gender=='pregnant')
                    selected
                @endif
           @endif
            >{{__('Others')}}</option>

        </select>

        <!-- <input type="text"  placeholder="{{__('Prefix')}}" @if(isset($prefix)) value="{{$prefix['name']}}" @endif required> -->
    </div>
</div>
