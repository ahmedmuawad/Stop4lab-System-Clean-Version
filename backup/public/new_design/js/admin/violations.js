(function($){

    "use strict";

    //datatable

    var table = $('#violations_table').DataTable( {
        dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'i><'col-sm-8'p>>",
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
           "sLengthMenu": "Results :  _MENU_",
        },
        buttons: [
            { extend: 'copy', className: 'btn btn-sm mb-2' },
            { extend: 'csv', className: 'btn btn-sm mb-2' },
            { extend: 'excel', className: 'btn btn-sm mb-2' },
            { extend: 'print', className: 'btn btn-sm mb-2' },

           {
                text: trans('Duration Minutes'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 2 );
                    column.visible( ! column.visible() );
                }
            },
           {
                text: trans('Violations Hours'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 3 );
                    column.visible( ! column.visible() );
                }
            },
        ],

        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 10,
        "ajax": {
            url:url("new-design/admin/get_violations")
        },
        columns: [
            {data:"bulk_checkbox",searchable:false,sortable:false,orderable:false},
            {data:"id",sortable:true,orderable:true},
            {data:"duration",sortable:true,orderable:true},
            {data:"violations_mins",name:"violations_mins",sortable:true,orderable:true ,render:function(data){
                return (Math.floor(data / 60 )) + ":" + (data % 60 );
            }},
            {data:"action",sortable:false,searchable:false,orderable:false}
        ],
    } );


    //active
    // $('#users').addClass('active');
    // $('#users_roles_link').addClass('active');
    // $('#users_roles').addClass('menu-open');

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
    $(document).on('click','.delete_violations',function(e){
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
