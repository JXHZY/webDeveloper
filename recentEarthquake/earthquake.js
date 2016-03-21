/*Reccent Earth Quake 
@Ying Zhou 03/18/2016*/
var map;
var infoWindow;
var markers = [];

//-----------------------------------------Find the top 10 in last 12 months------------------------
function findTop(){
  $.ajax({
    type: "GET",
    dataType:"json",
    url: "http://api.geonames.org/earthquakesJSON?north=44.1&south=-9.9&east=-22.4&west=55.2&maxRows=500&username=ying",
    success: function(data) {
      var out="";
      var keep = '<ul>';
      var max =10;
      var day = new Date();
      $.each(data.earthquakes,function(i,item){
        var keep = item.datetime.split("-",3);
        var strMonth = keep[1];
        var strYear = keep[0];
        var endYear = day.getFullYear();
        var endMonth = day.getMonth();
        if(((strMonth>=endMonth)&&(strYear == endYear - 1))||((endYear == strYear)&&(strMonth < endMonth)))
        {
          if(max>0)
          {
            keep = '<li>eqid:'+item.eqid+'&nbsp &nbsp'+item.datetime+'</li>';
            out += keep;
            max--;
          }
        }
      })
      out += '</ul>';
      document.getElementById("top10").innerHTML = out;
    }
  });
}

//-------------------------------------Send ajax to Geonames----------------
function findRecentEarthQuake(lat,lng){
  var info = {
    "e":lng+1,
    "n":lat+1,
    "s":lat-1,
    "w":lng-1,
  };
  $.ajax({
    type: "GET",
    dataType:"json",
    url: 'http://api.geonames.org/earthquakesJSON?north='+info.n+'&south='+info.s+'&east='+info.e+'&west='+info.w+'&username=ying',
    success: function(data) {
      $.each(data.earthquakes,function(i,item){
        creatMarker(item);
      })
    }
  });
}

//-------------------------------------init Google Map----------------
function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 41.850033, lng: -87.6500523},
    zoom: 4,
  });
  var input = (document.getElementById('pac-input'));
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
  infoWindow = new google.maps.InfoWindow();
  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.bindTo('bounds', map);

  autocomplete.addListener('place_changed', function() {
    var place = autocomplete.getPlace();
    clearAllMarkers();
    if (!place.geometry) {
      window.alert("Autocomplete's returned place contains no geometry");
      return;
    }
    else
    {
      var lat = place.geometry.location.lat();
      var lng = place.geometry.location.lng();
      creatMarkerP(lat,lng,place.name);
      findRecentEarthQuake(lat,lng);
    }
    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    }
    else 
    {
      map.setCenter(place.geometry.location);
      map.setZoom(4);  // Why 17? Because it looks good.
    }
  });
}

//-------------------------------------Clear out the old markers---------------------------
function clearAllMarkers(){
    markers.forEach(function(marker) {
      marker.setMap(null);
    });
    markers = [];
}

//-------------------------------------creat the new---------------------------
function creatMarkerP(lat,lng,name){
  var image = {
    url: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
    // This marker is 20 pixels wide by 32 pixels high.
    size: new google.maps.Size(20, 32),
    // The origin for this image is (0, 0).
    origin: new google.maps.Point(0, 0),
    // The anchor for this image is the base of the flagpole at (0, 32).
    anchor: new google.maps.Point(0, 32)
  };
  var shape = {
    coords: [1, 1, 1, 20, 18, 20, 18, 1],
    type: 'poly'
  };
  var marker = new google.maps.Marker({
      position: {'lat': lat, 'lng': lng},
      map: map,
      icon: image,
      shape: shape,
  });
  marker.content = '<div><strong>' + name + '</strong><br></div>';
  google.maps.event.addListener(marker,'click',function(){
    infoWindow.setContent(marker.content);
    infoWindow.open(map,marker);
  });
  markers.push(marker);
}

function creatMarker(info){
  var marker = new google.maps.Marker({
      position: {'lat': info.lat, 'lng': info.lng},
      map: map,
  });
  marker.content = '<div><strong>eqid:' + info.eqid + '</strong><br><strong>datetime:' + info.datetime + '</strong><br><strong>magnitude:' + info.magnitude + '</strong><br><strong>depth:' + info.depth + '</strong><br></div>';
  google.maps.event.addListener(marker, 'click', function() {
    infoWindow.setContent(marker.content);
    infoWindow.open(map, this);
  });
  markers.push(marker);
}

