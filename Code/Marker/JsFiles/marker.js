$(document).ready(function() {


});

//loads page when a button is pressed and load it into a div
function loadPage(page) {
  $("#displayBody").load(page);
}

function correctAnswer() {
  var sure = confirm('Are you sure you wish to mark this question as Correct?');
  if (sure) {
    var pageName = $("#PageName").val();
    var currQuestion = $("#hiddenCurrQuestion").val();
    var hiddenUserName = $("#hiddenUserName").val();
    var hiddenCompId = $("#hiddenCompId").val();
    var hiddenTeamInitial = $("#hiddenTeamInitial").val();

    var cookieName = hiddenCompId + hiddenTeamInitial + "previousQuestion";

    $.post("PhpFiles/markerManager.php", {

      request: "Correct",
      currentQuestion: currQuestion,
      userName: hiddenUserName,
      compId: hiddenCompId,
      teamInitials: hiddenTeamInitial

    }, function(data, status) {
      if (status == "success") {
        $("#hiddenCurrQuestion").val(parseInt(currQuestion) + 1);
        $("#currQuestionHeading").text(parseInt(currQuestion) + 1);
        setCookie(cookieName, "Correct", 1);
      }
    });
  }
}

function IncorrectAnswer() {

  var sure = confirm('Are you sure you wish to mark this question as Correct?');
  if (sure) {
    var pageName = $("#PageName").val();
    var currQuestion = $("#hiddenCurrQuestion").val();
    var hiddenUserName = $("#hiddenUserName").val();
    var hiddenCompId = $("#hiddenCompId").val();
    var hiddenTeamInitial = $("#hiddenTeamInitial").val();

    var cookieName = hiddenCompId + hiddenTeamInitial + "previousQuestion";
    $.post("PhpFiles/markerManager.php", {

      request: "Incorrect",
      currentQuestion: currQuestion,
      userName: hiddenUserName,
      compId: hiddenCompId,
      teamInitials: hiddenTeamInitial

    }, function(data, status) {
      if (status == "success") {
        setCookie(cookieName, "Incorrect", 1);
      }
    });
  }

}

function undo() {
  var sure = confirm('Are you sure you return to the previous question?');

  if (sure) {
    var pageName = $("#PageName").val();
    var currQuestion = $("#hiddenCurrQuestion").val();
    var hiddenUserName = $("#hiddenUserName").val();
    var hiddenCompId = $("#hiddenCompId").val();
    var hiddenTeamInitial = $("#hiddenTeamInitial").val();

    var cookieName = hiddenCompId + hiddenTeamInitial + "previousQuestion";
    var cookie = checkCookie(hiddenCompId + hiddenTeamInitial + "previousQuestion");
  
    if (cookie === "none" || currQuestion <= 0) {
      alert("You can't undo. No Previous Action registered or current question number is 0");
    } else {

      $.post("PhpFiles/markerManager.php", {

        request: "Undo",
        currentQuestion: currQuestion,
        userName: hiddenUserName,
        compId: hiddenCompId,
        teamInitials: hiddenTeamInitial,
        prevAction: cookie

      }, function(data, status) {
        if (status == "success") {
          $("#hiddenCurrQuestion").val(parseInt(currQuestion) - 1);
          $("#currQuestionHeading").text(parseInt(currQuestion) - 1);

          var obj = jQuery.parseJSON(data);
          if (obj.result == false) {
            alert(obj.error);
          }
        }
      });

    }

  }
}

function pass() {
  var sure = confirm('Are you sure you wish to pass this question?');
  if (sure) {

    var pageName = $("#PageName").val();
    var currQuestion = $("#hiddenCurrQuestion").val();
    var hiddenUserName = $("#hiddenUserName").val();
    var hiddenCompId = $("#hiddenCompId").val();
    var hiddenTeamInitial = $("#hiddenTeamInitial").val();

    var cookieName = hiddenCompId + hiddenTeamInitial + "previousQuestion";

    $.post("PhpFiles/markerManager.php", {

      request: "Pass",
      currentQuestion: currQuestion,
      userName: hiddenUserName,
      compId: hiddenCompId,
      teamInitials: hiddenTeamInitial

    }, function(data, status) {
      if (status == "success") {
        $("#hiddenCurrQuestion").val(parseInt(currQuestion) + 1);
        $("#currQuestionHeading").text(parseInt(currQuestion) + 1);
        setCookie(cookieName, "Pass", 1);
      }
    });
  }

}

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function checkCookie(cname) {
  var cookie = getCookie(cname);
  if (cookie != "") {
    return cookie;
  } else {
    return "none";
  }
}
