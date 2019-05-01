$(document).ready(function(){
  $("#userSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#users button").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
