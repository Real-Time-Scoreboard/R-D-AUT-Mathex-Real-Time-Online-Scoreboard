<?php

include '../DataBaseManagement/ConnectionManager.php';
include '../DataBaseManagement/SelectData.php';

// Start the session
session_start();

$userName = "Marker01";
$compId;

if (isSet($_SESSION['userName']) && isSet($_SESSION['fullName'])){
  $userName = $_SESSION['userName'];
}
if(isSet( $_SESSION['compId'])){
  $compId = $_SESSION['compId'];
}

$dbConn = openConnection();

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
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="../bootstrap-4.0.0-beta-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="CssFiles/mainStyle.css">
  <script type="text/javascript" src="../JQuery/jquery-3.2.1.min.js"></script>

  <script type="text/javascript" src="JsFiles/marker.js"></script>
  <script type="text/javascript" src="JsFiles/selectTeam.js"></script>
  <script src="../bootstrap-4.0.0-beta-dist/js/bootstrap.min.js"></script>

</head>


<body>
    <div class="mx-auto center_div" id="teamSelectedShow">

      <p>
          <label class="selectLabel" for="searchBar">Team Initials :</label>
          <input type="text" class="inputBar "id="searchBar" placeholder="Track By Name...">
          <input type="button" class = "btn btn-default" value="Select " onclick ='selectToBeMarked("searchBar")'>
    </p>

      <p>
          <label class="selectLabel" for="selectTeam">Select Team :</label>
          <select class="inputBar  id="selectTeam" type="text" name="selectTeam"> <!--drop down list -->
            <option value="" disabled selected >Please choose...</option>
          </select>
        <input type="button" class = "btn btn-default" value="Select" onclick ='selectToBeMarked("selectTeam")'>
      </p>

      <div>
        <p> Team A: <span id="teamA" class="selectedTeamLabel"><?php  if ($team[0] != ""){echo  "<b>".$team[0]."</b>";}?></span>
        <input type="button" class = "btn btn-default" id="unselectTeamA" value="Deselect" onclick='deselectTeam("teamA")'></p>

        <p> Team B: <span id="teamB" class="selectedTeamLabel"><?php  if ($team[1] != ""){echo  "<b>".$team[1]."</b>";}?></span>
        <input type="button" class = "btn btn-default" id="unselectTeamB" value="Deselect" onclick='deselectTeam("teamB")'></p>
      </div>

    </div>
  </body>
</html>
