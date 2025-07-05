$(document).ready(function() {

     var table = $('#fixed_assets_table').DataTable( {
        "dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
           "sLengthMenu": "Results :  _MENU_",
        },
        buttons: [
            { extend: 'copy', className: 'btn btn-sm' },
            { extend: 'csv', className: 'btn btn-sm' },
            { extend: 'excel', className: 'btn btn-sm' },
            { extend: 'print', className: 'btn btn-sm' }

        ],

         "stripeClasses": [],
         "lengthMenu": [7, 10, 20, 50],
         "pageLength": 10,
         "ajax": {
             url: url("new-design/admin/fixed_asset/get_fixed_assets")
         },
         columns: [
            // { data: "bulk_checkbox", searchable: false, sortable: false, orderable: false },
            // { data: "id", orderable: true, sortable: true },
            { data: "name", orderable: false, sortable: false },
            { data: "price", orderable: false, sortable: false },
            { data: "branche.name", orderable: false, sortable: false },
            { data: "supplier.name", orderable: false, sortable: false },
            { data: "action", searchable: false, orderable: false, sortable: false }//action
         ],
     } );



    //active
    $('#fixed_assets').addClass('active');


    $('#fixed_assets_form').validate({
        rules: {
            name: {
                required: true
            },
            price: {
                required: true,
                email: true
            },
            branche_id: {
                required: true
            },
            supplier_id: {
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
  //delete patient
  $(document).on('click','.delete_fixed_assets',function(e){
    e.preventDefault();
    var el=$(this);
    swal({
        title: trans("Are you sure to delete product ?"),
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
