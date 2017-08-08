var ajaxku=buatajax();
function ajaxitem(id){
  var url="http://silver.dev/bantuin/kebutuhan/getItem/"+id;

  console.log(url);
  ajaxku.onreadystatechange=stateChanged;
  ajaxku.open("GET",url,true);
  ajaxku.send(null);

  // skipped
  // ajaxSatuan(id);
}

function ajaxsatuan(id) {
  var url2="http://silver.dev/bantuin/kebutuhan/getSatuan/"+id;
  ajaxku.onreadystatechange=stateChangedSatuan;
  ajaxku.open("GET",url2,true);
  ajaxku.send(null);
}

function ajaxkota_perus(id){
  var url="http://rekrutmen.hipmijaya.org/registration/getKota/"+id;
  console.log(url);
  ajaxku.onreadystatechange=stateChangedPerus;
  ajaxku.open("GET",url,true);
  ajaxku.send(null);
}

function ajaxkec(id){
  var url="select_daerah.php?kab="+id+"&sid="+Math.random();
  ajaxku.onreadystatechange=stateChangedKec;
  ajaxku.open("GET",url,true);
  ajaxku.send(null);
}

function ajaxkel(id){
  var url="select_daerah.php?kec="+id+"&sid="+Math.random();
  ajaxku.onreadystatechange=stateChangedKel;
  ajaxku.open("GET",url,true);
  ajaxku.send(null);
}

function buatajax(){
  if (window.XMLHttpRequest){
    return new XMLHttpRequest();
  }
  if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
  }
  return null;
}
function stateChanged(){
  var data;
  if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
      document.getElementById("id_item").innerHTML = data
    }else{
      document.getElementById("id_item").value = "<option selected>Pilih Item</option>";
    }
  }
}

function stateChangedSatuan(){
  var data;
  if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
      document.getElementById("satuan").innerHTML = data
    }else{
      document.getElementById("satuan").value = "<option selected>Pilih Satuan</option>";
    }
  }
}

function stateChangedPerus(){
  var data;
  if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
      document.getElementById("kota_perus").innerHTML = data
    }else{
      document.getElementById("kota_perus").value = "<option selected>Pilih Kota/Kab</option>";
    }
  }
}

function stateChangedKec(){
  var data;
  if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
      document.getElementById("kec").innerHTML = data
    }else{
      document.getElementById("kec").value = "<option selected>Pilih Kecamatan</option>";
    }
  }
}

function stateChangedKel(){
  var data;
  if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
      document.getElementById("kel").innerHTML = data
    }else{
      document.getElementById("kel").value = "<option selected>Pilih Kelurahan/Desa</option>";
    }
  }
}

function showCoordinate(){
  var prop = document.getElementById("prop");
  var kab = document.getElementById("kota");
  var kec = document.getElementById("kec");
  var kel = document.getElementById("kel");
  var s = kel.options[kel.selectedIndex].text
          +', '
          +kec.options[kec.selectedIndex].text
          +', '
          +kab.options[kab.selectedIndex].text
          +', '
          +prop.options[prop.selectedIndex].text;
  var geocoder;
  geocoder = new google.maps.Geocoder();
  geocoder.geocode( { 'address': s}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      var position=results[0].geometry.location;
      document.getElementById("lat").value=position.lat();
      document.getElementById("lng").value=position.lng();
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}