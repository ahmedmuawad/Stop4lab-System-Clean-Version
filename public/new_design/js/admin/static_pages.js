(function($){

    "use strict";

   $('#tips_form').validate({
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

    //change image
    $(document).on('change','#image',function(){
        var file=document.getElementById('image').files[0];
        getBase64(file);
    });

    //change image_intro_1
    $(document).on('change','#image_intro_1',function(){
        var file=document.getElementById('image_intro_1').files[0];
        getBase641(file);
    });

    //change image_intro_2
    $(document).on('change','#image_intro_2',function(){
        var file=document.getElementById('image_intro_2').files[0];
        getBase642(file);
    });

    //change image_intro_3
    $(document).on('change','#image_intro_3',function(){
        var file=document.getElementById('image_intro_3').files[0];
        getBase643(file);
    });

})(jQuery);


function getBase64(file) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    data=reader.onload = function () {
        $('#image_preview').attr('src',reader.result);
        $('#image_preview').parent('a').attr('href',reader.result);
    };
    reader.onerror = function (error) {
      console.log('Error: ', error);
    };
}
function getBase641(file) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    data=reader.onload = function () {
        $('#image_intro_1_preview').attr('src',reader.result);
        $('#image_intro_1_preview').parent('a').attr('href',reader.result);
    };
    reader.onerror = function (error) {
      console.log('Error: ', error);
    };
}
function getBase642(file) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    data=reader.onload = function () {
        $('#image_intro_2_preview').attr('src',reader.result);
        $('#image_intro_2_preview').parent('a').attr('href',reader.result);
    };
    reader.onerror = function (error) {
      console.log('Error: ', error);
    };
}
function getBase643(file) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    data=reader.onload = function () {
        $('#image_intro_3_preview').attr('src',reader.result);
        $('#image_intro_3_preview').parent('a').attr('href',reader.result);
    };
    reader.onerror = function (error) {
      console.log('Error: ', error);
    };
}