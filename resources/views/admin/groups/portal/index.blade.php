@extends('layouts.app')

@section('title')
    {{ __('Invoices') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Invoices') }}</li>
@endsection
@section('content')
    <section id="advanced-search-datatable">
        <div class="row">

            <div class="col-12">
                @if (\Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li style="list-style: none;font-size:25px">{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
                @endif
                @if (\Session::has('error'))
                <div class="alert alert-danger">
                    <ul>
                        <li style="list-style: none;font-size:25px">{!! \Session::get('error') !!}</li>
                    </ul>
                </div>
                @endif
                <div class="card mt-4">
                    <hr class="my-0">
                    <div class="card-datatable px-2">
                        <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper dt-bootstrap4 table-responsive"
                            style="width:100% !important;">
                            <div class="d-flex justify-content-between align-items-center mx-0 row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="dataTables_length" id="DataTables_Table_2_length">
                                    </div>
                                </div>
                            </div>
                            <table id="groups_table" class="table datatable table-hover" style="width:100%">
                                   <thead>
                        <tr>
                           <th>@lang('Reciever_Name')</th>
                            <th>@lang('Total')</th>
                            <th>@lang('invoice status')</th>
                            {{-- <th>تاريخ الفاتورة</th> --}}
                            <th>@lang('uuid') </th>
                            <th>@lang('internalid') </th>
                            <th>@lang('doc_view')</th>
                            {{-- <th>@lang('doc_Download')</th>
                          
                            <th>@lang('doc_cancel')</th> --}}
                        </tr>
                    </thead>
                                <tbody>

                                    @foreach ($allInvoices as $index => $invoice)
                                        @if ($invoice['issuerId'] == $taxId)
                                            <tr>
                                                <td style="white-space: nowrap;">{{ $invoice['receiverName'] }}</td>
                                                <td style="white-space: nowrap;">{{ $invoice['total'] }} EGP</td>
                                                @if ($invoice['status'] === 'Valid')
                                                    <td style="white-space: nowrap;">@lang('valid')</td>
                                                @elseif ($invoice['status'] === 'Invalid')
                                                    <td style="white-space: nowrap;">@lang('invalid')</td>
                                                @elseif($invoice['status'] === 'Cancelled')
                                                    <td style="white-space: nowrap;">@lang('cancelled')</td>
                                                @elseif($invoice['status'] === 'Submitted')
                                                    <td style="white-space: nowrap;">@lang('submited')</td>
                                                @elseif($invoice['status'] === 'Rejected')
                                                    <td style="white-space: nowrap;">@lang('rejected')</td>
                                                @else
                                                    <td style="white-space: nowrap;">{{ $invoice['status'] }}</td>
                                                @endif
                                                {{-- <td> {{ Carbon\Carbon::parse($invoice['dateTimeIssued'])->format('d-m-Y') }}</td> --}}
                                                <td style="white-space: nowrap;"> {{ $invoice['uuid'] }}</td>
                                                <td style="white-space: nowrap;"> {{ $invoice['internalId'] }}</td>
                                                {{-- <td> {{ $invoice['dateTimeIssued'] }}</td> --}}
                                                <td style="white-space: nowrap;"><a href="https://preprod.invoicing.eta.gov.eg/print/documents/{{ $invoice['uuid'] }}/share/{{ $invoice['longId'] }} "
                                                        target="_blank" class="btn btn-success">@lang('viewinportal')</a>
                                                </td>
                                                {{-- <td><a href="{{ route('pdf',$invoice['uuid']) }}" class="btn btn-info" target="_blank"> @lang('download') </a></td> --}}

                                                {{-- <td>
                                                <form action="{{ route('cancelDocument',$invoice['uuid']) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="btn btn-danger" type="submit"
                                                        onclick="return confirm('@lang('rusuretocancel')');">@lang('cancel invoice')</button>
                                                </form>
                                        </td> --}}

                                            </tr>
                                        @endif
                                    @endforeach


                                </tbody>


                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('admin.groups.modals.print_barcode')
@endsection
@section('scripts')
    {{-- <script src="{{ asset('js/admin/groups.js') }}"></script> --}}
    <script>
        var can_delete =
            @can('delete_group')
                true
            @else
                false
            @endcan ;
        var can_view =
            @can('view_group')
                true
            @else
                false
            @endcan ;
    </script>
    <script>
        $(document).on('change', '.check-test', function() {

            var checked = $(this).is(':checked');

            if (checked) {
                $(this).next().val($(this).val());
            } else {
                $(this).next().val('');
            }

        });
        $('.check_all').on('click', function(e) {
            if ($(this).is(':checked', true)) {
                $(".bulk_checkbox").prop('checked', true);
            } else {
                $(".bulk_checkbox").prop('checked', false);
            }
        });

        function add(accumulator, a) {
            return accumulator + a;
        }
        $('#pay_delayed_money').on('click', function(e) {
            var allVals = [];
            var allIds = [];
            $(".bulk_checkbox:checked").each(function() {
                if (typeof $(this).data('delayed_money') != 'string') {
                    allIds.push($(this).val());
                    allVals.push($(this).data('delayed_money'));
                }

            });
            let sum = allVals.reduce(add, 0)
            console.log(allVals, allIds, sum)

            if (allVals.length <= 0) {
                alert("Please select row.");
            } else {
                var check = confirm("Are you sure you want to pay ( " + sum + " LE)?");
                if (check) {
                    $.ajax({
                        url: $(this).data('url'),
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        data: {
                            ids: allIds,
                            values: allVals
                        },
                        success: function(data) {
                            if (data.success) {
                                alert(data.msg);
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            } else {
                                alert(data.msg)
                            }
                        }
                    });
                }

            }
        })
    </script>
    <script>
        // var formSmall = $(".form-small").select2({ tags: true });
        // formSmall.data('select2').$container.addClass('form-control-sm')
    </script>
@endsection
