<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
<!-- jQuery -->
<script src="{{url('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{url('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{url('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{url('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{url('plugins/sparklines/sparkline.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{url('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{url('plugins/moment/moment.min.js')}}"></script>
<script src="{{url('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- DataTables -->
<script src="{{url('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{url('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
{{-- <script src="{{url('plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js')}}" type="text/javascript"></script> --}}
<script src="{{url('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{url('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{url('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{url('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- Toastr-->
<script src="{{ url('js/toastr.min.js')}}"></script>
<!-- Validate -->
<script src="{{url('plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{url('plugins/print/jQuery.print.min.js')}}"></script>
<script src="{{url('js/jquery.classyqr.min.js')}}"></script>
<script src="{{url('js/select2.js')}}"></script>
<script src="{{url('plugins/sweet-alert/sweetalert.min.js')}}"></script>
<!-- Flatpickr -->
<script src="{{url('plugins/flatpickr/flatpickr.min.js')}}"></script>

<!-- Rating js-->
<script src="{{URL::asset('new-design/assets/plugins/rating/jquery.rating-stars.js')}}"></script>
<script src="{{URL::asset('new-design/assets/plugins/rating/jquery.barrating.js')}}"></script>

<!--Internal  Perfect-scrollbar js -->
<script src="{{URL::asset('new-design/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{URL::asset('new-design/assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script>
<!--Internal Sparkline js -->
<script src="{{URL::asset('new-design/assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<!-- Custom Scroll bar Js-->
<script src="{{URL::asset('new-design/assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- right-sidebar js -->
<script src="{{URL::asset('new-design/assets/plugins/sidebar/sidebar-rtl.js')}}"></script>
<script src="{{URL::asset('new-design/assets/plugins/sidebar/sidebar-custom.js')}}"></script>
<!-- Eva-icons js -->
<script src="{{URL::asset('new-design/assets/js/eva-icons.min.js')}}"></script>
<script>
    var translations=`{!! session("trans") !!}`;
    function trans(key)
    {
      var trans=JSON.parse(translations);
      return (trans[key]!=null?trans[key]:key);
    }
  </script>
  <!-- \Scripts Translation -->

@yield('js')
<!-- Sticky js -->
<script src="{{URL::asset('new-design/assets/js/sticky.js')}}"></script>
<!-- custom js -->
<script src="{{URL::asset('new-design/assets/js/custom.js')}}"></script><!-- Left-menu js-->
<script src="{{URL::asset('new-design/assets/plugins/side-menu/sidemenu.js')}}"></script>
<!-- Scripts Translation -->

<!-- \Main dashboard -->
