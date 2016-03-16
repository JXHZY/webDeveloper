//Calaulator @YingZhou 03/14/2016
value1 = "";
value2 = "";
operate = "";
number = 0;     //0 means this is the first value, 1 means this is the second value
singal = 0;     //1 means already has two value and 1 action
string = "";

function cal(action,info){
  //Number
  if(action == "number")
  {
    if(number == 0)
    {
      value1 += info;
      string += info;
    }
    else if(number == 1)
    {
      string += info;
      value2 += info;
    }
  }
  //Action
  else if(action == "action")
  {
    if(singal == 0)
    {
      string += info;
      operate = info;
      number = 1;
      singal = 1;
    }
    else if(singal == 1)
    {
      string = "(" + string;
      string += ")" + info;
      answer('mul');
      operate = info;
      value2 = "";
    }
  }
  $("#input").html(string);
}

function answer(whichOne){
  var data = {
    "action": whichOne,
    "value1":value1,
    "value2":value2,
    "operate":operate,
    };
  data = $(this).serialize() + "&" + $.param(data);
  $.ajax({
    type: "POST",
    dataType: "text",
    url: "calculator.php",
    data: data,
    success: function(data) {
      console.info(data);
      if(whichOne == "=")
      {
          $("#input").html(string);
          $("#answer").html(data);
      }
      else if(whichOne == "mul")
      {
        value1 = data;
        $("#input").html(string);
        $("#answer").html(data);
      }
    }
  });
}

function clr(){
  value1 = "";
  value2 = "";
  action = "";
  number = 0;     
  singal = 0;
  string = "";
  $("#input").html("Input:");
  $("#answer").html("Answer:");
}

