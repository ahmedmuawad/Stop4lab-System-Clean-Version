(function ($) {

    "use strict";
  
    //categories datatable
    table = $('#safe_transfer_table').DataTable({
      "lengthMenu": [[10, 25, 50, 100, 500, 1000, -1], [10, 25, 50, 100, 500, 1000, "All"]],
      dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4'i><'col-sm-8'p>>",
  
      "processing": true,
      "serverSide": true,
      "order": [
        [1, "desc"]
        ],
      "ajax": {
        url: url("admin/get_safe_transfer"),
        data: function(data) {
          data.type = 'all';
          data.filter_date = $('#filter_date').val();
          data.filter_from_branch = $('#filter_from_branch').val();
          data.filter_to_branch = $('#filter_to_branch').val();
          data.filter_from_user = $('#filter_from_user').val();
          data.filter_to_user = $('#filter_to_user').val();
        

      }

      },
      fixedHeader: true,
      "columns": [
        { data: "bulk_checkbox", searchable: false, sortable: false, orderable: false },

        { data: "id", sortable: true, orderable: true },
        { data: "from_brnach.name", sortable: true, orderable: true },
        { data: "to_brnach.name", sortable: true, orderable: true },
        { data: "from_user.name", sortable: true, orderable: true },
        { data: "to_user.name", sortable: true, orderable: true },
        { data: "payments", searchable: true, sortable: false, orderable: false },
        { data: "payments_without_custody", searchable: true, sortable: false, orderable: false },
        { data: "from_to", searchable: true, sortable: false, orderable: false },
        { data: "created_at", searchable: true, sortable: false, orderable: false },
        { data: "action", searchable: false, orderable: false, sortable: false }//action
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
      }
    });
  
    //delete category
    $(document).on('click', '.delete_safe', function (e) {
      e.preventDefault();
      var el = $(this);
      swal({
        title: trans("Are you sure to delete category ?"),
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: trans("Delete"),
        cancelButtonText: trans("Cancel"),
        closeOnConfirm: false
      },
        function () {
          $(el).parent().submit();
        });
    });
  
    //get culture select2 intialize
    $('#branch').select2({
      width: "100%",
      // placeholder: trans("Branch"),
      ajax: {
        beforeSend: function () {
          $('.preloader').show();
          $('.loader').show();
        },
        url: ajax_url('get_branches_report'),
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
        complete: function () {
          $('.preloader').hide();
          $('.loader').hide();
        }
      }
    });


    $('.branch_id').select2({
      width: "100%",
      // placeholder: trans("Branch"),
      ajax: {
        beforeSend: function () {
          $('.preloader').show();
          $('.loader').show();
        },
        url: ajax_url('get_branches_report'),
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
        complete: function () {
          $('.preloader').hide();
          $('.loader').hide();
        }
      }
    });
  
  
    $('.user_id').select2({
      allowClear: true,
      multiple: true,
      width: "100%",
      placeholder: trans("User"),
      ajax: {
          beforeSend: function() {
              $('.preloader').show();
              $('.loader').show();
          },
          url: ajax_url('get_users'),
          processResults: function(data) {
              return {
                  results: $.map(data, function(item) {
                      return {
                          text: item.name,
                          id: item.id
                      }
                  })
              };
          },
          complete: function() {
              $('.preloader').hide();
              $('.loader').hide();
          }
      }
  });

      // filter date
      var ranges = {};
      ranges[trans('Today')] = [moment(), moment()];
      ranges[trans('Yesterday')] = [moment().subtract('days', 1), moment().subtract('days', 1)];
      ranges[trans('Last 7 Days')] = [moment().subtract('days', 6), moment()];
      ranges[trans('Last 30 Days')] = [moment().subtract('days', 29), moment()];
      ranges[trans('This Month')] = [moment().startOf('month'), moment().endOf('month')];
      ranges[trans('Last Month')] = [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')];
      ranges[trans('This Year')] = [moment().startOf('year'), moment().endOf('year')];
      ranges[trans('Last Year')] = [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')];


    $('#filter_date').daterangepicker({
      locale: {
          format: 'YYYY/MM/DD',
          "applyLabel": trans("Save"),
          "cancelLabel": trans("Cancel"),
      },
      ranges,
      startDate: moment(),
      endDate: moment()
    },
    function(start, end) {
        $('#dateRange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });

    $('#filter_date').on('cancel.daterangepicker', function() {
    $(this).val('');
    });



    $('#filter_date').on('cancel.daterangepicker', function() {
    $(this).val('');
      table.draw(); 
    });

    $('#filter_date').on('apply.daterangepicker', function() {
      table.draw();
    });

    $('#filter_date').val('');

    $('#filter_from_branch').on('change', function() {
      table.draw();    
    });
    $('#filter_to_branch').on('change', function() {
      table.draw();    
    });
    $('#filter_from_user').on('change', function() {
      table.draw();    
    });

    $('#filter_to_user').on('change', function() {
      table.draw();
    });



    

    



    // $('.total_cach').html()
  
  })(jQuery);
  
  