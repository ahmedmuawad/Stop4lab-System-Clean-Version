(function($){

    "use strict";

    $.widget.bridge('uibutton', $.ui.button);

    //initialize select2
    $('.select2').select2({
      width:"100%"
    });

    //datepicker
    var date=new Date();
    var current_year=date.getFullYear();
    $('.datepicker').datepicker({
      dateFormat:"yy-mm-dd",
      changeYear: true,
      changeMonth: true,
      yearRange:"1900:"+current_year

    });

    //flatpickr
    $('.flatpickr').flatpickr({
      enableTime: true,
      dateFormat: "Y-m-d H:i",
    });

    //intialize toastr
    toastr.options = {
      "debug": false,
      "positionClass": "toast-top-center",
      "onclick": null,
      "fadeIn": 300,
      "fadeOut": 1000,
      "timeOut": 5000,
      "extendedTimeOut": 1000
    }

    $('form').each(function() {  // attach to all form elements on page
      $(this).validate({       // initialize plugin on each form
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    });


    $(window).on('load',function() {
        $('.preloader').hide();
        $('.loader').hide();
    });

    //OverlayScrollbars
    document.addEventListener("DOMContentLoaded", function() {
      //The first argument are the elements to which the plugin shall be initialized
      //The second argument has to be at least a empty object or a object with your desired options
      // OverlayScrollbars(document.querySelectorAll('body'), { });
      OverlayScrollbars(document.querySelectorAll('.dropdown-menu'), { });
    });

    //change theme
    $(document).on('click','.change_theme',function(e){
        $.ajax({
            beforeSend:function(){
              $('.preloader').show();
              $('.loader').show();
              $('#load_screen').show();
            },
            url:ajax_url('change_patient_theme'),
            success:function(theme){
              if(theme=='dark' && language == 'en' )
              {
                $('#theme').html(`
                  <link rel="stylesheet" href="`+url('new_design/assets/css/main_en_dark.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets/css/structure_en_dark.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/plugins/perfect-scrollbar/perfect-scrollbar.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/plugins/highlight/styles/monokai-sublime.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets/css/scrollspyNav.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets/css/components/tabs-accordian/custom-tabs.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets/css/tables/table-basic.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets/css/components/custom-modal.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/plugins/apex/apexcharts.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets/css/elements/alert.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets/css/dashboard/dash_1.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/plugins/table/datatable/datatables.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/plugins/table/datatable/custom_dt_miscellaneous.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets/css/forms/theme-checkbox-radio.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/plugins/table/datatable/dt-global_style.css')+`">
                  <link rel="stylesheet" href="`+url('plugins/fontawesome-free/css/all.min.css')+`">
                  <link rel="stylesheet" href="`+url('assets/css/select2.css')+`">
                  <link rel="stylesheet" href="`+url('css/toastr.min.css')+`">
                  <link rel="stylesheet" href="`+url('plugins/flatpickr/flatpickr.min.css')+`">
                  <link rel="stylesheet" href="`+url('plugins/daterangepicker/daterangepicker.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/plugins/apex/apexcharts.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets/css/dashboard/dash_2.css')+`">
                `);
              }
              else if(theme=='dark' && language == 'ar'){
                $('#theme').html(`
                  <link rel="stylesheet" href="`+url('new_design/assets/css/main_ar_dark.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets/css/structure_ar_dark.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/plugins/apex/apexcharts.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets-dark-rtl/css/dashboard/dash_2.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/plugins-dark-rtl/perfect-scrollbar/perfect-scrollbar.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/plugins-dark-rtl/highlight/styles/monokai-sublime.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets-dark-rtl/css/scrollspyNav.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets-dark-rtl/css/components/tabs-accordian/custom-tabs.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets-dark-rtl/css/tables/table-basic.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets-dark-rtl/css/components/custom-modal.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/plugins-dark-rtl/apex/apexcharts.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets-dark-rtl/css/elements/alert.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets-dark-rtl/css/dashboard/dash_1.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/plugins-dark-rtl/table/datatable/datatables.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/plugins-dark-rtl/table/datatable/custom_dt_miscellaneous.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets-dark-rtl/css/forms/theme-checkbox-radio.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/plugins-dark-rtl/table/datatable/dt-global_style.css')+`">
                  <link rel="stylesheet" href="`+url('plugins/fontawesome-free/css/all.min.css')+`">
                  <link rel="stylesheet" href="`+url('assets-dark-rtl/css/select2.css')+`">
                  <link rel="stylesheet" href="`+url('css/toastr.min.css')+`">
                  <link rel="stylesheet" href="`+url('plugins/flatpickr/flatpickr.min.css')+`">
                  <link rel="stylesheet" href="`+url('plugins/daterangepicker/daterangepicker.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/plugins-dark-rtl/apex/apexcharts.css')+`">
                  <link rel="stylesheet" href="`+url('new_design/assets-dark-rtl/css/dashboard/dash_2.css')+`">
                `);
              }
              else if(theme!='dark' && language == 'en'){
                  $('#theme').html(`
                    <link rel="stylesheet" href="`+url('new_design/assets/css/main_en_light.css')+`">
                    <link rel="stylesheet" href="`+url('new_design/assets/css/structure_en_light.css')+`">
                    <link rel="stylesheet" href="`+url('new_design/plugins-light-ltr/perfect-scrollbar/perfect-scrollbar.css')+`">
                    <link rel="stylesheet" href="`+url('new_design/plugins-light-ltr/highlight/styles/monokai-sublime.css')+`">
                    <link rel="stylesheet" href="`+url('new_design/assets-light-ltr/css/scrollspyNav.css')+`">
                    <link rel="stylesheet" href="`+url('new_design/assets-light-ltr/css/components/tabs-accordian/custom-tabs.css')+`">
                    <link rel="stylesheet" href="`+url('new_design/assets-light-ltr/css/tables/table-basic.css')+`">
                    <link rel="stylesheet" href="`+url('new_design/assets-light-ltr/css/components/custom-modal.css')+`">
                    <link rel="stylesheet" href="`+url('new_design/plugins-light-ltr/apex/apexcharts.css')+`">
                    <link rel="stylesheet" href="`+url('new_design/assets-light-ltr/css/elements/alert.css')+`">
                    <link rel="stylesheet" href="`+url('new_design/assets-light-ltr/css/dashboard/dash_1.css')+`">
                    <link rel="stylesheet" href="`+url('new_design/assets-light-ltr/css/dashboard/dash_2.css')+`">
                    <link rel="stylesheet" href="`+url('new_design/plugins-light-ltr/table/datatable/datatables.css')+`">
                    <link rel="stylesheet" href="`+url('new_design/plugins-light-ltr/table/datatable/custom_dt_miscellaneous.css')+`">
                    <link rel="stylesheet" href="`+url('new_design/assets-light-ltr/css/forms/theme-checkbox-radio.css')+`">
                    <link rel="stylesheet" href="`+url('new_design/plugins-light-ltr/table/datatable/dt-global_style.css')+`">
                    <link rel="stylesheet" href="`+url('plugins/fontawesome-free/css/all.min.css')+`">
                    <link rel="stylesheet" href="`+url('assets-dark-rtl/css/select2.css')+`">
                    <link rel="stylesheet" href="`+url('css/toastr.min.css')+`">
                    <link rel="stylesheet" href="`+url('plugins/flatpickr/flatpickr.min.css')+`">
                    <link rel="stylesheet" href="`+url('plugins/daterangepicker/daterangepicker.css')+`">
                  `);
              }
              else{
                $('#theme').html(`
                <link rel="stylesheet" href="`+url('new_design/assets-light-rtl/css/dashboard/dash_2.css')+`">
                <link rel="stylesheet" href="`+url('new_design/assets/css/main_ar_light.css')+`">
                <link rel="stylesheet" href="`+url('new_design/assets/css/structure_ar_light.css')+`">
                <link rel="stylesheet" href="`+url('new_design/plugins-light-rtl/perfect-scrollbar/perfect-scrollbar.css')+`">
                <link rel="stylesheet" href="`+url('new_design/plugins-light-rtl/highlight/styles/monokai-sublime.css')+`">
                <link rel="stylesheet" href="`+url('new_design/assets-light-rtl/css/scrollspyNav.css')+`">
                <link rel="stylesheet" href="`+url('new_design/assets-light-rtl/css/components/tabs-accordian/custom-tabs.css')+`">
                <link rel="stylesheet" href="`+url('new_design/assets-light-rtl/css/tables/table-basic.css')+`">
                <link rel="stylesheet" href="`+url('new_design/assets-light-rtl/css/components/custom-modal.css')+`">
                <link rel="stylesheet" href="`+url('new_design/plugins-light-rtl/apex/apexcharts.css')+`">
                <link rel="stylesheet" href="`+url('new_design/assets-light-rtl/css/elements/alert.css')+`">
                <link rel="stylesheet" href="`+url('new_design/assets-light-rtl/css/dashboard/dash_1.css')+`">
                <link rel="stylesheet" href="`+url('new_design/plugins-light-rtl/table/datatable/datatables.css')+`">
                <link rel="stylesheet" href="`+url('new_design/plugins-light-rtl/table/datatable/custom_dt_miscellaneous.css')+`">
                <link rel="stylesheet" href="`+url('new_design/assets-light-rtl/css/forms/theme-checkbox-radio.css')+`">
                <link rel="stylesheet" href="`+url('new_design/plugins-light-rtl/table/datatable/dt-global_style.css')+`">
                <link rel="stylesheet" href="`+url('plugins/fontawesome-free/css/all.min.css')+`">
                <link rel="stylesheet" href="`+url('assets-light-ltr/css/select2.css')+`">
                <link rel="stylesheet" href="`+url('css/toastr.min.css')+`">
                <link rel="stylesheet" href="`+url('plugins/flatpickr/flatpickr.min.css')+`">
                <link rel="stylesheet" href="`+url('plugins/daterangepicker/daterangepicker.css')+`">
                `);
              }


              if($('#dashboard').hasClass('active'))
              {
                if(can_view_income_statistics)
                {
                  income_chart_statistics2();
                }
                if(can_view_best_income_packages)
                {
                  best_packages();
                }
                if(can_view_best_income_tests)
                {
                  best_tests();
                }
                if(can_view_best_income_cultures)
                {
                  best_cultures();
                }
              }

            },
          });
      setTimeout(function(){
        $('.preloader').hide();
        $('.loader').hide();
      },1200);
    });

    //prevent submiting form more than one
    $(document).on('submit','form:not(.modal form)',function(){
      $('.preloader').show();
      $('.loader').show();
    });

    //prevent submiting form after canceling
    $(document).on('click','.cancel_form',function(){
      $('.preloader').show();
      $('.loader').show();
    });


})(jQuery);


//toastr success message
function toastr_success(message)
{
    toastr.success(message,trans('Success'));
}

//toastr error message
function toastr_error(message)
{
    toastr.error(message,trans('Failed'));
}

//url
function url(url='')
{
  var base_url=location.origin;

  return base_url+'/'+url;
}

//ajax url
function ajax_url(url='')
{
  var base_url=location.origin;

  return base_url+'/ajax/'+url;
}
