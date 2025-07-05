<div class="row">
    <div class="col-lg-12">
        <label for="name">{{ __('Branch From') }}</label>
        <input type="hidden" class="form-control" name="from_branch_id" value="{{ session('branch_id') }}">
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <label for="name">{{ __('Branch To') }}</label>
        <select name="to_branch_id" class="form-control select2" required>
            <option value="{{ setting("account")['branch'] }}">{{ __('Main Branch') }}</option>
            <option value="{{ session('branch_id') }}">{{ __('Branch Safe') }}</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <label>{{ __('Date range') }}:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
            <input type="text" name="date" class="form-control float-right datepickerrange" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
    <!-- Payments -->
            <div class="card">
              <div class="card-header">
                  <div class="row">
                      <div class="col-lg-12">
                          <h5 class="card-title">
                              {{__('Payments')}}
                          </h5>
                      </div>
                  </div>
              </div>
              <div class="card-body">
                  <div class="row">
                      <div class="col-lg-12 table-responsive">
                          @php
                              $payments_count=0;
                          @endphp
                          <table class="table table-striped table-bordered" id="">
                              <thead>
                                  <th width="30%">{{__('Date')}}</th>
                                  <th width="30%">{{__('Amount')}}</th>
                                  <th>{{__('Payment method')}}</th>
                              </thead>
                              <tbody>
                                    @foreach (get_safe_obj() as $safe)
                                        <input type="hidden" name="safe_id[]" value="{{ $safe->id }}">
                                        @foreach ($safe->payments as $payment)         
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control amount"   value="{{  $payment->created_at }}" required readonly>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control amount" name="payments[{{ $payment['id'] }}][amount]"  value="{{  $payment->amount }}" required readonly>
                                                </td>
                                                
                                                <td>
                                                    <input type="text" class="form-control amount" name="payments[{{ $payment['id'] }}][payment_method_id]"  value="{{ $payment->payment_method->name }}" required readonly>
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                    @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
          <!--\Payments -->
    </div>          
</div>
