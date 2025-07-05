(function($){

    "use strict";

    //datatable
    table=$('#reports_table').DataTable( {
        "lengthMenu": [[10, 25, 50,100,500,1000, -1], [10, 25, 50,100,500,1000 ,"All"]],
        dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4'i><'col-sm-8'p>>",

        "processing": true,
        "serverSide": true,
        "bSort" : true,
          "ajax": {
              url:url("admin/get_employees")
          },
          // orderCellsTop: true,
          fixedHeader: true,
          "columns": [
            {data:"bulk_checkbox",searchable:false,sortable:false,orderable:false},
            {data:"id",sortable:true,orderable:true},
            {data:"user.name",sortable:true,orderable:true},
            // {data:"user.roles",sortable:true,orderable:true},
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
            // {data:"violations",sortable:false,orderable:false},
            // {data:"vocations",sortable:false,orderable:false},
            {data:"job_start",sortable:false,orderable:false},
            // {data:"age",sortable:false,orderable:false},
            {data:"action",sortable:false,searchable:false,orderable:false}
          ],
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
        },
        function(){
            $(el).parent().submit();
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
        },
        function(){
            $(el).parent().submit();
        }
        );
    });

})(jQuery);
