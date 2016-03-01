$(document).ready(function(){
  var data = {
    "action": "first",
    };
  data = $(this).serialize() + "&" + $.param(data);
  $.ajax({
    type: "POST",
    dataType: "text",
    url: "catalogue.php",
    data: data,
    success: function(data) {
        $("#col1").html(data);
    }
  });
});

function subside(id,deep){
  var data = {
    "action": "fatherid",
    "fatherid":id,
    "deep":deep
    };
  data = $(this).serialize() + "&" + $.param(data);
  $.ajax({
    type: "POST",
    dataType: "text",
    url: "catalogue.php",
    data: data,
    success: function(data) {
      switch(Number(deep)){
      case 1:
        $("#col2").html(data);
        $("#col3").html("");
        $("#col4").html("");
        $("#col5").html("");
        break;
      case 2:
        $("#col3").html(data);
        $("#col4").html("");
        $("#col5").html("");
        break;
      case 3:
        $("#col4").html(data);
        $("#col5").html("");
        break;
      case 4:
        $("#col5").html(data);
        break;
      }
    }
  });
}

