
(function($){

  "use strict";

  var date=new Date();
  var current_year=date.getFullYear();

  //active
  $('#dashboard').addClass('active');

  //datatable
  $('.datatable').DataTable();

  //change status
  $(document).on('click','label',function(){
    var id=$(this).prev('input').attr('visit-id');
    $.ajax({
        type:'post',
        url:ajax_url("change_visit_status/"+id),
        success:function(message)
        {
            toastr.success(message);
        }
    })
  });


  $('#filter_income').datepicker( {
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'mm-yy',
    yearRange:"1900:"+current_year,
    onClose: function(dateText, inst) {
        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        $(this).datepicker('setDate', new Date(year, month, 1));
        $(this).trigger('change');
    },
  });

  //filter general statistics
  $(document).on('change','#filter_statistics',function(){
    filter_statistics();
  });

  //filter income by date
  $(document).on('change','#filter_income',function(){
    income_chart_statistics();
  });

  //filter income by branch
  $(document).on('change','#filter_income_branch',function(){
    income_chart_statistics();
  });

  //filter best packages by  date
  $(document).on('change','#filter_best_package_date',function(){
    best_packages();
  });

  //filter best packages by branch
  $(document).on('change','#filter_best_package_branch',function(){
    best_packages();
  });

  //filter best tests by  date
  $(document).on('change','#filter_best_test_date',function(){
    best_tests();
  });

  //filter best tests by branch
  $(document).on('change','#filter_best_test_branch',function(){
    best_tests();
  });

  //filter best cultures by  date
  $(document).on('change','#filter_best_culture_date',function(){
    best_cultures();
  });

  //filter best cultures by branch
  $(document).on('change','#filter_best_culture_branch',function(){
    best_cultures();
  });

  //get online users
  if(can_view_online_admins)
  {
    get_online_admins();
  }

  //get online patients
  if(can_view_online_patients)
  {
    get_online_patients();
  }

  setInterval(function(){
    if(can_view_online_admins)
    {
      get_online_admins();
    }
    if(can_view_online_patients)
    {
      get_online_patients();
    }
  }, 30000);

})(jQuery);


//get online admins
function get_online_admins()
{
  $.ajax({
    url:ajax_url('online_admins'),
    success:function(admins)
    {
      if(admins.length==0)
      {
        $('.online_admins_list').html(`
        <li class="item text-center">
          <p class="text-danger">`+trans("No admins online")+`</p>
        </li>
        `);
      }
      else{
        var html='';
        admins.forEach(admin => {
          html+=`<li class="item">
                  <a href="`+url('admin/users/'+admin.id+'/edit')+`" class="text-white">
                    <i class="fas fa-check-circle text-success"></i> <p class="d-inline">`+admin.name+`</p>
                  </a>
                  </li>`;
        });
        $('.online_admins_list').html(html);
      }

      $('.online_admins_count').text(admins.length);

    }
  });
}


//get online admins
function get_online_patients()
{
  $.ajax({
    url:ajax_url('online_patients'),
    success:function(patients)
    {
      if(patients.length==0)
      {
        $('.online_patients_list').html(`
        <li class="item text-center">
          <p class="text-danger">`+trans("No patients online")+`</p>
        </li>
        `);
      }
      else{
        var html='';
        patients.forEach(patient => {
          html+=`<li class="item">
                    <a href="`+url('admin/patients/'+patient.id+'/edit')+`" class="text-white">
                      <i class="fas fa-check-circle text-success"></i> <p class="d-inline">`+patient.name+`</p>
                    </a>
                  </li>`;
        });
        $('.online_patients_list').html(html);
      }

      $('.online_patients_count').text(patients.length);

    }
  });
}

//statistics
function filter_statistics()
{
  var date=$('#filter_statistics').val();

  $.ajax({
      url:ajax_url('get_statistics'+'?date='+date),
      beforeSend:function(){
        $('.preloader').show();
        $('.loader').show();
      },
      success:function(data)
      {
        for (const [key, value] of Object.entries(data)) {
          $('#'+key).text(value);
        }
      },
      complete:function()
      {
        $('.preloader').hide();
        $('.loader').hide();
      }
  });
}



