//the php file path starts from the location of Marker.html file and not this js file
$(document).ready(function() {

  requestDropBoxContentUsingJQuery(); // fill dropbox on the select team option
  hideButtons(); //hide delesect teams buttons when there is not team available


});
//hide delesect teams buttons when there is not team available
function hideButtons() {
  var teamA = $("#teamA").text();
  var teamB = $("#teamB").text();

  if (teamA === "") {
    $("#unselectTeamA").hide();
  } else {
    $("#unselectTeamA").show();
  }
  if (teamB === "") {
    $("#unselectTeamB").hide();
  } else {
    $("#unselectTeamB").show();
  }
}
//the php file path starts from the location of Marker.html file and not this js file
function requestDropBoxContentUsingJQuery() { // fill dropbox on the select team option
  var hiddenCompId = $("#hiddenCompId").val();
  $.post("PhpFiles/markerManager.php", {
    compId: hiddenCompId,
    request: "DropBoxContent"

  }, function(data, status) {
    if (status == "success") {
      var obj = jQuery.parseJSON(data);
      setDropBox("selectTeam", obj.result.split(","));
    }
  });
}

function setDropBox(elementName, data) {
  var subArray = data;
  var element = document.getElementById(elementName); // set id of field to be updated
  var opt;
  for (i = 0; i < subArray.length; i++) { // repeats for the number of teams
    opt = document.createElement('option'); //create option tag for select button dropdown feature
    opt.value = subArray[i]; // set its value equal to its name
    opt.innerHTML = subArray[i]; // set its description equal to its name
    element.appendChild(opt); // insert option tag to select dropdown list
  }
}

//Select a team
function selectToBeMarked(field) {

  //get value from hidden fields
  var element = document.getElementById(field).value;
  var hiddenUserName = $("#hiddenUserName").val();
  var hiddenCompId = $("#hiddenCompId").val();

  if (element.length > 0) {
    //send request to server
    $.post("PhpFiles/selectTeam.php", {

      marker: hiddenUserName,
      compId: hiddenCompId,
      selectTeam: element

    }, function(data, status) {
      if (status == "success") {
        var obj = jQuery.parseJSON(data); // receive respose and send correct feed back user
        if (obj.result == false) {
          alert(obj.error);
        } else {
          alert(obj.error);
          var teamA = $("#teamA");
          var teamB = $("#teamB");
          //update  Screen adequately for fields TEAM A AND B
          if (teamA.text() === "") {
            teamA.html("<b>" + element + "</b>");
          } else {
            if (teamB.text() === "") {
              teamB.html("<b>" + element + "</b>");
            }
          }

          hideButtons(); // check changes for the selected team fields and updat buttons
        }
      }
    });
  } else {
    alert("You must Select Team first");
  }
}

// Called by the deselected button when available and remove the team being marked
function deselectTeam(field) {

  var element = $("#" + field);
  var hiddenUserName = $("#hiddenUserName").val();
  var hiddenCompId = $("#hiddenCompId").val();
  $.post("PhpFiles/selectTeam.php", {

    compId: hiddenCompId,
    unselectTeam: element.text()

  }, function(data, status) {
    if (status == "success") {
      var obj = jQuery.parseJSON(data);
      alert(obj.error);
      element.text("");
      hideButtons();
    }

  });
}
