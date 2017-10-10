$(document).ready(function(){

    $( "#datepicker" ).datepicker({
      //dateFormat: 'DD, M dd, yy'
      dateFormat: 'yy-mm-dd',
      dayNamesMin: ["CN","T2","T3","T4","T5","T6","T7"],
      weekHeader: "Tuần"
    });

    // Display current date
    var dateStr = $( "#datepicker" ).val();
    getSavedDateTime(dateStr);
    // Display current date on-change
    $("#datepicker").change(function(){
        $(".loader").css({"display":"block"});
        $(".schedule-load").css({"display":"none"});
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
  var slicePoint = window.location.pathname.lastIndexOf('/');
  var length = window.location.pathname.length;
  var teacherId = window.location.pathname.substring(slicePoint+1, length);
  var request = $.ajax({
    url: "/reserveTeacher/ajax/"+dateStr+"|"+teacherId,
    method: "GET",
    dataType: "html"
  });

  request.done(function( result ) {
    //console.log(result);
    $( "#available-time" ).append( result );
    $(".loader").css({"display":"none"});
    //Checkbox change value
    $("input[type='checkbox']").change(function(){
      var sel = $(this).val();
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
      // Display number of selected items
      var $checkboxes = $('form input[type="checkbox"]');
      var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
      $(".selected-sched-count").text(countCheckedCheckboxes);
    });
  });

  request.fail(function( jqXHR, textStatus ) {
    alert( "Request failed: " + textStatus );
  });
}

function showSched() {
  if ($(".view-hide").text() == "View") {
    $(".view-hide").html("Hide");
    $("#selected-sched").css({"display":"block"});
  }
  else {
    $(".view-hide").html("View");
    $("#selected-sched").css({"display":"none"});
  }
}
