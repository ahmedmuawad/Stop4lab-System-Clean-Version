(function($){

    "use strict";

    //active
    $('#branches').addClass('active');

    //branches datatable
    table=$('#branches_table').DataTable( {
      "lengthMenu": [[10, 25, 50,100,500,1000, -1], [10, 25, 50,100,500,1000 ,"All"]],
      dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-4'i><'col-sm-8'p>>",

      "processing": true,
      "serverSide": true,
      "ajax": {
        url: url("admin/get_branches")
      },
      fixedHeader: true,
      "columns": [
        {data:"bulk_checkbox",searchable:false,sortable:false,orderable:false},
        {data:"id",sortable:true,orderable:true},
        {data:"name",sortable:true,orderable:true},
        {data:"phone",sortable:false,orderable:false},
        {data:"address",sortable:false,orderable:false},
        {data:"custody",sortable:false,orderable:false},
        {data:"action",searchable:false,orderable:false,sortable:false}//action
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

    //delete branch
    $(document).on('click','.delete_branch',function(e){
      e.preventDefault();
      var el=$(this);
      swal({
        title: trans("Are you sure to delete branch ?"),
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

})(jQuery);

let marker;
let map;
let branch_lat=parseFloat($('#branch_lat').val());
let branch_lng=parseFloat($('#branch_lng').val());
let zoom_level=parseInt($('#zoom_level').val());

if(isNaN(branch_lat)||isNaN(branch_lng)||isNaN(zoom_level))
{
    branch_lat=26.8206;
    branch_lng=30.8025;
    zoom_level=4;
}

function initMap() {

    const myLatlng = { lat: branch_lat, lng: branch_lng};

    map = new google.maps.Map(document.getElementById("map"), {
      zoom: zoom_level,
      center: myLatlng
    });

    marker = new google.maps.Marker({
      position: myLatlng,
      map,
      title: "Click to zoom"
    });

    map.addListener('click', function(e) {
        placeMarkerAndPanTo(e.latLng, map);
    });
  }

  function placeMarkerAndPanTo(latLng, map) {
      marker.setMap(null);
      marker = new google.maps.Marker({
        position: latLng,
        map: map
      });
      //set branch lat and lng
      $('#branch_lat').val(latLng.lat());
      $('#branch_lng').val(latLng.lng());
      $('#zoom_level').val(map.getZoom());

  }



