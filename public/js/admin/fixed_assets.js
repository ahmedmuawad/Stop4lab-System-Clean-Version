(function ($) {

    "use strict";

    //fixed_assets datatable
    table = $('#fixed_assets_table').DataTable({
        "lengthMenu": [[10, 25, 50, 100, 500, 1000, -1], [10, 25, 50, 100, 500, 1000, "All"]],
        dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'i><'col-sm-8'p>>",

        "processing": true,
        "serverSide": true,
        "order": [[1, "desc"]],
        fixedHeader: true,
        "ajax": {
            url: url("admin/fixed_asset/get_fixed_assets")
        },
        fixedHeader: true,
        "columns": [
            { data: "bulk_checkbox", searchable: false, sortable: false, orderable: false },
            { data: "id", orderable: true, sortable: true },
            { data: "name", orderable: false, sortable: false },
            { data: "price", orderable: false, sortable: false },
            { data: "branche.name", orderable: false, sortable: false },
            { data: "supplier.name", orderable: false, sortable: false },
            {
                "data": "image", "render": function (data, type, full, meta) {
                    return data ? '<img src="' + url('uploads/fixed_assets-avatar/' + data) + '" width="150px" height="80px">' : '---';
                }, orderable: false, sortable: false
            },
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

    //active
    $('#fixed_assets').addClass('active');


    $('#fixed_assets_form').validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true
            },
            address: {
                required: true
            },
            gender: {
                required: true
            },
            age: {
                required: true
            },
            age_unit: {
                required: true
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

    //delete fixed_assets
    $(document).on('click', '.delete_fixed_assets', function (e) {
        e.preventDefault();
        var el = $(this);
        swal({
            title: trans("Are you sure to delete fixed_assets ?"),
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
