$("document").ready(function(){
  $("#read").submit(function(){
    var data = {
      "action": "readfilejson"
    };
    data = $(this).serialize() + "&" + $.param(data);
    console.info(data);
    $.ajax({
      type: "POST",
      dataType: "text",
      url: "readfile_way1.php",
      data: data,
      success: function(data) {
        $("#information").text(
          data
        );
      }
    });
    return false;
  });
});