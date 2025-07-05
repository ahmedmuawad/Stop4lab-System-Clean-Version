(function ($) {

    "use strict";
$('.rbcs-cbc').keyup(function() {
    var hct = $('.hematocrithct-cbc').val();
    var Hemoglobin = $('.hemoglobin-hb-cbc').val();
    var num = (hct / $(this).val()) * 10;
    var num2 = Hemoglobin / $(this).val() * 10
    $('.mcv-cbc').val(num.toFixed(2)).trigger('keyup');
    $('.mch-cbc').val(num2.toFixed(2)).trigger('keyup');
});
$('.pt-time').keyup(function() {
    var isi_settings = $('#isi_settings').val();
    console.log(isi_settings);
    var controlTime = $('.control-time').val();
    var res = ($('.pt-time').val() / controlTime) ** isi_settings;
    $('.inr').val(res.toFixed(2)).trigger('keyup');
    var inr = $('.inr').val();
    var res2 = (1 / inr) * 100;
    $('.activity').val(res2.toFixed(2)).trigger('keyup');
});
$('.hematocrithct-cbc').keyup(function() {
    var rpcs = $('.rbcs-cbc').val();
    var Hemoglobin = $('.hemoglobin-hb-cbc').val();
    var num = ($(this).val() / rpcs) * 10;
    var num2 = Hemoglobin / $(this).val() * 100;
    $('.mcv-cbc').val(num.toFixed(2)).trigger('keyup');
    $('.mchc-cbc').val(num2.toFixed(2)).trigger('keyup');
});
$('.hemoglobin-hb-cbc').keyup(function() {
    var rpcs = $('.rbcs-cbc').val();
    var hct = $('.hematocrithct-cbc').val();
    var num = rpcs / $(this).val() * 10;
    var num2 = $(this).val() / hct * 100;
    $('.mch-cbc').val(num.toFixed(2)).trigger('keyup');
    $('.mchc-cbc').val(num.toFixed(2)).trigger('keyup');
});

function the_rest_val() {

    var num1 = $('.lymphocytes-cbc').val();
    var num2 = $('.monocytes-cbc').val();
    var num3 = $('.eosinophils-cbc').val();
    var num4 = $('.basophils-cbc').val();
    var num5 = $('.neutrophil-cbc').val();

    if (num1 == '') {
        num1 = 0;
    }
    console.log("num1 = " + num1);
    if (num2 == '') {
        num2 = 0;
    }
    if (num3 == '') {
        num3 = 0;
    }
    if (num4 == '') {
        num4 = 0;
    }
    if (num5 == '') {
        num5 = 0;
    }

    var sum = (parseFloat(num1) + parseFloat(num2) + parseFloat(num3) + parseFloat(num4) + parseFloat(num5));

    $('#the_rest_val').val(100 - sum);
    $('#the_rest').html(100 - sum);
};
the_rest_val();

function the_rest(num) {
    the_rest_val();
}

$('.lymphocytes-cbc').change(function() {
    the_rest($(this).val());
});
$('.monocytes-cbc').change(function() {
    the_rest($(this).val());
});
$('.eosinophils-cbc').change(function() {
    the_rest($(this).val());
});
$('.basophils-cbc').change(function() {
    the_rest($(this).val());
});
$('.neutrophil-cbc').change(function() {
    the_rest($(this).val());
});

$('.lymphocytes-cbc').keyup(function() {
    var num = $('.wbcs-leukocytes-cbc').val() * $(this).val() / 100;
    $('.a-lymphocytes-cbc').val(num.toFixed(2)).trigger('keyup');
});
$('.monocytes-cbc').keyup(function() {
    var num = $('.wbcs-leukocytes-cbc').val() * $(this).val() / 100;
    $('.a-monocytes-cbc').val(num.toFixed(2)).trigger('keyup');
});
$('.eosinophils-cbc').keyup(function() {
    var num = $('.wbcs-leukocytes-cbc').val() * $(this).val() / 100;
    $('.a-eosinophils-cbc').val(num.toFixed(2)).trigger('keyup');
});
$('.basophils-cbc').keyup(function() {
    var num = $('.wbcs-leukocytes-cbc').val() * $(this).val() / 100;
    $('.a-basophils-cbc').val(num.toFixed(2)).trigger('keyup');
});
$('.neutrophil-cbc').keyup(function() {
    var num = $('.wbcs-leukocytes-cbc').val() * $(this).val() / 100;
    $('.a-neutrophil-cbc').val(num.toFixed(2)).trigger('keyup');
});
$('.segment-cbc').keyup(function() {
    var num = $('.wbcs-leukocytes-cbc').val() * $(this).val() / 100;
    $('.a-segment-cbc').val(num.toFixed(2)).trigger('keyup');
});
$('.band-cbc').keyup(function() {
    var num = $('.wbcs-leukocytes-cbc').val() * $(this).val() / 100;
    $('.a-band-cbc').val(num.toFixed(2)).trigger('keyup');
});
$('.wbcs-leukocytes-cbc').keyup(function() {
    var num1 = $('.lymphocytes-cbc').val() * $(this).val() / 100;
    var num2 = $('.monocytes-cbc').val() * $(this).val() / 100;
    var num3 = $('.eosinophils-cbc').val() * $(this).val() / 100;
    var num4 = $('.basophils-cbc').val() * $(this).val() / 100;
    var num5 = $('.neutrophil-cbc').val() * $(this).val() / 100;
    var num6 = $('.segment-cbc').val() * $(this).val() / 100;
    var num7 = $('.band-cbc').val() * $(this).val() / 100;
    $('.a-lymphocytes-cbc').val(num1.toFixed(2)).trigger('keyup');
    $('.a-monocytes-cbc').val(num2.toFixed(2)).trigger('keyup');
    $('.a-eosinophils-cbc').val(num3.toFixed(2)).trigger('keyup');
    $('.a-basophils-cbc').val(num4.toFixed(2)).trigger('keyup');
    $('.a-neutrophil-cbc').val(num5.toFixed(2)).trigger('keyup');
    $('.a-segment-cbc').val(num6.toFixed(2)).trigger('keyup');
    $('.a-band-cbc').val(num7.toFixed(2)).trigger('keyup');
});



$('.serum-triglycerides').keyup(function() {
    var res = parseFloat($(this).val()) / 5 ;
    $('.vldl-cholesterol').val(res.toFixed(2)).trigger('keyup');
});

$('.hdl-cholesterol').keyup(function() {
    var res = parseFloat($('.total-cholesterol').val()) - parseFloat($('.hdl-cholesterol').val()) - parseFloat($('.serum-triglycerides').val() / 5);
    $('.ldl-cholesterol').val(res.toFixed(2));
    $('.cholesterol-hdl').val(($('.total-cholesterol').val() / $('.hdl-cholesterol').val() ).toFixed(2));
    $('.risk-i').val(($('.total-cholesterol').val() / $('.hdl-cholesterol').val()).toFixed(2) );
    $('.ldl-hdl').val(($('.ldl-cholesterol').val() / $('.hdl-cholesterol').val()).toFixed(2));
    $('.risk-ii').val(($('.ldl-cholesterol').val() / $('.hdl-cholesterol').val()).toFixed(2));
});

$('.total-cholesterol').keyup(function() {
    var res = parseFloat($('.total-cholesterol').val()) - parseFloat($('.hdl-cholesterol').val()) - parseFloat($('.serum-triglycerides').val() / 5);

    $('.ldl-cholesterol').val(res.toFixed(2));
});


$('.urinary-albumin').keyup(function() {
    var res = parseFloat($('.urinary-albumin').val()) / parseFloat($('.urinary-creatinine').val());
    
    $('.albumin-creatinine-ratio').val(res.toFixed(2));
});

$('.urinary-creatinine').keyup(function() {
    var res = parseFloat($('.urinary-albumin').val()) / parseFloat($('.urinary-creatinine').val());
    
    $('.albumin-creatinine-ratio').val(res.toFixed(2));
});


$('.creatinine-in-serum').keyup(function() {
    var res1 = parseFloat($('.urine-volum').val()) * parseFloat($('.creatinine-urine').val());
    
    var res2 = parseFloat($('.creatinine-in-serum').val()) * 1440;
    
    var res3 = res1 / res2;
    
    $('.creatinine-clearance').val(res3.toFixed(2));
});

$('.creatinine-urine').keyup(function() {
    var res1 = parseFloat($('.urine-volum').val()) * parseFloat($('.creatinine-urine').val());
    
    var res2 = parseFloat($('.creatinine-in-serum').val()) * 1440;
    
    var res3 = res1 / res2;
    
    $('.creatinine-clearance').val(res3.toFixed(2));
});

$('.urine-volum').keyup(function() {
    var res1 = parseFloat($('.urine-volum').val()) * parseFloat($('.creatinine-urine').val());
    
    var res2 = parseFloat($('.creatinine-in-serum').val()) * 1440;
    
    var res3 = res1 / res2;
    
    $('.creatinine-clearance').val(res3.toFixed(2));
});



$('.glycosylated-hb-hba1c').keyup(function() {
    var res = 28.7 * parseFloat($('.glycosylated-hb-hba1c').val()) - 46.7 ;
    
    $('.estimated-average-glucose-at-the-past-3-months').val(res.toFixed(2));
});


$('.vldl-cholesterol').change(function() {
    var res = parseFloat($('.total-cholesterol').val()) - parseFloat($('.hdl-cholesterol').val()) - parseFloat($('.serum-triglycerides').val() / 5);
    $('.ldl-cholesterol').val(res.toFixed(2));
});



$('.direct-bilirubin').keyup(function() {
    var res = $('.total-bilirubin').val() - $('.direct-bilirubin').val();
    $('.indirect-bilirubin').val(res.toFixed(2));
});

$('.bilirubin-tota').keyup(function() {
    var res = $('.total-bilirubin').val() - $('.direct-bilirubin').val();
    $('.indirect-bilirubin').val(res.toFixed(2));
});

$('.psa-total').keyup(function() {
    var res = $('.psa-total').val() / $('.psa-free').val();
    
    $('.psa-ratio-result').val(res.toFixed(2));
});

$('.psa-free').keyup(function() {
    var res = $('.psa-total').val() / $('.psa-free').val();
    
    $('.psa-ratio-result').val(res.toFixed(2));
});

$('#cbc_api').click(function() {

    swal({
            title: trans("Are you Sure to Check CBC Resulte ?"),
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: trans("Check"),
            cancelButtonText: trans("Cancel"),
            closeOnConfirm: true
        },
        function() {
            if ($('.eosinophils-cbc').val() == '') {
                $('.lymphocytes-cbc').trigger('keyup');
                var num1 = $('.monocytes-cbc').val();
                var num2 = num1 * 0.25;
                var num3 = num1 - num2;
                $('.monocytes-cbc').val(num3.toFixed(2)).trigger('keyup');
                $('.eosinophils-cbc').val(num2.toFixed(2)).trigger('keyup');
                $('.basophils-cbc').val(0).trigger('keyup');
                var num5 = $('.neutrophil-cbc').val();
                var num6 = num5 * 0.95;
                var num7 = num5 * 0.05;
                $('.segment-cbc').val(num6.toFixed(2)).trigger('keyup');
                $('.band-cbc').val(num7.toFixed(2)).trigger('keyup');
            }
        });


});

$('.done-option').click(function() {



    var option_basic = $(this).closest('td').children('select.option_basic').val();
    var option_additional = $(this).closest('td').children('select.option_additional').val();
    var resulte_option = $(this).closest('td').children('textarea.resulte_option').val();
    var html = resulte_option + ' ' + option_basic + '('+ option_additional+'),';


    $(this).closest('td').children('textarea.resulte_option').val(html);

    // $('.option_basic').val('');
    $(".option_basic").select2("val", "");
    $(".option_additional").select2("val", "");
    // $('.option_additional').val('');
    // console.log($(this).closest('td').children('textarea.resulte_option'));
});

// $(document).on('change', '#reaction', function () {
//     // console.log($(this).val());
//     var reaction = $(this).val();
//     $('#crystals').empty().trigger("change");
//     if(reaction.includes("Acidic")){
//         // reactionResult = "Alkaline";
//         var data = ["Absent","Uric Acid","Amorphous Urates","Calcium oxalate","Cysteine","Cholesterol","Leucine"];
//         data.forEach(function($d){
//             let x = {
//                 id : $d,
//                 text : $d
//             };

//         var option = new Option(x.text, x.id, false, false);
//         $('#crystals').append(option).trigger('change');

//         });
        
//     }else if(reaction.includes("Alkaline")){
//         var data = ["Absent","Ammonium Urates","Triple phosphates","Amorphous Phosphates","Calcium oxalate"];
//         data.forEach(function($d){
//             let x = {
//                 id : $d,
//                 text : $d
//             };

//         var option = new Option(x.text, x.id, false, false);
//         $('#crystals').append(option).trigger('change');

//         });
//     }else if(reaction.includes("Neutral")){
//         var data = ["Absent"];
//         data.forEach(function($d){
//             let x = {
//                 id : $d,
//                 text : $d
//             };

//         var option = new Option(x.text, x.id, false, false);
//         $('#crystals').append(option).trigger('change');

//         });
//     }
    
//   });

  
})(jQuery);