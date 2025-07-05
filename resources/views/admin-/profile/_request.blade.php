<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label class="form-label" for="type">{{__('Request Type')}}</label>
            <select  class="form-control" name="type" id="type" required >
                <option selected disabled>{{__('Request Type')}}</option>
                <option value="0">{{__('Permission')}}</option>
                <option value="1">{{__('Vocation')}}</option>
            </select>
            
        </div>
    </div>

</div>
<div id="select_time" class="row">

</div>
<div class="row">

</div>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label class="form-label" for="notes">{{__('Notes')}}</label>
            <input type="text" class="form-control" name="notes" id="notes" >
        </div>
    </div>
</div>
<div class="card-footer">
    <div class="col-lg-12">
        <button type="submit" class="btn btn-primary">
          <i class="fa fa-check"></i>  {{__('Send')}}
        </button>
    </div>
</div>