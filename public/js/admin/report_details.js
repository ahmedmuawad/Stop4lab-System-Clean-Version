(function($){

     "use strict";
 
     //active
     $('#reports_details').addClass('active menu-open');
     $('#reports_details_link').addClass('active');
 

 
     //get branch select2 intialize
     $('#branch').select2({
       width:"100%",
       placeholder:trans("Branch"),
       multiple: true,
       ajax: {
          beforeSend:function()
          {
             $('.preloader').show();
             $('.loader').show();
          },
          url:ajax_url('get_branches_report'),
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
                   complete:function()
                   {
                      $('.preloader').hide();
                      $('.loader').hide();
                   }
                }
    });
     //get branch select2 intialize
     $('#branch_one').select2({
       width:"100%",
       placeholder:trans("Branch"),
       ajax: {
          beforeSend:function()
          {
             $('.preloader').show();
             $('.loader').show();
          },
          url:ajax_url('get_branches_report'),
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
                   complete:function()
                   {
                      $('.preloader').hide();
                      $('.loader').hide();
                   }
                }
    });
       
           //get users select2 intialize
    $('#user_id').select2({
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









 })(jQuery);