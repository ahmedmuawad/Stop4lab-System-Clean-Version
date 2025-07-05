<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{asset('new_design/assets/js/libs/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('new_design/bootstrap/js/popper.min.js')}}"></script>
@if(app()->getLocale() == 'en')
<script src="{{asset('new_design/bootstrap/js/bootstrap.min.js')}}"></script>
@else
<script src="{{asset('new_design/bootstrap/js/bootstrap_ar.min.js')}}"></script>
@endif
<script src="{{asset('new_design/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('new_design/assets/js/app.js')}}"></script>

<script src="{{asset('new_design/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('new_design/assets/js/app.js')}}"></script>
<!-- ChartJS -->
<script src="{{url('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{url('plugins/sparklines/sparkline.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{url('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
{{--  <script src="{{asset('new_design/assets/js/components/ui-accordions.js')}}"></script>  --}}
<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="{{asset('new_design/plugins/highlight/highlight.pack.js')}}"></script>
<script src="{{asset('new_design/assets/js/scrollspyNav.js')}}"></script>
<script src="{{asset('new_design/assets/js/custom.js')}}"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
<!-- jQuery -->

<!-- jQuery UI 1.11.4 -->
<script src="{{url('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Bootstrap 4 -->

<!-- DataTables -->
<script src="{{ asset('new_design/plugins/table/datatable/datatables.js') }}"></script>
<script src="{{ asset('new_design/plugins/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>


<script src="{{ asset('new_design/plugins/table/datatable/button-ext/jszip.min.js') }}"></script>
<script src="{{ asset('new_design/plugins/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
<script src="{{ asset('new_design/plugins/table/datatable/button-ext/buttons.print.min.js') }}"></script>

<!-- Toastr-->
<script src="{{ url('new_design/js/toastr.min.js')}}"></script>
{{-- moment --}}
<script src="{{url('plugins/moment/moment.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{url('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{url('new_design/js/select2.js')}}"></script>
<!-- Flatpickr -->
<script src="{{url('plugins/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{url('plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{url('plugins/print/jQuery.print.min.js')}}"></script>
<script src="{{url('js/jquery.classyqr.min.js')}}"></script>
<script src="{{url('js/select2.js')}}"></script>
<script src="{{url('plugins/sweet-alert/sweetalert.min.js')}}"></script>
<!-- Validate -->


<script src="{{url('new_design/js/jquery.classyqr.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{url('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- <script src="{{asset('new_design/plugins/sweetalerts/sweetalert2.min.js')}}"></script> -->
<script src="{{url('plugins/sweet-alert/sweetalert.min.js')}}"></script>
<!-- Summernote -->
<script src="{{url('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- Scripts Translation -->

<script>
    var translations=`{!! session("trans") !!}`;
    function trans(key)
    {
        var trans=JSON.parse(translations);
        return (trans[key]!=null?trans[key]:key);
    }
</script>

<script>
    //url
    function url(url='')
    {
        var base_url=location.origin;

        return base_url+'/'+url;
    }
</script>
<!-- Main dashboard -->
@if(auth()->guard('admin')->check())
  <script>
    var can_view_chat=@can('view_chat') true @else false @endif;
    var can_view_visit=@can('view_visit') true @else false @endif;
    var can_view_product=@can('view_product') true @else false @endif;
    var can_view_general_statistics=@can('view_general_statistics') true @else false @endif;
    var can_view_online_admins=@can('view_online_admins') true @else false @endif;
    var can_view_online_patients=@can('view_online_patients') true @else false @endif;
    var can_view_income_statistics=@can('view_income_statistics') true @else false @endif;
    var can_view_best_income_packages=@can('view_best_income_packages') true @else false @endif;
    var can_view_best_income_tests=@can('view_best_income_tests') true @else false @endif;
    var can_view_best_income_cultures=@can('view_best_income_packages') true @else false @endif;
  </script>
  <script src="{{ url('new_design/js/admin/main.js')}}"></script>
@else
  <script src="{{ url('new_design/js/patient/main.js')}}"></script>
@endif
<!-- \Main dashboard -->

<!-- Flash messages -->
<script>
  @if(session()->has('success'))
    toastr_success(trans("{{Session::get('success')}}"));
  @endif
  @if(Session()->has('failed')||session()->has('errors'))
    toastr_error(trans("{{Session::get('failed')}}"));
  @endif
</script>
<!-- \Flash messages -->


<!-- Bulk actions -->
@if(auth()->guard('admin')->check())
  <script src="{{ url('new_design/js/admin/bulk_action.js')}}"></script>
@endif
<!-- \Bulk actions -->


