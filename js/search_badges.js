$(document).ready(function(){
  $("#badgeSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#badges button").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
