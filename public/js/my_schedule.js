$(document).ready(function(){

    $( "#week-datepicker" ).datepicker({
      //dateFormat: 'DD, M dd, yy'
      dateFormat: 'yy-mm-dd',
      showWeek: true,
      firstDay: 1,
      dayNamesMin: ["CN","T2","T3","T4","T5","T6","T7"],
      weekHeader: "Tuần"
    });

    // Display current date
    var dateStr = $( "#week-datepicker" ).val();
    if(window.location.href.indexOf("my_") < 0 ) {
       //getSavedDateTimeAjax(dateStr);
       getSavedDateTime(dateStr);
    }
    // Display current date on-change
    $("#week-datepicker").change(function(){
        $(".loader").css({"display":"block"});
        $("#lessons-list").css({"display":"none"});
        dateStr = $( "#week-datepicker" ).val();
        console.log(dateStr);
        getSavedDateTime(dateStr);
    });

    //Lood week trigger
    $(document).on('click', '.ui-datepicker-next', function () {
      getWeekTrigger();
    })
    //Lood week trigger
    $(document).on('click', '.ui-datepicker-prev', function () {
      getWeekTrigger();
    })
    //Lood week trigger init
    getWeekTrigger();

});

function getWeekTrigger() {
  $("#week-datepicker .ui-datepicker-week-col").click(function(){
      var year = $("#week-datepicker .ui-datepicker-year").text();
      var week = $(this).text();
      dateStr = week+"_"+year;
      getSavedDateTime(dateStr);
  });
}

function getSavedDateTime(dateStr) {
  if(window.location.href.indexOf("/schedule/my_schedule/"+dateStr+"/#my-schedule") < 0 ) {
    window.location.href = "/schedule/my_schedule/"+dateStr+"/#my-schedule";
  }
  else {
    window.location.reload();
  }
}

function getSavedDateTimeAjax(dateStr) {
  var request = $.ajax({
    url: "/schedule/index_ajax/"+dateStr,
    method: "GET",
    dataType: "html"
  });
  request.done(function( result ) {
    $( "#lessons-list" ).html( result );
    $("#lessons-list").css({"display":"block"});
    $(".loader").css({"display":"none"});
  });
  request.fail(function( jqXHR, textStatus ) {
    alert( "Request failed: " + textStatus );
  });
}
