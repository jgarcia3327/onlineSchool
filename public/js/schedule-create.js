$(document).ready(function(){

    $( "#datepicker" ).datepicker({
      //dateFormat: 'DD, M dd, yy'
      dateFormat: 'yy-mm-dd'
    });

    // Display current date
    var dateStr = $( "#datepicker" ).val();
    getSavedDateTime(dateStr);
    // Display current date on-change
    $("#datepicker").change(function(){
        $(".loader").css({"display":"block"});
        $(".schedule-load").css({"display":"none"});
        date = new Date($( "#datepicker" ).val());
        dateStr = $( "#datepicker" ).val();
        //Find if selected date is already loaded
        if ($("#available-time").find(".schedule-load").hasClass(dateStr)){
          $("#available-time .schedule-load."+dateStr).css({"display":"block"});
          $(".loader").css({"display":"none"});
        }
        //load page if not
        else{
          getSavedDateTime(dateStr);
        }
    });

});

function getSavedDateTime(dateStr) {
  var request = $.ajax({
    url: "/schedule/ajax/"+dateStr,
    method: "GET",
    dataType: "html"
  });

  request.done(function( result ) {
    console.log(result);
    $( "#available-time" ).append( result );
    $(".loader").css({"display":"none"});
    //Checkbox change value
    $("input[type='checkbox']").change(function(){
      var sel = $(this).val().replace(/[\ \:]/g, "");
      if(this.checked){
        $("#selected-sched").append("<span class='text-success sel "+sel+"'>"+$(this).data("sched-date")+"</span>");
      }
      else{
        $("span").remove("."+sel);
      }
      //activate submit button
      if($("#selected-sched span").hasClass("sel")){
        $("#submit-selected").removeAttr("disabled");
        $(".none-selected").css({"display":"none"});
      }
      else{
        $("#submit-selected").attr({disabled : "disabled"});
        $(".none-selected").css({"display":"block"});
      }
    });
  });

  request.fail(function( jqXHR, textStatus ) {
    alert( "Request failed: " + textStatus );
  });
}
