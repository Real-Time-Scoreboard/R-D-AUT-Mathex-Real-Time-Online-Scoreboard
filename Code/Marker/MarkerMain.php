
<!--
MarkerMain.php is the main page and all other pages are loaded into this page as subpages. See method loadPage().
The nav bar is presented in this page only and its main purpose is to provide the naviation role.

homePage.php - Simply provides the greeting to the marker

SelectTeamPage.php  - has the goal to Select the team to be marked , as well as, inform the ones already assigned to marker

Team(A|B).php - provides the features to update team's perfomance as the competition goes. this is the Team's page

NotteamSelected.html - will call for a warning message, informing that Marker chas to select a team before loading the team page

Note: that most of the variables (Sessions) are checked and set on this page and they are used by other marker's pages. They are stores into html hidden fields.
-->

<?php
// Start the session
session_start();

$fullName = "";
$userName = "";

if (isSet($_SESSION['userName']) && isSet($_SESSION['fullName'])){
  $fullName =  $_SESSION['fullName'];
  $userName = $_SESSION['userName'];
} else {
  header("Location: invalidLogin.html");
}

include '../DataBaseManagement/ConnectionManager.php';
include '../DataBaseManagement/SelectData.php';


$dbConn = openConnection();

$compId = selectCurrentComp($dbConn); // check what is the current Comptetition
$_SESSION['compId'] = $compId;


$team = array("","");
$result = getMakerAssignedTeam($dbConn,$compId, $userName); //Get marker assined te
$count= pg_num_rows($result);

if ($count >= 1) {
  $row = pg_fetch_row($result);
  $team[0] = $row[0];
  $_SESSION['teamA'] = $team[0];
  if($count == 2){
    $row = pg_fetch_row($result);
    $team[1] = $row[0];
    $_SESSION['teamB'] = $team[1];
  }
}

closeConn($dbConn);
?>

<!DOCTYPE html5>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
  <link rel="stylesheet" href="../bootstrap-4.0.0-beta-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../style/mainStyler.css">
  <script type="text/javascript" src="../JQuery/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="JsFiles/marker.js"></script>
  <script src="../bootstrap-4.0.0-beta-dist/js/popper.min.js"></script>
  <script src="../bootstrap-4.0.0-beta-dist/js/bootstrap.min.js"></script>

</head>

<body onload="loadPage('homePage.php')">
  <input type="hidden" id="hiddenUserName" value=<?php echo $userName ?> />
  <input type="hidden" id="hiddenCompId" value=<?php echo $compId ?> />

  <div class="container">
    <div class="header">
      <h1>Marker Page</h1>
    </div>
    <div class="content_container">
      <ul class="nav nav-fill bg-dark" id="my_menu ">
        <li class="nav-item current">
          <a class="nav-link " onclick="loadPage('homePage.php')">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" onclick="loadPage('selectTeamPage.php')">Select Team</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link " id="navButTeamA" onclick="loadPage('TeamA.php')">Team A</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="navButTeamB" onclick="loadPage('TeamB.php')">Team B</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../Spectator/logout.php">Log Out</a>
        </li>
      </ul>

      <div  id="displayBody" class=""></div>

    </div>
  </div>
</body>

</html>
