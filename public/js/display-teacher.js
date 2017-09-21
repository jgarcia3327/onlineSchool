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
    getSavedDateTime(dateStr);
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
      $(".loader").css({"display":"block"});
      $("#lessons-list").css({"display":"none"});
      var year = $("#week-datepicker .ui-datepicker-year").text();
      var week = $(this).text();
      dateStr = week+"_"+year;
      getSavedDateTime(dateStr);
  });
}

function getSavedDateTime(dateStr) {
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
