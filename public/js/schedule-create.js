$(document).ready(function(){

    $( "#datepicker" ).datepicker({
      //dateFormat: 'DD, M dd, yy'
      dateFormat: 'yy-mm-dd'
    });

    // Display current date
    var date = new Date($( "#datepicker" ).val());
    getSavedDateTime(date, $( "#datepicker" ).val());
    // Display current date on-change
    $("#datepicker").change(function(){
        $(".loader").css({"display":"block"});
        $("#available-time").css({"display":"none"});
        date = new Date($( "#datepicker" ).val());
        getSavedDateTime(date, $( "#datepicker" ).val());
    });

});

function getSavedDateTime(date, dateStr) {
  var request = $.ajax({
    url: "/schedule/ajax/"+dateStr,
    method: "GET",
    dataType: "html"
  });

  request.done(function( result ) {
    console.log(result);
    $( "#available-time" ).html( result );
    $(".current-day").html(dateDisplayFormat(date));
    //populateCheckboxVal(date);
    $(".loader").css({"display":"none"});
    $("#available-time").css({"display":"block"});
  });

  request.fail(function( jqXHR, textStatus ) {
    alert( "Request failed: " + textStatus );
  });
}

/*
function populateCheckboxVal(date) {
  //Populate create-schedule form
  var yyyy = date.getFullYear();
  var mm = date.getMonth()+1 < 10 ? "0"+(date.getMonth()+1) : date.getMonth()+1;
  var dd = date.getDate() < 10 ? "0"+date.getDate() : date.getDate();
  var mysqlDateFormat = yyyy + '-' + mm + '-' + dd;
  $("#create-schedule input[type='checkbox']").each(function(){
    $(this).val(mysqlDateFormat + ' ' + $(this).data("start-time"));
  });
}*/

function dateDisplayFormat(date) {
  var months = [
    "January", "February", "March",
    "April", "May", "June", "July",
    "August", "September", "October",
    "November", "December"
  ];
  var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

  var dayName = days[date.getDay()];
  var day = date.getDate();
  var month = months[date.getMonth()];
  var year = date.getFullYear();

  return dayName + ', ' + month + ', ' + day + ' ' + year;
}
