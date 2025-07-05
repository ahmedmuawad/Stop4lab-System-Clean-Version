(function($){

    "use strict";
    

    //active
    $('#reports').addClass('active menu-open');
    $('#reports_link').addClass('active');
    $('#accounting_report').addClass('active');

    //get doctor select2 intialize
    $('#doctor').select2({
      width:"100%",
      placeholder:trans("Doctor"),
      multiple: true,
      ajax: {
       beforeSend:function()
       {
          $('.preloader').show();
          $('.loader').show();
       },
       url:ajax_url('get_doctors'),
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

    //get test select2 intialize
    $('#test').select2({
        width:"100%",
        placeholder:trans("Test"),
        multiple: true,
        ajax: {
           beforeSend:function()
           {
              $('.preloader').show();
              $('.loader').show();
           },
           url:ajax_url('get_tests_select2'),
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

    //get culture select2 intialize
    $('#culture').select2({
        width:"100%",
        placeholder:trans("Culture"),
        multiple: true,
        ajax: {
           beforeSend:function()
           {
              $('.preloader').show();
              $('.loader').show();
           },
           url:ajax_url('get_cultures_select2'),
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

    //get culture select2 intialize
    $('#package').select2({
         width:"100%",
         placeholder:trans("Package"),
         multiple: true,
         ajax: {
            beforeSend:function()
            {
               $('.preloader').show();
               $('.loader').show();
            },
            url:ajax_url('get_packages_select2'),
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

    //get culture select2 intialize
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
         url:ajax_url('get_branches_select2'),
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

    //get culture select2 intialize
    $('#contract').select2({
      width:"100%",
      placeholder:trans("Contract"),
      multiple: true,
      ajax: {
         beforeSend:function()
         {
            $('.preloader').show();
            $('.loader').show();
         },
         url:ajax_url('get_contracts'),
         processResults: function (data) {
               return {
                     results: $.map(data, function (item) {
                        return {
                           text: item.title,
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

    //get labs select2 intialize
    $('#lab').select2({
      width:"100%",
      placeholder:trans("labs"),
      multiple: true,
      ajax: {
         beforeSend:function()
         {
            $('.preloader').show();
            $('.loader').show();
         },
         url:ajax_url('get_labs'),
         processResults: function (data) {
               return {
                     results: $.map(data, function (item) {
                        return {
                           text: item.lab_code + '-' + item.name ,
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


    //get representative select2 intialize
    $('#rep').select2({
      width:"100%",
      placeholder:trans("labs"),
      multiple: true,
      ajax: {
         beforeSend:function()
         {
            $('.preloader').show();
            $('.loader').show();
         },
         url:ajax_url('get_reps'),
         processResults: function (data) {
               return {
                     results: $.map(data, function (item) {
                        return {
                           text: item.name ,
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


  $(document).on('change', '#contract', function() {
   var contract_id = $(this).val();

   console.log(contract_id);

   var url = $('#contract').attr('data-url');

   // send request ajax
   $.ajax({
       url: url,
       type: 'GET',
       data: {
           contract_id: contract_id[0],
       },
       beforeSend: function() {
           $('.preloader').show();
           $('.loader').show();
       },
       success: function(data) {
           if (data.status == 'success') {
               if(data.lab_to_lab) {
                   $('.lab-to-lab').removeClass('d-none').addClass('d-block')
               } else {
                   $('.lab-to-lab').addClass('d-none').removeClass('d-block')
               }
           } else {
               console.log(data.message);
           }
       },
       complete: function() {
           $('.preloader').hide();
           $('.loader').hide();
       }
   });

});



})(jQuery);