@extends("layouts.app")
@section("style")
<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection
@section("wrapper")
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Invoices</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Invoices</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
                            <a href="{{ url('/reception/invoices/create') }}" type="button" class="btn btn-primary">New Patient Registeration</a>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->

                <div class="card">
					<div class="card-body" style="background: #fff;">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th><input type="checkbox" class="bulk_checkbox"></th>
										<th>#</th>
										<th>P.Code</th>
										<th>P.Name</th>
										<th>Action</th>
										<th>Total</th>
										<th>Paid</th>
										<th>Delayed</th>
										<th>Date</th>
										<th>Branch</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<tr>
                                        <th><input type="checkbox" class="bulk_checkbox"></th>
										<td>1</td>
										<td>5267</td>
										<td>Ahmed Muawad Ahmed</td>
										<td><div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-cog bx-spin"></i></button>
                                            <ul class="dropdown-menu" style="">
                                                <li><a class="dropdown-item" href="{{ url('/reception/invoices/edit') }}">Edit</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Samples Receipt</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Print Barcode</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Print Working Paper</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Print Receipt</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Print Invoice</a>
                                                </li>
                                                <li><a class="dropdown-item" href="{{ url('/reception/invoices/view') }}">Show Invoice</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Send Invoice</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Delete</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Invoice Cycle</a>
                                                </li>
                                            </ul>
                                        </div></td>
										<td>1000</td>
										<td>500</td>
										<td>200</td>
										<td>28/12/2022</td>
										<td>Main Branch</td>
										<td>
                                            <div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Done</div>
                                        </td>
									</tr>
									<tr>
                                        <th><input type="checkbox" class="bulk_checkbox"></th>
										<td>3</td>
										<td>5983</td>
										<td>Nour Eldein Osama</td>
										<td><div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-cog bx-spin"></i></button>
                                            <ul class="dropdown-menu" style="">
                                                <li><a class="dropdown-item" href="{{ url('/reception/invoices/edit') }}">Edit</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Samples Receipt</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Print Barcode</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Print Working Paper</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Print Receipt</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Print Invoice</a>
                                                </li>
                                                <li><a class="dropdown-item" href="{{ url('/reception/invoices/view') }}">Show Invoice</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Send Invoice</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Delete</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Invoice Cycle</a>
                                                </li>
                                            </ul>
                                        </div></td>
										<td>1000</td>
										<td>500</td>
										<td>200</td>
										<td>28/12/2022</td>
										<td>Main Branch</td>
										<td><div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Done</td>
									</tr>
									<tr>
                                        <th><input type="checkbox" class="bulk_checkbox"></th>
										<td>2</td>
										<td>5264</td>
										<td>Mohamed Hassan</td>
										<td><div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-cog bx-spin"></i></button>
                                            <ul class="dropdown-menu" style="">
                                                <li><a class="dropdown-item" href="{{ url('/reception/invoices/edit') }}">Edit</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Samples Receipt</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Print Barcode</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Print Working Paper</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Print Receipt</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Print Invoice</a>
                                                </li>
                                                <li><a class="dropdown-item" href="{{ url('/reception/invoices/view') }}">Show Invoice</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Send Invoice</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Delete</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Invoice Cycle</a>
                                                </li>
                                            </ul>
                                        </div></td>
										<td>1000</td>
										<td>500</td>
										<td>200</td>
										<td>27/12/2022</td>
										<td>Main Branch</td>
										<td><div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3" style="background: #8833ff !important;"><i class="bx bxs-circle align-middle me-1"></i>Pending</div></td>
									</tr>
                                    <tr>
                                        <th><input type="checkbox" class="bulk_checkbox"></th>
										<td>4</td>
										<td>5628</td>
										<td>Rehab Farid</td>
										<td><div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-cog bx-spin"></i></button>
                                            <ul class="dropdown-menu" style="">
                                                <li><a class="dropdown-item" href="{{ url('/reception/invoices/edit') }}">Edit</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Samples Receipt</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Print Barcode</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Print Working Paper</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Print Receipt</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Print Invoice</a>
                                                </li>
                                                <li><a class="dropdown-item" href="{{ url('/reception/invoices/view') }}">Show Invoice</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Send Invoice</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Delete</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Invoice Cycle</a>
                                                </li>
                                            </ul>
                                        </div></td>
										<td>1000</td>
										<td>500</td>
										<td>200</td>
										<td>29/12/2022</td>
										<td>Main Branch</td>
										<td><div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3" style="background: #8833ff !important;"><i class="bx bxs-circle align-middle me-1"></i>Pending</div></td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
                                        <th><input type="checkbox" class="bulk_checkbox"></th>
										<th>#</th>
										<th>P.Code</th>
										<th>P.Name</th>
										<th>Action</th>
										<th>Total</th>
										<th>Paid</th>
										<th>Delayed</th>
										<th>Date</th>
										<th>Branch</th>
										<th>Status</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
    </div>
</div>
@endsection
@section("script")
<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
      } );
</script>
<script>
    $(document).ready(function() {
        alert("tab-content");
        var table = $('#example2').DataTable( {
            lengthChange: false,
            buttons: [ 'copy', 'excel', 'pdf', 'print']
        } );
        
        $('.tab-content').css('height' , 'auto !important');
        $('.search-tabs').css('height' , 'auto !important');
        $('.search-tabs').height('auto !important');
        table.buttons().container()
            .appendTo( '#example2_wrapper .col-md-6:eq(0)' );
    } );
    
</script>
@endsection


