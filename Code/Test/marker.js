$(document).ready(function() {
sendRequestDropBoxContent();
});

function setDropBox(elementName, data) {
  var subArray = data;
  var element = document.getElementById(elementName); // set id of field to be updated
  for (i = 0; i < subArray.length; i++) { // repeats for the number of suburbs
    var opt = document.createElement('option'); //create option tag for select button dropdown feature
    opt.value = subArray[i]; // set its value equal to its name
    opt.innerHTML = subArray[i]; // set its description equal to its name
    element.appendChild(opt); // insert option tag to select dropdown list
  }
}

function sendRequestDropBoxContent() {
  var xhr = createRequest(); // get XMLHttpRequest object
  var requestbody = "request=" + encodeURIComponent("request");
  xhr.open("POST", "markerManager.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) { // response is success
      var data = xhr.responseText; // print message to the allocate part
      setDropBox("selectTeam", data.split(","));
    } // end if
  } // end anonymous call-back function
  xhr.send(requestbody); // send request to php file
}

function loadPage(page){
  $("#displayBody").load(page);
}
