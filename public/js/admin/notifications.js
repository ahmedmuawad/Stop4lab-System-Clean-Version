(function ($) {

    "use strict";

    //notifications datatable
    table = $('#notifications_table').DataTable({
        "lengthMenu": [[10, 25, 50, 100, 500, 1000, -1], [10, 25, 50, 100, 500, 1000, "All"]],
        dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'i><'col-sm-8'p>>",

        "processing": true,
        "serverSide": true,
        "order": [[1, "desc"]],
        fixedHeader: true,
        "ajax": {
            url: url("admin/notification/get_notifications")
        },
        fixedHeader: true,
        "columns": [
            { data: "bulk_checkbox", searchable: false, sortable: false, orderable: false },
            { data: "id", orderable: true, sortable: true },
            { data: "content", orderable: true, sortable: true },
            {"data":"image", "render": function (data, type, full, meta) {
                if(data)
                {
                    return '<img src="'+url('uploads/notifications-avatar/'+data)+'" width="150px" height="80px">';
                } else 
                {
                    return '----';
                }
            }, orderable:false,sortable:false},
            // { data: "user.name", orderable: false, sortable: false },
            { data: "action", searchable: false, orderable: false, sortable: false } // action
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

    //active
    $('#notifications').addClass('active');


    $('#notifications_form').validate({
        rules: {
            content: {
                required: true
            },
            type: {
                required: true,
                email: true
            },

        },
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

    //delete notifications
    $(document).on('click', '.delete_notifications', function (e) {
        e.preventDefault();
        var el = $(this);
        swal({
            title: trans("Are you sure to delete notifications ?"),
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

    //change avatar
    $(document).on('change', '#avatar', function () {
        var file = document.getElementById('avatar').files[0];
        getBase64(file);
    });

})(jQuery);


function getBase64(file) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    data = reader.onload = function () {
        $('#patient_avatar').attr('src', reader.result);
        $('#patient_avatar').parent('a').attr('href', reader.result);
    };
    reader.onerror = function (error) {
        console.log('Error: ', error);
    };
}


// click button
$(document).on('change', '#type', function () {
    // get data attr option selected
    var content = $(this).find('option:selected').attr('data-content');

    $('#append-content').html(content == undefined ? '' : content);

    var select = $('.select2');
    select.each(function () {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>');
        $this.select2({
            // the following code is used to disable x-scrollbar when click in select input and
            // take 100% width in responsive also
            dropdownAutoWidth: true,
            width: '100%',
            dropdownParent: $this.parent()
        });
    });
    $('#patient_ids').select2({
        width: "100%",
        placeholder: trans("Patient Name"),
        ajax: {
            beforeSend: function() {
                $('.preloader').show();
                $('.loader').show();
            },
            url: ajax_url('get_patient_by_name'),
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

});