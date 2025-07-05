(function($){

    "use strict";

    //datatable

    var table = $('#employee_table').DataTable( {
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
                text: trans('Name'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 2 );
                    column.visible( ! column.visible() );
                }
            },
           {
                text: trans('Salary'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 3 );
                    column.visible( ! column.visible() );
                }
            },
           {
                text: trans('Type'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 4 );
                    column.visible( ! column.visible() );
                }
            },
           {
                text: trans('From'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 5 );
                    column.visible( ! column.visible() );
                }
            },
           {
                text: trans('To'),
                className: 'btn btn-primary btn-sm toggle-vis mb-1',
                action: function(e, dt, node, config ) {
                    var column = table.column( 6 );
                    column.visible( ! column.visible() );
                }
            },
        ],

        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 10,
        "ajax": {
            url:url("new-design/admin/get_employees")
        },
        columns: [
            {data:"bulk_checkbox",searchable:false,sortable:false,orderable:false},
            {data:"id",sortable:true,orderable:true},
            {data:"user.name",sortable:true,orderable:true},
            {data:"salary",sortable:true,orderable:true},
            {data:'type',name:'type',sortable:false,orderable:false,render: function(data){
                if(data == 0){
                    return trans('flexable');
                }else{
                    return trans('fixed');
                }
            }},
            {data:"shift_start",sortable:false,orderable:false},
            {data:"shift_end",sortable:false,orderable:false},
            {data:"job_start",sortable:false,orderable:false},
            {data:"action",sortable:false,searchable:false,orderable:false}
        ],
    } );

    //active
    $('#hr').addClass('active');
    $('#users_roles_link').addClass('active');
    $('#hr').addClass('menu-open');

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
    $(document).on('click','.delete_employee',function(e){
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

    $(document).on('change','#type',function(e){

        var el=$(this);
        $("#shift").html(``);
        if(el.val() == 0){
            $("#shift").append(`<div class="col-lg-12">
            <div class="form-group">
                <label class="form-label" for="works_mins">Working Hours</label>
                <input type="number" class="form-control " placeholder="Working Hours" name="works_mins" id="works_mins" @if(isset($employee)) value="{{$employee['shift_end']}}" @elseif(old('shift_end')) value="{{old('shift_end')}}" @endif required>
            </div>
        </div>`);

        }else{
            $("#shift").append(`<div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="shift_start">Start Shift</label>
                <input type="time" class="form-control " placeholder="Start Shift" name="shift_start" id="shift_start" @if(isset($employee)) value="{{$employee['shift_start']}}" @elseif(old('shift_start')) value="{{old('shift_start')}}" @endif required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="shift_end">End Shift</label>
                <input type="time" class="form-control " placeholder="End Shift" name="shift_end" id="shift_end" @if(isset($employee)) value="{{$employee['shift_end']}}" @elseif(old('shift_end')) value="{{old('shift_end')}}" @endif required>
            </div>
        </div>`);
        }
    });


    $(document).on('select2:select', '#user_id', function(e) {
        var el = $(e.target);
        var data = e.params.data;
        $.ajax({
            url: ajax_url('get_user_info' + '?id=' + data.id),
            success: function(patient) {
                $("#phone").val(patient.phone);
                $("#address").val(patient.address);
                $("#job").val(patient.roles[0].role.name);
            },
        });
    });

    $(document).on('click','.delete_employee',function(e){
        e.preventDefault();
        var el=$(this);
        swal({
            title: trans("Are you sure to delete employee ?"),
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
