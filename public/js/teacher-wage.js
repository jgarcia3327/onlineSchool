$(document).ready(function(){

  $("#teacher-wage-submit").click(function(event) {
    var form = $("form#teacher-wage");
    var year = form.find("select[name='year']").val();
    var month = form.find("select[name='month']").val();
    var pitch = form.find("select[name='pitch']").val();
    window.location.href = "/wage/"+year+"-"+month+"-"+pitch;
    event.preventDefault();
  });

});
