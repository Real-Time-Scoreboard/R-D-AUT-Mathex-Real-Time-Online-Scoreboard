/**
This file manages the inputs from Marker for each team. It has methods the perform the correct actions
for when the correct,undo and pass buttons are pressed. Those methods will be called from The Team(X).php files.
Support methods foe adding and retriving cokkies are also available, these assists keeping track of Markers privious inputs for each team.
These file is linked to all Marker's domain files.
**/


$(document).ready(function() {

  //Set the current pressed button from the navbar by adding class current.
  $('li.nav-item').click(function() {
    $(this).addClass('current').siblings().removeClass('current');
  });

});

//loads page when a button is pressed in the navbar and load it into a div, part of the page ( the content)
function loadPage(page) {
  $("#displayBody").load(page);
}

//activated when a marker press the correct button
function correctAnswer() {

  var currQuestion = $("#hiddenCurrQuestion").val();
  if (currQuestion != 20) {
    //confirms action
    var sure = confirm('Are you sure you wish to mark this question as Correct?');

    if (sure) {

      //retrive infomation from hidden fields of the page
      var pageName = $("#PageName").val();
      var hiddenUserName = $("#hiddenUserName").val();
      var hiddenCompId = $("#hiddenCompId").val();
      var hiddenTeamInitial = $("#hiddenTeamInitial").val();

      //set the approoprate name for the cookie
      var cookieName = hiddenCompId + hiddenTeamInitial + "previousQuestion";

      //send reqyuest to sever using Jquery
      $.post("PhpFiles/markerManager.php", {

        request: "Correct",
        currentQuestion: currQuestion,
        userName: hiddenUserName,
        compId: hiddenCompId,
        teamInitials: hiddenTeamInitial

      }, function(data, status) {
        if (status == "success") {

          //on success updates hidden fileds and set previous action as current
          $("#hiddenCurrQuestion").val(parseInt(currQuestion) + 1);
          $("#currQuestionHeading").text(parseInt(currQuestion) + 1);
          setCookie(cookieName, "Correct", 1);
        }
      });
    }
  } else {
    alert("This Team have completed all the 20 questions");
  }
}

function IncorrectAnswer() {

  var sure = confirm('Are you sure you wish to mark this question as Correct?');
  if (sure) {
    //retrive infomation from hidden fields of the page
    var pageName = $("#PageName").val();
    var currQuestion = $("#hiddenCurrQuestion").val();
    var hiddenUserName = $("#hiddenUserName").val();
    var hiddenCompId = $("#hiddenCompId").val();
    var hiddenTeamInitial = $("#hiddenTeamInitial").val();
    //set the approoprate name for the cookie
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
    //retrive infomation from hidden fields of the page
    var pageName = $("#PageName").val();
    var currQuestion = $("#hiddenCurrQuestion").val();
    var hiddenUserName = $("#hiddenUserName").val();
    var hiddenCompId = $("#hiddenCompId").val();
    var hiddenTeamInitial = $("#hiddenTeamInitial").val();
    //set the approoprate name for the cookie
    var cookieName = hiddenCompId + hiddenTeamInitial + "previousQuestion";
    var cookie = checkCookie(hiddenCompId + hiddenTeamInitial + "previousQuestion"); // gets previos actions

    if (cookie === "none" || currQuestion <= 0) {
      alert("You can't undo. No Previous Action registered or current question number is 0");
    } else if (cookie === "Undo") {
      alert("You can't undo more than once!");
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
          //on success updates hidden fileds and set previous action as current
          $("#hiddenCurrQuestion").val(parseInt(currQuestion) - 1);
          $("#currQuestionHeading").text(parseInt(currQuestion) - 1);
          setCookie(cookieName, "Undo", 1);

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

  var currQuestion = $("#hiddenCurrQuestion").val();
  if (currQuestion != 20) {

    var sure = confirm('Are you sure you wish to pass this question?');
    if (sure) {
      //retrive infomation from hidden fields of the page
      var pageName = $("#PageName").val();
      var hiddenUserName = $("#hiddenUserName").val();
      var hiddenCompId = $("#hiddenCompId").val();
      var hiddenTeamInitial = $("#hiddenTeamInitial").val();
      //set the approoprate name for the cookie
      var cookieName = hiddenCompId + hiddenTeamInitial + "previousQuestion";

      $.post("PhpFiles/markerManager.php", {

        request: "Pass",
        currentQuestion: currQuestion,
        userName: hiddenUserName,
        compId: hiddenCompId,
        teamInitials: hiddenTeamInitial

      }, function(data, status) {
        if (status == "success") {
          //on success updates hidden fileds and set previous action as current
          $("#hiddenCurrQuestion").val(parseInt(currQuestion) + 1);
          $("#currQuestionHeading").text(parseInt(currQuestion) + 1);
          setCookie(cookieName, "Pass", 1);
        }
      });
    }
  } else {
    alert("This Team have completed all the 20 questions");
  }
}

//set cookie
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
