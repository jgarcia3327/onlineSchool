$(document).ready(function() {

  // Data tables
  $('#future').DataTable( {
      "pageLength": 20,
      "lengthMenu": [ [10, 20, 50, -1], [10, 20, 50, "All"] ],
      "order": [[ 0, "asc" ]]
  } );
  $('#past').DataTable( {
      "pageLength": 20,
      "lengthMenu": [ [10, 20, 50, -1], [10, 20, 50, "All"] ],
      "order": [[ 0, "desc" ]]
  } );

  var searchParams = new URLSearchParams(window.location.search);
  if (searchParams.get("past") == "1") {
    viewPastSched();
  }

});

var refreshPage = '/adminScheduleList';
var refreshInterval = setInterval(function() {
  window.location.href = refreshPage;
}, 300000); // 5 mins

function viewFutureSched() {
  $("#past-schedule").css({"display":"none"});
  $("#future-schedule").css({"display":"block"});
  $(".future").addClass("active");
  $(".past").removeClass("active");
  refreshPage = '/adminScheduleList';
}
function viewPastSched() {
  $("#future-schedule").css({"display":"none"});
  $("#past-schedule").css({"display":"block"});
  $(".future").removeClass("active");
  $(".past").addClass("active");
  refreshPage = '/adminScheduleList/?past=1';
}
