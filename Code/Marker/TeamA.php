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
}else{
    header("Location: NoTeamSelected.html");
}
$teamInfo = selectTeamRecord($dbConn,$compId, $team[0]);

if($teamInfo != false) {
	$row1 = pg_fetch_assoc($teamInfo);
	$currquestion = $row1['currentquestion'];
}

closeConn($dbConn);

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="../bootstrap-4.0.0-beta-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="CssFiles/mainStyle.css">
  <link rel="stylesheet" href="CssFiles/modal.css">
	<script type="text/javascript" src="../JQuery/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="JsFiles/modal.js"></script>
	<script type="text/javascript" src="JsFiles/marker.js"></script>
	<script src="../bootstrap-4.0.0-beta-dist/js/bootstrap.min.js"></script>
</head>


<body>

	<input type="hidden" id="PageName" value="TeamA.php" />
	<input type="hidden" id="hiddenTeamInitial" value=<?php echo $team[0] ?> />
	<input type="hidden" id="hiddenCurrQuestion" value=<?php echo $currquestion ?> />

  <!-- The Modal -->
  <div id="myModal" class="modal container">
    <!-- Modal content -->
    <div class="modal-content">
      <div class="modal-header">
        <span class="close">&times;</span>
        <h2>Team History</h2>
      </div>
      <div class="modal-body">
        <p>Some text in the Modal Body</p>
        <p>Previous entries</p>
      </div>
    </div>
  </div>

	<div class="mx-auto text-center" id="teamSelectedShow">

		<h2 class="my-5">TEAM: <?php  if ($team[0] == ""){echo "No Team Selected";} else { echo  $team[0];} ?></h2>
		<h3> Current Question: </h3>
		<h3 id="currQuestionHeading"><?php echo $currquestion ?></h3>

		<div class="row btn-group my-5  ">

	      <div class="col-4">
	        <button class="btn btn-default" onclick="correctAnswer()">
						<img class="img-responsive" src="../images/" class="img-rounded" alt="Correct">
						</button>
	      </div>
	      <div class="col-4 ">
	        <button class="btn btn-default" onclick="undo()">
					<img class="img-responsive" src="../images/" class="img-rounded" alt="Undo">
					</button>
	      </div>
	      <div class="col-4  ">
					<button class="btn btn-default" onclick="pass()">
	        <img class="img-responsive" src="../images/" class="img-rounded" alt="Pass">
					</button>
	      </div>
		</div>
    <div class="text-center my-2 mx-auto" id="teamSelectedShow">
        <!-- Trigger/Open The Modal -->
      <button class = "btn btn-default  historyBtn" id="myBtn" hidden>History</button>
    </div>
	</div>
</body>

</html>
