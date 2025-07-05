<div class="row">
    <div class="col-lg-3">
     <div class="form-group">
      <label for="category">{{__('Category')}}</label>
        
        <button type="button" class="btn btn-warning btn-sm float-right" data-toggle="modal" data-target="#category_modal">
            <i class="fa fa-info-circle"></i>
            {{__('Not Listed ?')}}
        </button>

        @if(isset($expense)&&isset($expense['category']))
          <input type="hidden" value="{{$expense['expense_category_id']}}" id="expense_category_id">
        @endif

        <select name="expense_category_id" id="category" class="form-control select2" required>
            <option value="" value=""></option>
            @if(isset($expense['category'])&&!$expense_categories->contains('id',$expense['expense_category_id']))
                <option value="{{$expense['category']['id']}}">{{$expense['category']['name']}}</option>
            @endif
            @foreach($expense_categories as $category)
                <option value="{{$category['id']}}">{{$category['name']}}</option>
            @endforeach
        </select>
     </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
         <label for="name">{{__('Date')}}</label>
         <input type="date" class="form-control" name="date" @if(isset($expense)) value="{{$expense->date}}" @endif  required>
        </div>
    </div>

    {{-- <div class="col-lg-3">
        <div class="form-group">
         <label for="name">{{__('Doctor')}}</label>
         <select class="form-control" name="doctor_id" id="doctor">
            @if(isset($expense)&&isset($expense['doctor']))
                <option value="{{$expense['doctor']['id']}}" selected>{{$expense['doctor']['name']}}</option>
            @endif
         </select>
        </div>
    </div> --}}

    <div class="col-lg-3">
       <div class="form-group">
        <label for="amount">{{__('Amount')}}</label>
        <input type="number" class="form-control" name="amount" id="amount" min="0"  @if(isset($expense)) value="{{$expense->amount}}" @endif required>
       </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
         <label for="name">{{__('Payment method')}}</label>
         <select class="form-control" name="payment_method_id" id="payment_method" required>
            @if(isset($expense)&&isset($expense['payment_method']))
                <option value="{{$expense['payment_method']['id']}}" selected>{{$expense['payment_method']['name']}}</option>
            @endif
         </select>
        </div>
    </div>

</div>
@if (auth()->guard('admin')->user()->roles[0]->role_id == 1)    
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
            <label for="name">{{__('Source')}}</label>
            <select class="form-control" name="source" id="source" required>

                <option value="1">{{ __('Bank') }}</option>
                <option value="2">{{ __('From Lab') }}</option>
                <option value="3">{{ __('Main Safe') }}</option>
                <option value="4">{{ __('branch safe') }}</option>
                <option value="5">{{ __('Custody') }}</option>
                
            </select>
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="notes">{{__('Notes')}}</label>
            <textarea name="notes" id="notes" cols="30" rows="5" class="form-control" required>@if(isset($expense)){{$expense->notes}}@endif </textarea>
        </div>
    </div>
</div>

