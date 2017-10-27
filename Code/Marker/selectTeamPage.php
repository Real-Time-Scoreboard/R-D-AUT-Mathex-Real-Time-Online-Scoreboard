<!DOCTYPE html5>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="../bootstrap-4.0.0-beta-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="CssFiles/marker.css">
  <script type="text/javascript" src="../JQuery/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="JsFiles/cookies.js"></script>
  <script type="text/javascript" src="JsFiles/marker.js"></script>
  <script type="text/javascript" src="JsFiles/selectTeam.js"></script>
  <script src="../bootstrap-4.0.0-beta-dist/js/bootstrap.min.js"></script>

</head>

<?php

include '../DataBaseManagement/ConnectionManager.php';
include '../DataBaseManagement/SelectData.php';

$dbConn = openConnection();
$compId = selectCurrentComp($dbConn);
$userName = "Marker01";

$team = array("","");
$result = getMakerAssignedTeam($dbConn,$compId, $userName);

if (($count= pg_num_rows($result)) >= 1) {

		for ($x = 0; $x < $count; $x++) {
        $row = pg_fetch_row($result);
				$team[$x] = $row[0];

    }
}

?>

<body>
    <div class="mx-auto" id="teamSelectedShow">
      <form class="form-horizontal ">
        <div class="form-group form-inline ">
          <label class=" " for="searchBar ">Team Initials :</label>
          <div class="col-xs-2 form-inline ">
            <input type="text " id="searchBar" placeholder="Track By Name... ">
            <div class="col-2 ">
              <input type="button" value="Select " onclick ='selectToBeMarked("searchBar")'>
            </div>
          </div>
        </div>
        <div class="form-group form-inline ">
          <label class="" for="selectTeam">Select Team :</label>
          <div class="col-xs-4 form-inline ">
            <select id="selectTeam" type="text " name="selectTeam"> <!--drop down list -->
                <option value="" disabled selected >Please choose...</option>
              </select>
            <div class="col-4 ">
              <input type="button" value="Select" onclick ='selectToBeMarked("selectTeam")'>
            </div>
          </div>
        </div>
      </form>
      <div>
        <p> Team A: <span id="teamA"><?php  if ($team[0] != ""){echo  "<b>".$team[0]."</b>";}?></span></p>
        <p> Team B: <span id="teamB"><?php  if ($team[1] != ""){echo  "<b>".$team[1]."</b>";}?></span></p>
      </div>
    </div>
  </body>
</html>
