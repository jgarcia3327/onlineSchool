// Photo upload
$(".photo-change").mouseup(function(){
  $(this).css({"display":"none"});
  $(".photo-form").css({"display":"block"});
});
$(".photo-cancel").mouseup(function(){
  $(".photo-change").css({"display":"inline"});
  $(".photo-form").css({"display":"none"});
});
$(".photo-form input[type=file]").change(function(){
  $(".photo-form input[type=submit]").removeAttr("disabled");
});
// Audio upload
$(".audio-change").mouseup(function(){
  $(this).css({"display":"none"});
  $(".audio-form").css({"display":"block"});
});
$(".audio-cancel").mouseup(function(){
  $(".audio-change").css({"display":"inline"});
  $(".audio-form").css({"display":"none"});
});
$(".audio-form input[type=file]").change(function(){
  $(".audio-form input[type=submit]").removeAttr("disabled");
});
