(function($){
        
    "use strict";
    //active
    $('#profile').addClass('active');
    
    //remove the general validation and assign a new validation for the profile form
    $('#profile_form').removeData('validator');
    $('#profile_form').validate({
        rules:{
            name:{
                required:true,
            },
            email:{
                required:true,
            },
            password:{
                required:function(){
                    return $('#password_confirmation').val()!="";
                },
            },
            password_confirmation:{
                required:function(){
                    return $('#password').val()!="";
                },
                equalTo:"#password"
            }
        },
        messages:{
            password_confirmation:{
                equalTo:trans("Password confirmation does not match password")
            }
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

     //delete avatar
     $(document).on('click', '#delete_avatar', function () {
        $('#avatar').val(null);
        $('#patient_avatar').attr('src', url('img/avatar.png'));
        $('#patient_avatar').parent('a').attr('href', url('img/avatar.png'));

        $.ajax({
            url: ajax_url('delete_user_avatar_by_user'),
            beforeSend: function () {
                $('.preloader').show();
                $('.loader').show();
            },
            success: function () {
                toastr_success(trans('Avatar deleted successfully'));
            },
            complete: function () {
                $('.preloader').hide();
                $('.loader').hide();
            }
        });
    });

    $(document).on('change','#type',function(e){

        var el=$(this);
        $("#select_time").html(``);
        if(el.val() == 0){
            $("#select_time").append(`<div class="col-lg-4">
            <div class="form-group">
                <label class="form-label" for="durations">Duration</label>
                <input type="number" class="form-control" placeholder="Duration" name="durations" id="durations" required>
            </div>
        </div>
    
        <div class="col-lg-4">
            <div class="form-group">
                <label class="form-label" for="day">Day</label>
                <input type="date" class="form-control" name="day" id="day" required>
            </div>
        </div>`);

        }else{
            $("#select_time").append(`<div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="request_from">Request From</label>
                <input type="datetime-local" class="form-control " name="request_from" id="request_from" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="request_to">Request To</label>
                <input type="datetime-local" class="form-control " name="request_to" id="request_to" required >
            </div>
        </div>`);
        }
    });

})(jQuery);
