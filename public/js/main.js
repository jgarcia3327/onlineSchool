$(document).ready(function(){

    $( "#datepicker" ).datepicker({
      dateFormat: 'DD, M dd, yy'
    });

    $(".current-day").html($( "#datepicker" ).val());

    $("#datepicker").change(function(){
        $(".current-day").html($( "#datepicker" ).val());
    });
});
