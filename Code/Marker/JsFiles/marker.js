$(document).ready(function() {
  requestDropBoxContentUsingJQuery();
});

function setDropBox(elementName, data) {
  var subArray = data;
  var element = document.getElementById(elementName); // set id of field to be updated
  var opt;
  for (i = 0; i < subArray.length; i++) { // repeats for the number of suburbs
    opt = document.createElement('option'); //create option tag for select button dropdown feature
    opt.value = subArray[i]; // set its value equal to its name
    opt.innerHTML = subArray[i]; // set its description equal to its name
    element.appendChild(opt); // insert option tag to select dropdown list
  }
}

//the php file path starts from the location of Marker.html file and not this js file
function requestDropBoxContentUsingJQuery() {
  $.get("PhpFiles/markerManager.php", function(data, status) {
        if (status == "success") {
      setDropBox("selectTeam", data.split(","));
    }
  });
}

function sendRequestDropBoxContentUsingJS() {
  var xhr = createRequest(); // get XMLHttpRequest object
  xhr.open("POST", "PhpFiles/markerManager.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) { // response is success
      var data = xhr.responseText; // print message to the allocate part
      setDropBox("selectTeam", data.split(","));
    } // end if
  } // end anonymous call-back function
  xhr.send(); // send request to php file
}

//loads page when a button is pressed and load it into a div
function loadPage(page) {
  $("#displayBody").load(page);
}
