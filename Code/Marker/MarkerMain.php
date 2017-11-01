<?php
// Start the session
session_start();

$fullName =  "Full Name";
$userName = "Marker01";

if (isSet($_SESSION['userName']) && isSet($_SESSION['fullName'])){
  $fullName =  $_SESSION['fullName'];
  $userName = $_SESSION['userName'];
} else {
    //header("Location: invalidLogin.html");
    $_SESSION['fullName'] = $fullName;
    $_SESSION['userName'] = $userName;
}

include '../DataBaseManagement/ConnectionManager.php';
include '../DataBaseManagement/SelectData.php';


$dbConn = openConnection();

$compId = selectCurrentComp($dbConn);
$_SESSION['compId'] = $compId;

$team = array("","");
$result = getMakerAssignedTeam($dbConn,$compId, $userName);

if (($count= pg_num_rows($result)) >= 1) {

		for ($x = 0; $x < $count; $x++) {
        $row = pg_fetch_row($result);
				$team[$x] = $row[0];

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
  <link rel="stylesheet" href="CssFiles/mainStyle.css">
  <script type="text/javascript" src="../JQuery/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="JsFiles/marker.js"></script>
  <script src="../bootstrap-4.0.0-beta-dist/js/popper.min.js"></script>
  <script src="../bootstrap-4.0.0-beta-dist/js/bootstrap.min.js"></script>

</head>

<body onload="loadPage('homePage.php')">
  <input type="hidden" id="hiddenUserName" value=<?php echo $userName ?> />
  <input type="hidden" id="hiddenCompId" value=<?php echo $compId ?> />

  <div class="container">

    <div class="content_container">

        <div class="header">
          <h1>Marker Page</h1>
        </div>

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
        <a class="nav-link" href="../Prototype HTML and CSS/Welcome.html">Log Out</a>
      </li>
    </ul>

    <div  id="displayBody" class=""></div>

  </div>
  </div>
</body>

</html>
