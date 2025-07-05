
<div id="incentives">
    {{-- @if(isset($incentives))
        @foreach($incentives as $incentive)
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label" for="Type">{{__('Type')}}</label>
                    <select name="incentives[type][]" class="form-control">
                        <option value="monthly">Monthly</option>
                        <option value="quarter">Quarter</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label" for="Target">{{__('Target')}}</label>
                    <input type="number"  class="form-control" placeholder="{{__('Target')}}" name="incentives[target][]"  id="Target" required> @if(isset($penlatiy->reason)) {{$penlatiy->reason}} @endif >
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label" for="Precentage">{{__('Precentage')}}</label>
                    <input type="number"  class="form-control" placeholder="{{__('Precentage')}}" name="incentives[Precentage][]"  id="Precentage" required> @if(isset($penlatiy->reason)) {{$penlatiy->reason}} @endif >
                </div>
            </div>


            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label" for="Precentage">{{__('Precentage')}}</label>
                    <input type="number"  class="form-control" placeholder="{{__('Precentage')}}" name="incentives[Precentage][]"  id="Precentage" required> @if(isset($penlatiy->reason)) {{$penlatiy->reason}} @endif >
                </div>
            </div>

            <div class="col-sm-2 mt-4">
                <input type="button"  class="btn-danger btn-sm removePenlaity" value="{{__('remove_Penality')}}">
            </div>
        </div>
        @endforeach
    @endif --}}


    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="Type">{{__('Type')}}</label>
                <select name="incentives[0][type]" class="form-control">
                    <option @if(isset($incentive)) @if($incentive->type=='monthly') selected @endif @endif value="monthly">Monthly</option>
                    <option @if(isset($incentive)) @if($incentive->type=='quarter') selected @endif @endif value="quarter">Quarter</option>
                </select>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="Target">{{__('Target')}}</label>
                <input type="number" @if(isset($incentive)) value="{{$incentive->target}}" @endif class="form-control" placeholder="{{__('Target')}}" name="incentives[0][target]"  id="Target" required>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="Precentage">{{__('Precentage')}}</label>
                <input type="number" min="1" @if(isset($incentive)) value="{{$incentive->precentage}}" @endif max="100"  class="form-control" placeholder="{{__('Precentage')}}" name="incentives[0][Precentage]"  id="Precentage" required>
            </div>
        </div>
    </div>
</div>
