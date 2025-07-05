(function($){

  "use strict";

  //sampleTypes datatable
  table=$('#sampleTypes_table').DataTable( {
      "lengthMenu": [[10, 25, 50,100,500,1000, -1], [10, 25, 50,100,500,1000 ,"All"]],
      dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-4'i><'col-sm-8'p>>",
      buttons: [
          {
              extend:    'excelHtml5',
              text:      '<i class="fas fa-file-excel"></i> '+trans("Excel"),
              titleAttr: 'Excel'
          },
          {
              extend:    'csvHtml5',
              text:      '<i class="fas fa-file-csv"></i> '+trans("CVS"),
              titleAttr: 'CSV'
          },
          {
            extend:    'colvis',
            text:      '<i class="fas fa-eye"></i>',
            titleAttr: 'PDF'
          }
      ],
      "processing": true,
      "serverSide": true,
      "order": [[ 1, "desc" ]],
      "ajax": {
          url: url("new-design/admin/get_sampleTypes")
      },
      fixedHeader: true,
      "columns": [
          {data:"bulk_checkbox",searchable:false,sortable:false,orderable:false},
          {data:"id",orderable:true,sortable:true},
          {data:"name_ar",orderable:false,sortable:false},
          {data:"name_en",orderable:false,sortable:false},
          // {data:"action",searchable:false,orderable:false,sortable:false}//action
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
 $('#sampleTypes').addClass('active');


 $('#sampleTypes_form').validate({
     rules:{
         name:{
             required:true
         },
         email:{
             required:true,
             email:true
         },
         phone:{
             required:true
         },
         address:{
             required:true
         },
         gender:{
             required:true
         },
         age:{
             required:true
         },
         age_unit:{
             required:true
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

 //delete sampleTypes
  $(document).on('click','.delete_sampleTypes',function(e){
      e.preventDefault();
      var el=$(this);
      swal({
          title: trans("Are you sure to delete sampleTypes ?"),
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
  $(document).on('change','#avatar',function(){
      var file=document.getElementById('avatar').files[0];
      getBase64(file);
  });

})(jQuery);


function getBase64(file) {
  var reader = new FileReader();
  reader.readAsDataURL(file);
  data=reader.onload = function () {
      $('#patient_avatar').attr('src',reader.result);
      $('#patient_avatar').parent('a').attr('href',reader.result);
  };
  reader.onerror = function (error) {
    console.log('Error: ', error);
  };
}
var consumption_count=$('#consumption_count').val();
$(document).on('click','.add_sample_type',function(){
    consumption_count++;
    $(this).parent().parent().find('.sample_types').append(`
      <tr class="sample_type_row">

        <td>
          <div class="form-group">
            <input type="text" class="form-control" name="sample_type[]" placeholder="`+trans("Sample Type")+`" required>
          </div>
        </td>
        <td>
          <button type="button" class="btn btn-sm btn-danger delete_sample_type">
            <i class="fa fa-trash"></i>
          </button>
        </td>
      </tr>
    `);

});

//delete consumption
$(document).on('click','.delete_sample_type',function(){
    $(this).closest('.sample_type_row').remove();
});
