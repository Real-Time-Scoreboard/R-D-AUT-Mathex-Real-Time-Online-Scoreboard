$(document).ready(function() {


});

//loads page when a button is pressed and load it into a div
function loadPage(page) {
  $("#displayBody").load(page);
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
      compId:hiddenCompId,
      selectTeam: element

    }, function(data, status) {
      if (status == "success") {
        var obj = jQuery.parseJSON(data);
        if (obj.result == false) {
          alert(obj.error);
        } else {
          alert(obj.error);
          var teamA = document.getElementById("teamA");
          var teamB = document.getElementById("teamB");

          if (typeof teamA.value === "undefined") {
            teamA.innerHTML = "<b>" + element + "</b>";
          } else {
            if (typeof teamB.value === "undefined") {
              teamB.innerHTML = "<b>" + element + "</b>";
            }
          }
        }
      }
    });
  } else {
    alert("You must Select Team first");
  }
}

function correctAnswer() {
  var sure = confirm('Are you sure you wish to mark this question as Correct?');
  if (sure) {
    var pageName = $("#PageName").val();
    var currQuestion = $("#currQuestionHeading").val();
    var hiddenUserName = $("#hiddenUserName").val();
    var hiddenCompId = $("#hiddenCompId").val();
    var hiddenTeamInitial = $("#hiddenTeamInitial").val();

    $.post("PhpFiles/markerManager.php", {

      request: "Correct",
      currentQuestion: currQuestion,
      userName: hiddenUserName,
      compId: hiddenCompId,
      teamInitials: hiddenTeamInitial

    }, function(data, status) {
      if (status == "success") {
        loadPage(pageName);
      }
    });
  }
}

function IncorrectAnswer() {

  var sure = confirm('Are you sure you wish to mark this question as Correct?');
  if (sure) {
    var pageName = $("#PageName").val();
    var currQuestion = $("#currQuestionHeading").val();
    var hiddenUserName = $("#hiddenUserName").val();
    var hiddenCompId = $("#hiddenCompId").val();
    var hiddenTeamInitial = $("#hiddenTeamInitial").val();

    $.post("PhpFiles/markerManager.php", {

      request: "Incorrect",
      currentQuestion: currQuestion,
      userName: hiddenUserName,
      compId: hiddenCompId,
      teamInitials: hiddenTeamInitial

    }, function(data, status) {
      if (status == "success") {
        loadPage(pageName);
      }
    });
  }

}

function undo() {
  var sure = confirm('Are you sure you return to the previous question?');

  if (sure) {
    var pageName = $("#PageName").val();
    var currQuestion = $("#currQuestionHeading").val();
    var hiddenUserName = $("#hiddenUserName").val();
    var hiddenCompId = $("#hiddenCompId").val();
    var hiddenTeamInitial = $("#hiddenTeamInitial").val();

    $.post("PhpFiles/markerManager.php", {

      request: "Undo",
      currentQuestion: currQuestion,
      userName: hiddenUserName,
      compId: hiddenCompId,
      teamInitials: hiddenTeamInitial

    }, function(data, status) {
      if (status == "success") {
        loadPage(pageName);
      }
    });
  }
}

function pass() {
  var sure = confirm('Are you sure you wish to pass this question?');
  if (sure) {

    var pageName = $("#PageName").val();
    var currQuestion = $("#currQuestionHeading").val();
    var hiddenUserName = $("#hiddenUserName").val();
    var hiddenCompId = $("#hiddenCompId").val();
    var hiddenTeamInitial = $("#hiddenTeamInitial").val();

    $.post("PhpFiles/markerManager.php", {

      request: "Pass",
      currentQuestion: currQuestion,
      userName: hiddenUserName,
      compId: hiddenCompId,
      teamInitials: hiddenTeamInitial

    }, function(data, status) {
      if (status == "success") {
        loadPage(pageName);
      }
    });
  }

}
