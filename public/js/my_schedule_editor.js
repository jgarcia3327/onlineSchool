$(document).ready(function(){

    $( "#week-datepicker" ).datepicker({
      //dateFormat: 'DD, M dd, yy'
      dateFormat: 'yy-mm-dd',
      showWeek: true,
      firstDay: 1,
      //dayNamesMin: ["CN","T2","T3","T4","T5","T6","T7"],
      weekHeader: "Week"
    });

    // Display current date
    var dateStr = $( "#week-datepicker" ).val();
    if(window.location.href.indexOf("20") < 0 ) {
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
  window.location.href = "/adminScheduleEditor/"+dateStr;
}
