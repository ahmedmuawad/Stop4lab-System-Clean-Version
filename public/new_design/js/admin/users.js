(function($){

    "use strict";

    // //datatable
    // table=$('#reports_table').DataTable( {
    //     "lengthMenu": [
    //         [10, 25, 50, 100, 500, 1000, -1],
    //         [10, 25, 50, 100, 500, 1000, "All"]
    //     ],
    //     dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
    //         "<'row'<'col-sm-12'tr>>" +
    //         "<'row'<'col-sm-4'i><'col-sm-8'p>>",
    //     buttons: [
    //         {
    //             extend:    'excelHtml5',
    //             text:      '<i class="fas fa-file-excel"></i> '+trans("Excel"),
    //             titleAttr: 'Excel'
    //         },
    //         {
    //             extend:    'csvHtml5',
    //             text:      '<i class="fas fa-file-csv"></i> '+trans("CVS"),
    //             titleAttr: 'CSV'
    //         },
    //         {
    //           extend:    'colvis',
    //           text:      '<i class="fas fa-eye"></i>',
    //           titleAttr: 'PDF'
    //         }

    //     ],
    //     "processing": true,
    //     "serverSide": true,
    //     "ajax": {
    //         url:url("new-design/admin/get_users")
    //     },
    //     fixedHeader: true,
    //     "columns": [
    //         {data:"bulk_checkbox",searchable:false,sortable:false,orderable:false},
    //         {data:"id",sortable:true,orderable:true},
    //         {data:"name",sortable:true,orderable:true},
    //         {data:"email",sortable:false,orderable:false},
    //         {data:"roles",sortable:false,orderable:false},
    //         {data:"branches",sortable:false,orderable:false},
    //         {data:"action",sortable:false,searchable:false,orderable:false}
    //       ],
    //     "language": {
    //         "sEmptyTable": trans("No data available in table"),
    //         "sInfo": trans("Showing") + " _START_ " + trans("to") + " _END_ " + trans("of") + " _TOTAL_ " + trans("records"),
    //         "sInfoEmpty": trans("Showing") + " 0 " + trans("to") + " 0 " + trans("of") + " 0 " + trans("records"),
    //         "sInfoFiltered": "(" + trans("filtered") + " " + trans("from") + " _MAX_ " + trans("total") + " " + trans("records") + ")",
    //         "sInfoPostFix": "",
    //         "sInfoThousands": ",",
    //         "sLengthMenu": trans("Show") + " _MENU_ " + trans("records"),
    //         "sLoadingRecords": trans("Loading..."),
    //         "sProcessing": trans("Processing..."),
    //         "sSearch": trans("Search") + ":",
    //         "sZeroRecords": trans("No matching records found"),
    //         "oPaginate": {
    //             "sFirst": trans("First"),
    //             "sLast": trans("Last"),
    //             "sNext": trans("Next"),
    //             "sPrevious": trans("Previous")
    //         },
    //     }
    // });

    //active
    $('#users').addClass('active');
    $('#users_roles_link').addClass('active');
    $('#users_roles').addClass('menu-open');

    //prepare edit user page
    var user_roles=$('#user_roles').val();

    if(user_roles!=null)
    {
        var user_roles= JSON.parse(user_roles);
        var roles=[];

        user_roles.forEach(function(role){
            roles.push(parseInt(role.role_id));
        });

        $('#roles_assign').val(roles).trigger('change');
    }

    var user_branches=$('#user_branches').val();

    if(user_branches!=null)
    {
        var user_branches= JSON.parse(user_branches);

        var branches=[];

        user_branches.forEach(function(branch){
            branches.push(parseInt(branch.branch_id));
        });

        $('#branches_assign').val(branches).trigger('change');
    }


    $('.select2').select2();


    //delete user
    $(document).on('click','.delete_user',function(e){
        e.preventDefault();
        var el=$(this);
        swal({
            title: trans("Are you sure to delete user ?"),
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: trans("Delete"),
            cancelButtonText: trans("Cancel"),
            closeOnConfirm: false
        }).then(function (e) {
            if (e.value === true) {
                $(el).parent().submit()
            } else {
                e.dismiss;
            }

        },  function (dismiss) {
            return false;
        });
    });

})(jQuery);
