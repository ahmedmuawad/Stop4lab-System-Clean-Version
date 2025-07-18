@extends('layouts.app')

@section('title')
{{__('Product alerts')}}
@endsection

@section('breadcrumb')
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Product alerts')}}</li>

@endsection

@section('content')
<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title">{{__('Product alerts')}}</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">

    <div class="row table-responsive">
      <div class="col-12">
        <table id="product_alerts_table" class=" table table table-striped table-bordered"  width="100%">
          <thead  >
            <tr>
              <th>{{__('Branch')}}</th>
              <th>{{__('Product')}}</th>
              <th width="150px">{{__('Current quantity')}}</th>
              <th width="150px">{{__('Alert quantity')}}</th>
            </tr>
          </thead>
          <tbody>
                @foreach($product_alerts as $product_alert)
                <tr>
                    <td>
                        {{$product_alert->name}}
                    </td>
                    <td>
                        {{$product_alert->product_name}}
                    </td>
                    <td>
                        {{$product_alert->Qty}}
                    </td>
                    <td>
                        {{$product_alert->stock_alert}}
                    </td>
                </tr>
                @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
</div>

@endsection
@section('scripts')
  <script src="{{url('js/admin/product_alerts.js')}}"></script>
@endsection
