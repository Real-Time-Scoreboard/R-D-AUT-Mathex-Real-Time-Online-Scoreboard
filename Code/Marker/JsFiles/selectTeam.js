//the php file path starts from the location of Marker.html file and not this js file
$(document).ready(function() {

  requestDropBoxContentUsingJQuery();
  hideButtons();


});

function hideButtons() {
  var teamA = $("#teamA").text();
  var teamB = $("#teamB").text();
  
  if (teamA === "") {
    $("#unselectTeamA").hide();
  }else{
    $("#unselectTeamA").show();
  }
  if (teamB === "") {
    $("#unselectTeamB").hide();
  }else{
      $("#unselectTeamB").show();
  }
}
//the php file path starts from the location of Marker.html file and not this js file
function requestDropBoxContentUsingJQuery() {
  $.post("PhpFiles/markerManager.php", {

    request: "DropBoxContent"

  }, function(data, status) {
    if (status == "success") {
      setDropBox("selectTeam", data.split(","));
    }
  });
}

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

function selectToBeMarked(field) {

  var element = document.getElementById(field).value;
  var hiddenUserName = $("#hiddenUserName").val();
  var hiddenCompId = $("#hiddenCompId").val();

  if (element.length > 0) {
    element = element.toUpperCase();
    $.post("PhpFiles/selectTeam.php", {

      marker: hiddenUserName,
      compId: hiddenCompId,
      selectTeam: element

    }, function(data, status) {
      if (status == "success") {
        var obj = jQuery.parseJSON(data);
        if (obj.result == false) {
          alert(obj.error);
        } else {
          alert(obj.error);
          var teamA = $("#teamA");
          var teamB = $("#teamB");

          if (teamA.text() === "") {
            teamA.html("<b>" + element + "</b>");
          } else {
            if (teamB.text() === "") {
              teamB.html("<b>" + element + "</b>");
            }
          }

          hideButtons();
        }
      }
    });
  } else {
    alert("You must Select Team first");
  }
}

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
