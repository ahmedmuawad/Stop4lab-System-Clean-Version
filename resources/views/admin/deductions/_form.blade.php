
<div id="incentives" >
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="Name">{{__('Name')}}</label>
                <input type="text" @if(isset($deduction)) value="{{$deduction->name}}" @endif class="form-control" placeholder="{{__('Name')}}" name="name"  id="name" required>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="Type">{{__('Type')}}</label>
                <select class="form-control" name="type" id="deductionType">
                    <option selected>{{"None"}}</option>
                    <option @if(isset($deduction)) @if($deduction->type=='fixed') selected @endif @endif  value="fixed">{{__('fixed')}}</option>
                    <option @if(isset($deduction)) @if($deduction->type=='flexable') selected @endif @endif value="flexable">{{__('flexable')}}</option>
                </select>
            </div>
        </div>
    </div>
</div>