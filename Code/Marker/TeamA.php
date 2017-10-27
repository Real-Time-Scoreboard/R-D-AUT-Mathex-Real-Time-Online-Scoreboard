<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="../bootstrap-4.0.0-beta-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="CssFiles/marker.css">
	<script type="text/javascript" src="../JQuery/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="JsFiles/cookies.js"></script>
	<script type="text/javascript" src="JsFiles/marker.js"></script>
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
$teamInfo = selectTeamRecord($dbConn,$compId, $team[0]);

if($teamInfo != false) {
	$row1 = pg_fetch_assoc($teamInfo);
	$currquestion =$row1['currentquestion'];
}

 ?>

<body>

	<input type="hidden" id="PageName" value="TeamA.php" />
	<input type="hidden" id="hiddenUserName" value=<?php echo $userName ?> />
	<input type="hidden" id="hiddenCompId" value=<?php echo $compId ?> />
	<input type="hidden" id="hiddenTeamInitial" value=<?php echo $team[0] ?> />
	<input type="hidden" id="currQuestionHeading" value=<?php echo $currquestion ?> />


	<div class="mx-auto text-center" id="teamSelectedShow">
		<h2>TEAM: <?php  if ($team[0] == ""){echo "No Team Selected";} else { echo  $team[0];} ?></h2>
		<h3> Current Question: </h3>
		<h3><?php echo $currquestion ?></h3>

		<div class="row btn-group my-5">

	      <div class="col-4">
	        <button class="btn btn-default" onclick="correctAnswer()">
						<img class="img-responsive" src="../images/" class="img-rounded" alt="Correct">
						</button>
	      </div>
	      <div class="col-4 ">
	        <button class="btn btn-default" onclick="undo()">
					<img class="img-responsive" src="../images/" class="img-rounded" alt="">Undo
					</button>
	      </div>
	      <div class="col-4  ">
					<button class="btn btn-default" onclick="pass()">
	        <img class="img-responsive" src="../images/" class="img-rounded" alt=""> Pass
					</button>
	      </div>

			</div>
	</div>


</body>

</html>