//best packages chart
function best_packages()
{
  var date=$('#filter_best_package_date').val();
  var branch_id=$('#filter_best_package_branch').val();

  $.ajax({
    url:ajax_url('get_best_income_packages')+'?date='+date+'&branch_id='+branch_id,
    success:function(response){
      $('#best_packages_chart').remove();
      $('#best_packages').append(`
        <canvas id="best_packages_chart" width="80" height="80"></canvas>
      `);
      var ctx = document.getElementById('best_packages_chart');
      var myChart = new Chart(ctx, {
          type: 'doughnut',
          data: response.data,
          options:{
            legend: {
              labels: {
                  fontColor: response.font_color,
              }
            },
          },
          plugins: [{
            beforeInit: function(chart, options) {
              chart.legend.afterFit = function() {
                this.height = this.height + 30;
              };
            }
          }]
      });
    }
  });

}

//best tests chart
function best_tests()
{
  var date=$('#filter_best_test_date').val();
  var branch_id=$('#filter_best_test_branch').val();

  $.ajax({
    url:ajax_url('get_best_income_tests')+'?date='+date+'&branch_id='+branch_id,
    success:function(response){
      $('#best_tests_chart').remove();
      $('#best_tests').append(`
        <canvas id="best_tests_chart" width="80" height="80"></canvas>
      `);

      var ctx = document.getElementById('best_tests_chart');
      var myChart = new Chart(ctx, {
          type: 'doughnut',
          data: response.data,
          options:{
            legend: {
              labels: {
                  fontColor: response.font_color,
              }
            },
          },
          plugins: [{
            beforeInit: function(chart, options) {
              chart.legend.afterFit = function() {
                this.height = this.height + 30;
              };
            }
          }]
      });
    }
  });

}

//best cultures chart
function best_cultures()
{
  var date=$('#filter_best_culture_date').val();
  var branch_id=$('#filter_best_culture_branch').val();

  $.ajax({
    url:ajax_url('get_best_income_cultures')+'?date='+date+'&branch_id='+branch_id,
    success:function(response){
      $('#best_cultures_chart').remove();
      $('#best_cultures').append(`
        <canvas id="best_cultures_chart" width="80" height="80"></canvas>
      `);

      var ctx = document.getElementById('best_cultures_chart');
      var myChart = new Chart(ctx, {
          type: 'doughnut',
          data: response.data,
          options:{
            legend: {
              labels: {
                  fontColor: response.font_color,
              }
            },
          },
          plugins: [{
            beforeInit: function(chart, options) {
              chart.legend.afterFit = function() {
                this.height = this.height + 30;
              };
            }
          }]
      });
    }
  });


}

//income chart
if(can_view_income_statistics)
{
  income_chart_statistics2();
}
function income_chart_statistics2()
{

  $.ajax({
    url:ajax_url('get_income_chart2'),
    beforeSend:function(){
      $('.preloader').show();
      $('.loader').show();
    },
    success:function(response)
    {

      console.log(response);

      var d_1options1_new = {
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
              show: false,
            }
        },
        colors: ['#622bd7', '#ffbb44'],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded',
                borderRadius: 10,
        
            },
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '14px',
            markers: {
                width: 10,
                height: 10,
                offsetX: -5,
                offsetY: 0
            },
            itemMargin: {
                horizontal: 10,
                vertical: 8
            }
        },
        grid: {
          borderColor: '#191e3a',
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
      
      
        series: response.data,
        //   {
        //     name: 'Direct',
        //     data: [58, 44, 55, 57, 56, 61, 58, 63, 60, 66, 56, 63]
        //   },
        //   {
        //     name: 'Organic',
        //     data: [91, 76, 85, 101, 98, 87, 105, 91, 114, 94, 66, 70]
        // }
      
      
      
      
        xaxis: {
            // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            categories: response.categories,
        },
      
      
        fill: {
          type: 'gradient',
          gradient: {
            type: 'vertical',
            shadeIntensity: 0.3,
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 0.8,
            stops: [0, 100]
          }
        },
        tooltip: {
            marker : {
                show: false,
            },
            y: {
                formatter: function (val) {
                    return val
                }
            }
        },
        responsive: [
            { 
                breakpoint: 767,
                options: {
                    plotOptions: {
                        bar: {
                            borderRadius: 0,
                            columnWidth: "50%"
                        }
                    }
                }
            },
        ]
        }
      
      var d_1C_3 = new ApexCharts(
        document.querySelector("#uniqueVisits2"),
        d_1options1_new
      );
      
      d_1C_3.render();


    },
    complete:function(){
      $('.preloader').hide();
      $('.loader').hide();
    }
  });

}


