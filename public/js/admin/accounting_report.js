(function($){

    "use strict";

    $('.report-datatable').DataTable({
      "lengthMenu": [[10, 25, 50,100,500,1000, -1], [10, 25, 50,100,500,1000 ,"All"]],
      dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-4'i><'col-sm-8'p>>",
        "processing": true,
        "serverSide": false,
        "bSort" : false,
        "language": {
          "sEmptyTable":     trans("No data available in table"),
          "sInfo":           trans("Showing")+" _START_ "+trans("to")+" _END_ "+trans("of")+" _TOTAL_ "+trans("records"),
          "sInfoEmpty":      trans("Showing")+" 0 "+trans("to")+" 0 "+trans("of")+" 0 "+trans("records"),
          "sInfoFiltered":   "("+trans("filtered")+" "+trans("from")+" _MAX_ "+trans("total")+" "+trans("records")+")",
          "sInfoPostFix":    "",
          "sInfoThousands":  ",",
          "sLengthMenu":     trans("Show")+" _MENU_ "+trans("records"),
          "sLoadingRecords": trans("Loading..."),
          "sProcessing":     trans("Processing..."),
          "sSearch":         trans("Search")+":",
          "sZeroRecords":    trans("No matching records found"),
          "oPaginate": {
              "sFirst":    trans("First"),
              "sLast":     trans("Last"),
              "sNext":     trans("Next"),
              "sPrevious": trans("Previous")
          },
        }
    });

    $('#group_reports').DataTable({
      "lengthMenu": [
          [25, 50, 100, 500, 1000, -1],
          [25, 50, 100, 500, 1000, "All"]
      ],
      dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-4'i><'col-sm-8'p>>",
      "processing": true,
      "serverSide": true,
      "order": [
          [1, "desc"]
      ],
      "ajax": {
          url: url("admin/reports/getAccountingGroups"),
          data: function (data) {
            data.date = $('#date').val();
            data.doctors = $('#doctor').val();
            data.tests = $('#test').val();
            data.cultures = $('#culture').val();
            data.packages = $('#package').val();
            data.contracts = $('#contract').val();
            data.branches = $('#branch').val();
            data.repa = $('#rep').val();
            data.region_id = $('#region_id').val();
            data.rep_id = $('#rep_id').val();
        }
          
      },
      // orderCellsTop: true,
      fixedHeader: true,
      "columns": [
          { data: "id", sortable: true, orderable: true },
          { data: "created_at", sortable: true, orderable: true },
          { data: "patient.name", orderable: false, sortable: false },
          { data: "newDoctor", orderable: false, sortable: false },
          { data: "contract.title", orderable: false, sortable: false },
          { data: "tests", orderable: false, sortable: false },
          { data: "price_tests", orderable: false, sortable: false },
          { data: "subtotal", orderable: false, sortable: false },
          { data: "discount", orderable: false, sortable: false },
          { data: "total", orderable: false, sortable: false },
          { data: "paid", orderable: false, sortable: false },
          { data: "due", orderable: false, sortable: false },
          { data: "cost", orderable: false, sortable: false },
          { data: "total_after_cost", orderable: false, sortable: false },
      ],
      
      "language": {
          "sEmptyTable": trans("No data available in table"),
          "sInfo": trans("Showing") + " _START_ " + trans("to") + " _END_ " + trans("of") + " _TOTAL_ " + trans("records"),
          "sInfoEmpty": trans("Showing") + " 0 " + trans("to") + " 0 " + trans("of") + " 0 " + trans("records"),
          "sInfoFiltered": "(" + trans("filtered") + " " + trans("from") + " _MAX_ " + trans("total") + " " + trans("records") + ")",
          "sInfoPostFix": "",
          "sInfoThousands": ",",
          "sLengthMenu": trans("Show") + " _MENU_ " + trans("records"),
          "sLoadingRecords": trans("Loading..."),
          "sProcessing": trans("Processing..."),
          "sSearch": trans("Search") + ":",
          "sZeroRecords": trans("No matching records found"),
          "oPaginate": {
              "sFirst": trans("First"),
              "sLast": trans("Last"),
              "sNext": trans("Next"),
              "sPrevious": trans("Previous")
          },
      },
  });
    $('#due_reports').DataTable({
      "lengthMenu": [
          [25, 50, 100, 500, 1000, -1],
          [25, 50, 100, 500, 1000, "All"]
      ],
      dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-4'i><'col-sm-8'p>>",
      "processing": true,
      "serverSide": true,
      "order": [
          [1, "desc"]
      ],
      "ajax": {
          url: url("admin/reports/getAccountingGroups"),
          data: function (data) {
            data.date = $('#date').val();
            data.doctors = $('#doctor').val();
            data.tests = $('#test').val();
            data.cultures = $('#culture').val();
            data.packages = $('#package').val();
            data.contracts = $('#contract').val();
            data.branches = $('#branch').val();
            data.repa = $('#rep').val();
            data.region_id = $('#region_id').val();
            data.rep_id = $('#rep_id').val();
            data.groupsDue = 'done';
        }
          
      },
      // orderCellsTop: true,
      fixedHeader: true,
      "columns": [
          { data: "id", sortable: true, orderable: true },
          { data: "created_at", sortable: true, orderable: true },
          { data: "patient.name", orderable: false, sortable: false },
          { data: "newDoctor", orderable: false, sortable: false },
          { data: "contract.title", orderable: false, sortable: false },
          { data: "tests", orderable: false, sortable: false },
          { data: "subtotal", orderable: false, sortable: false },
          { data: "discount", orderable: false, sortable: false },
          { data: "total", orderable: false, sortable: false },
          { data: "paid", orderable: false, sortable: false },
          { data: "due", orderable: false, sortable: false },
          { data: "cost", orderable: false, sortable: false },
          { data: "total_after_cost", orderable: false, sortable: false },
      ],
      
      "language": {
          "sEmptyTable": trans("No data available in table"),
          "sInfo": trans("Showing") + " _START_ " + trans("to") + " _END_ " + trans("of") + " _TOTAL_ " + trans("records"),
          "sInfoEmpty": trans("Showing") + " 0 " + trans("to") + " 0 " + trans("of") + " 0 " + trans("records"),
          "sInfoFiltered": "(" + trans("filtered") + " " + trans("from") + " _MAX_ " + trans("total") + " " + trans("records") + ")",
          "sInfoPostFix": "",
          "sInfoThousands": ",",
          "sLengthMenu": trans("Show") + " _MENU_ " + trans("records"),
          "sLoadingRecords": trans("Loading..."),
          "sProcessing": trans("Processing..."),
          "sSearch": trans("Search") + ":",
          "sZeroRecords": trans("No matching records found"),
          "oPaginate": {
              "sFirst": trans("First"),
              "sLast": trans("Last"),
              "sNext": trans("Next"),
              "sPrevious": trans("Previous")
          },
      },
  });
    $('#delay_reports').DataTable({
      "lengthMenu": [
          [25, 50, 100, 500, 1000, -1],
          [25, 50, 100, 500, 1000, "All"]
      ],
      dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-4'i><'col-sm-8'p>>",
      "processing": true,
      "serverSide": true,
      "order": [
          [1, "desc"]
      ],
      "ajax": {
          url: url("admin/reports/getAccountingGroups"),
          data: function (data) {
            data.date = $('#date').val();
            data.doctors = $('#doctor').val();
            data.tests = $('#test').val();
            data.cultures = $('#culture').val();
            data.packages = $('#package').val();
            data.contracts = $('#contract').val();
            data.branches = $('#branch').val();
            data.repa = $('#rep').val();
            data.region_id = $('#region_id').val();
            data.rep_id = $('#rep_id').val();
            data.groupsDelay = 'done';
        }
          
      },
      // orderCellsTop: true,
      fixedHeader: true,
      "columns": [
          { data: "id", sortable: true, orderable: true },
          { data: "created_at", sortable: true, orderable: true },
          { data: "patient.name", orderable: false, sortable: false },
          { data: "newDoctor", orderable: false, sortable: false },
          { data: "contract.title", orderable: false, sortable: false },
          { data: "tests", orderable: false, sortable: false },
          { data: "subtotal", orderable: false, sortable: false },
          { data: "discount", orderable: false, sortable: false },
          { data: "total", orderable: false, sortable: false },
          { data: "paid", orderable: false, sortable: false },
          { data: "due", orderable: false, sortable: false },
          { data: "cost", orderable: false, sortable: false },
          { data: "total_after_cost", orderable: false, sortable: false },
      ],
      
      "language": {
          "sEmptyTable": trans("No data available in table"),
          "sInfo": trans("Showing") + " _START_ " + trans("to") + " _END_ " + trans("of") + " _TOTAL_ " + trans("records"),
          "sInfoEmpty": trans("Showing") + " 0 " + trans("to") + " 0 " + trans("of") + " 0 " + trans("records"),
          "sInfoFiltered": "(" + trans("filtered") + " " + trans("from") + " _MAX_ " + trans("total") + " " + trans("records") + ")",
          "sInfoPostFix": "",
          "sInfoThousands": ",",
          "sLengthMenu": trans("Show") + " _MENU_ " + trans("records"),
          "sLoadingRecords": trans("Loading..."),
          "sProcessing": trans("Processing..."),
          "sSearch": trans("Search") + ":",
          "sZeroRecords": trans("No matching records found"),
          "oPaginate": {
              "sFirst": trans("First"),
              "sLast": trans("Last"),
              "sNext": trans("Next"),
              "sPrevious": trans("Previous")
          },
      },
  });
    $('#payments_reports').DataTable({
      "lengthMenu": [
          [25, 50, 100, 500, 1000, -1],
          [25, 50, 100, 500, 1000, "All"]
      ],
      dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-4'i><'col-sm-8'p>>",
      "processing": true,
      "serverSide": true,
      "order": [
          [1, "desc"]
      ],
      "ajax": {
          url: url("admin/reports/getAccountingPayments"),
          data: function (data) {
            data.date = $('#date').val();
            data.doctors = $('#doctor').val();
            data.tests = $('#test').val();
            data.cultures = $('#culture').val();
            data.packages = $('#package').val();
            data.contracts = $('#contract').val();
            data.branches = $('#branch').val();
            data.repa = $('#rep').val();
            data.region_id = $('#region_id').val();
            data.rep_id = $('#rep_id').val();
        }
          
      },
      // orderCellsTop: true,
      fixedHeader: true,
      "columns": [
          { data: "id", sortable: true, orderable: true },
          { data: "group_id", sortable: true, orderable: true },
          { data: "group.patient.name", orderable: false, sortable: false },
          { data: "newDoctor", orderable: false, sortable: false },
          { data: "group.contract.title", orderable: false, sortable: false },
          { data: "tests", orderable: false, sortable: false },
          { data: "price_tests", orderable: false, sortable: false },
          { data: "date", orderable: false, sortable: false },
          { data: "amount", orderable: false, sortable: false },
          { data: "payment_method.name", orderable: false, sortable: false },
      ],
      
      "language": {
          "sEmptyTable": trans("No data available in table"),
          "sInfo": trans("Showing") + " _START_ " + trans("to") + " _END_ " + trans("of") + " _TOTAL_ " + trans("records"),
          "sInfoEmpty": trans("Showing") + " 0 " + trans("to") + " 0 " + trans("of") + " 0 " + trans("records"),
          "sInfoFiltered": "(" + trans("filtered") + " " + trans("from") + " _MAX_ " + trans("total") + " " + trans("records") + ")",
          "sInfoPostFix": "",
          "sInfoThousands": ",",
          "sLengthMenu": trans("Show") + " _MENU_ " + trans("records"),
          "sLoadingRecords": trans("Loading..."),
          "sProcessing": trans("Processing..."),
          "sSearch": trans("Search") + ":",
          "sZeroRecords": trans("No matching records found"),
          "oPaginate": {
              "sFirst": trans("First"),
              "sLast": trans("Last"),
              "sNext": trans("Next"),
              "sPrevious": trans("Previous")
          },
      },
  });
    $('#expenses_reports').DataTable({
      "lengthMenu": [
          [25, 50, 100, 500, 1000, -1],
          [25, 50, 100, 500, 1000, "All"]
      ],
      dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-4'i><'col-sm-8'p>>",
      "processing": true,
      "serverSide": true,
      "order": [
          [1, "desc"]
      ],
      "ajax": {
          url: url("admin/reports/getAccountingExpenses"),
          data: function (data) {
            data.date = $('#date').val();
            data.doctors = $('#doctor').val();
            data.tests = $('#test').val();
            data.cultures = $('#culture').val();
            data.packages = $('#package').val();
            data.contracts = $('#contract').val();
            data.branches = $('#branch').val();
            data.repa = $('#rep').val();
            data.region_id = $('#region_id').val();
            data.rep_id = $('#rep_id').val();
        }
          
      },
      // orderCellsTop: true,
      fixedHeader: true,
      "columns": [
          { data: "id", sortable: true, orderable: true },
          { data: "category.name", orderable: false, sortable: false },
          { data: "date", orderable: false, sortable: false },
          { data: "amount", orderable: false, sortable: false },
          { data: "payment_method.name", orderable: false, sortable: false },
          { data: "doctor.name", orderable: false, sortable: false },
          { data: "notes", orderable: false, sortable: false },
          { data: "branch.name", orderable: false, sortable: false },
      ],
      
      "language": {
          "sEmptyTable": trans("No data available in table"),
          "sInfo": trans("Showing") + " _START_ " + trans("to") + " _END_ " + trans("of") + " _TOTAL_ " + trans("records"),
          "sInfoEmpty": trans("Showing") + " 0 " + trans("to") + " 0 " + trans("of") + " 0 " + trans("records"),
          "sInfoFiltered": "(" + trans("filtered") + " " + trans("from") + " _MAX_ " + trans("total") + " " + trans("records") + ")",
          "sInfoPostFix": "",
          "sInfoThousands": ",",
          "sLengthMenu": trans("Show") + " _MENU_ " + trans("records"),
          "sLoadingRecords": trans("Loading..."),
          "sProcessing": trans("Processing..."),
          "sSearch": trans("Search") + ":",
          "sZeroRecords": trans("No matching records found"),
          "oPaginate": {
              "sFirst": trans("First"),
              "sLast": trans("Last"),
              "sNext": trans("Next"),
              "sPrevious": trans("Previous")
          },
      },
  });


    $('#filter_contract').on('change', function() {
        var contract_id = $(this).val();
        var url = $(this).attr('data-url');
        // send request ajax
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                contract_id: contract_id[0],
            },
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            success: function(data) {
                if (data.status == 'success') {
                    if(data.lab_to_lab) {
                        $('.lab-to-lab').removeClass('d-none').addClass('d-block')
                    } else {
                        $('.lab-to-lab').addClass('d-none').removeClass('d-block')
                    }
                } else {
                    console.log(data.message);
                }
            },
            complete: function() {
                $('.preloader').hide();
                $('.loader').hide();
            }
        });

    });

    //active
    $('#reports').addClass('active menu-open');
    $('#reports_link').addClass('active');
    $('#accounting_report').addClass('active');

    //get doctor select2 intialize
    $('#doctor').select2({
      width:"100%",
      placeholder:trans("Doctor"),
      multiple: true,
      ajax: {
       beforeSend:function()
       {
          $('.preloader').show();
          $('.loader').show();
       },
       url:ajax_url('get_doctors'),
       processResults: function (data) {
             return {
                   results: $.map(data, function (item) {
                      return {
                         text: item.name,
                         id: item.id
                      }
                   })
             };
          },
          complete:function()
          {
             $('.preloader').hide();
             $('.loader').hide();
          }
       }
    });

    //get test select2 intialize
    $('#test').select2({
        width:"100%",
        placeholder:trans("Test"),
        multiple: true,
        ajax: {
           beforeSend:function()
           {
              $('.preloader').show();
              $('.loader').show();
           },
           url:ajax_url('get_tests_select2'),
           processResults: function (data) {
                 return {
                       results: $.map(data, function (item) {
                          return {
                             text: item.name,
                             id: item.id
                          }
                       })
                 };
              },
              complete:function()
              {
                 $('.preloader').hide();
                 $('.loader').hide();
              }
           }
    });

    //get culture select2 intialize
    $('#culture').select2({
        width:"100%",
        placeholder:trans("Culture"),
        multiple: true,
        ajax: {
           beforeSend:function()
           {
              $('.preloader').show();
              $('.loader').show();
           },
           url:ajax_url('get_cultures_select2'),
           processResults: function (data) {
                 return {
                       results: $.map(data, function (item) {
                          return {
                             text: item.name,
                             id: item.id
                          }
                       })
                 };
              },
              complete:function()
              {
                 $('.preloader').hide();
                 $('.loader').hide();
              }
           }
    });

    //get culture select2 intialize
    $('#package').select2({
         width:"100%",
         placeholder:trans("Package"),
         multiple: true,
         ajax: {
            beforeSend:function()
            {
               $('.preloader').show();
               $('.loader').show();
            },
            url:ajax_url('get_packages_select2'),
            processResults: function (data) {
                  return {
                        results: $.map(data, function (item) {
                           return {
                              text: item.name,
                              id: item.id
                           }
                        })
                  };
               },
               complete:function()
               {
                  $('.preloader').hide();
                  $('.loader').hide();
               }
            }
    });

    //get culture select2 intialize
    $('#branch').select2({
      width:"100%",
      placeholder:trans("Branch"),
      multiple: true,
      ajax: {
         beforeSend:function()
         {
            $('.preloader').show();
            $('.loader').show();
         },
         url:ajax_url('get_branches_report'),
         processResults: function (data) {
               return {
                     results: $.map(data, function (item) {
                        return {
                           text: item.name,
                           id: item.id
                        }
                     })
               };
                  },
                  complete:function()
                  {
                     $('.preloader').hide();
                     $('.loader').hide();
                  }
               }
      });

    //get culture select2 intialize
    $('#contract').select2({
      width:"100%",
      placeholder:trans("Contract"),
      multiple: true,
      ajax: {
         beforeSend:function()
         {
            $('.preloader').show();
            $('.loader').show();
         },
         url:ajax_url('get_contracts'),
         processResults: function (data) {
               return {
                     results: $.map(data, function (item) {
                        return {
                           text: item.title,
                           id: item.id
                        }
                     })
               };
            },
            complete:function()
            {
               $('.preloader').hide();
               $('.loader').hide();
            }
         }
   });

    //get labs select2 intialize
    $('#lab').select2({
      width:"100%",
      placeholder:trans("labs"),
      multiple: true,
      ajax: {
         beforeSend:function()
         {
            $('.preloader').show();
            $('.loader').show();
         },
         url:ajax_url('get_labs'),
         processResults: function (data) {
               return {
                     results: $.map(data, function (item) {
                        return {
                           text: item.lab_code + '-' + item.name ,
                           id: item.id
                        }
                     })
               };
            },
            complete:function()
            {
               $('.preloader').hide();
               $('.loader').hide();
            }
         }
   });


    //get representative select2 intialize
    $('#rep').select2({
      width:"100%",
      placeholder:trans("labs"),
      multiple: true,
      ajax: {
         beforeSend:function()
         {
            $('.preloader').show();
            $('.loader').show();
         },
         url:ajax_url('get_reps'),
         processResults: function (data) {
               return {
                     results: $.map(data, function (item) {
                        return {
                           text: item.name ,
                           id: item.id
                        }
                     })
               };
            },
            complete:function()
            {
               $('.preloader').hide();
               $('.loader').hide();
            }
         }
   });


  $(document).on('change', '#contract', function() {
   var contract_id = $(this).val();

   console.log(contract_id);

   var url = $('#contract').attr('data-url');

   // send request ajax
   $.ajax({
       url: url,
       type: 'GET',
       data: {
           contract_id: contract_id[0],
       },
       beforeSend: function() {
           $('.preloader').show();
           $('.loader').show();
       },
       success: function(data) {
           if (data.status == 'success') {
               if(data.lab_to_lab) {
                   $('.lab-to-lab').removeClass('d-none').addClass('d-block')
               } else {
                   $('.lab-to-lab').addClass('d-none').removeClass('d-block')
               }
           } else {
               console.log(data.message);
           }
       },
       complete: function() {
           $('.preloader').hide();
           $('.loader').hide();
       }
   });

});



})(jQuery);