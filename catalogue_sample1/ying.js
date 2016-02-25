var jsonInfo = new Array();

function ReadText()
{
  $.ajax({
   type:"POST",
   url:"spices.txt",
   data:"text",
   success: function(msg){
    var substring = msg.split("\r\n");
    var i = 0;      //the json Array's index
    var index = 0;  //substring's index
    var number = "";
    var details = "";
    var level = "";
    var keep;
    var obj;
    var totallength = substring.length;
    //handle the information by line 
    while(totallength>0)
    {
      //this is the first line's information
      if(i == 0)
      {
          var information= substring[index].split(" ");
          //handle the number by ".", and also get how deep it is
          var help1 = information[0].split(".");
          level = help1.length;
          var help2 = help1.length-1;
          number = help1[0];
          var j = 1;
          while(help2>0)
          {
            number = number + help1[j];
            j++;
            help2--;
          }
          //handle the string
          details = substring[index].slice(information[0].length+1,substring[index].length);
          //make the string in json style
          keep = '{"number":"'+number+'","details":"'+details+'","level":"'+level+'"}';
          //change string to JSON
          obj = JSON.parse(keep);
          jsonInfo[i] = obj;
          i++;
      }
      else
      {
        var testlength = substring[index].split(".");
        //length>=2 has the number information
        if(testlength.length>=2)
        {
          var information= substring[index].split(" ");
          //handle the number by ".", and also get how deep it is
          var help1 = information[0].split(".");
          level = help1.length;
          var help2 = help1.length-1;
          number = help1[0];
          var j = 1;
          while(help2>0)
          {
            number = number + help1[j];
            j++;
            help2--;
          }
          //handle the string
          details = substring[index].slice(information[0].length+1,substring[index].length);
          //make the string in json style
          keep = '{"number":"'+number+'","details":"'+details+'","level":"'+level+'"}';
          //change string to JSON
          obj = JSON.parse(keep);
          jsonInfo[i] = obj;
          i++;
        }
        //doesn't has the number
        else
        {
          jsonInfo[i-1].details = jsonInfo[i-1].details + "\r\n" + substring[index];
        }
      }
      index++;
      totallength--;
    }//end while
   }
 });
}

$(document).ready(function(){
  //for the first col
  $("div.firstline").click(function(){
    var numberId = $(this).attr('id');
    var index = 0;
    var jsonlength = jsonInfo.length;
    var id;
    var keep;
    var out="";
    while(jsonlength>0)
    {
      if((jsonInfo[index].level=='2')&&(jsonInfo[index].number[0]==numberId))
      {
        id=jsonInfo[index].level+jsonInfo[index].number;
        keep = '<div class="row smallline" id="'+id+'" onclick="subside('+id+')"> '+jsonInfo[index].details+'</div>';
        out += keep;
      }
      index++;
      jsonlength--;
    }
    document.getElementById("summery").innerHTML = "Now it is in level 2!!!!!!";
    document.getElementById("col2").innerHTML = out;
    document.getElementById("col3").innerHTML = "";
    document.getElementById("col4").innerHTML = "";
    document.getElementById("col5").innerHTML = "";
  });//end for the first col
});

function subside(id){
  var numberId = id.toString();
  var deep = (Number(numberId[0])+1).toString();
  var rightNumberId="";
  var i = 1;
  while(i<deep)
  {
    rightNumberId += numberId[i];
    i++;
  }
  var index = 0;
  var jsonlength = jsonInfo.length;
  var id;
  var keep;
  var out="";
  while(jsonlength>0)
  {
    if(jsonInfo[index].level == deep)
    {
      var t = (Number(jsonInfo[index].level)-1).toString();
      var signal = 1; //1 means match, 0 means not match
      var help = 0; 
      while(help < t)
      {
        if(jsonInfo[index].number[help] != rightNumberId[help])
        {
          signal = 0;
          break;
        }
        help++;
      }
      if(signal == 1)
      {
        id=jsonInfo[index].level+jsonInfo[index].number;
        keep = '<div class="row smallline" id="'+id+'" onclick="subside('+id+')"> '+jsonInfo[index].details+'</div>';
        out += keep;
      }
    }
    index++;
    jsonlength--;
  }
  document.getElementById("summery").innerHTML = 'Now it is in level '+deep+':!!!!!!';
  switch(deep){
    case '3':
        document.getElementById("col3").innerHTML = out;
        document.getElementById("col4").innerHTML = "";
        document.getElementById("col5").innerHTML = "";
        break;
    case '4':
        document.getElementById("col4").innerHTML = out;
        document.getElementById("col5").innerHTML = "";
        break;
    case '5':
        document.getElementById("col5").innerHTML = out;
        break;
  }
}