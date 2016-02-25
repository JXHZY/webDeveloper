var jsonInfo = new Array();
var totalNumber = 0;

$(document).ready(function() {
    $.ajax({
		type:"GET",
		url:"data.json",
		dataType: "JSON",
		success: function(data){
			var keep;
    		var out="";
			$.each(data,function(i,item){
				totalNumber++;
				jsonInfo[i]=item;
				if(jsonInfo[i].level == '1')
				{
					keep = '<div class="row firstline" id="'+jsonInfo[i].id+'" style="background-color:'+jsonInfo[i].color+'" onclick="subside('+jsonInfo[i].id+')"> '+jsonInfo[i].name+'</div>';
					out += keep;
				}
			})
			document.getElementById("col1").innerHTML = out;
		}
	});
});

function subside(id){
	var length = totalNumber;
	var i = 0;
	var keep = "";
	var out = "";
	var description = "";
	var deep = "";
	while(length > 0)
	{
		if(jsonInfo[i].father == id)
		{
			keep = '<div class="row" id="'+jsonInfo[i].id+'" style="background-color:'+jsonInfo[i].color+'" onclick="subside('+jsonInfo[i].id+')"> '+jsonInfo[i].name+'</div>';
			out += keep;
			deep = jsonInfo[i].level;
		}
		if(jsonInfo[i].id == id)
		{
			description += jsonInfo[i].details;
		}
		i++;
		length--;
	}
	document.getElementById("summery").innerHTML = description;
	switch(deep){
    case '2':
    	document.getElementById("col2").innerHTML = out;
        document.getElementById("col3").innerHTML = "";
        document.getElementById("col4").innerHTML = "";
        document.getElementById("col5").innerHTML = "";
        break;
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