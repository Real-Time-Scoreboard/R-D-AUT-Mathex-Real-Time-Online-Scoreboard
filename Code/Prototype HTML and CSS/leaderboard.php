<?php
	include '../DataBaseManagement/SelectData.php';
	include '../DataBaseManagement/ConnectionManager.php';
	session_start();
	$dbConn = openConnection();
	$activeCompetition = selectCurrentComp($dbConn);
	$startTime = null;
	if (!$activeCompetition){
		header("Location: welcome.html");
	} else {
		$startTime = selectStartTime($dbConn, $activeCompetition);
	}
	$teamNames = array();
	$teamData = array();
	$result = selectTopScores($dbConn, $activeCompetition);
	while ($row = pg_fetch_row($result)){
		array_push($teamNames, $row[0]);
		array_push($teamData, $row[1]);
	}
	$teamNames = json_encode($teamNames);
	$teamData = json_encode($teamData);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Leaderboard</title>
	<meta http-equiv="content-type" content="text/html>"; charset="utf-8" />
	<link rel="stylesheet" href="style/mainStyle.css">
	<link rel="stylesheet" href="style/leaderboardStyle.css">
	<script src="node_modules/chart.js/dist/Chart.min.js"></script>
	<script type="text/javascript" src="xhr.js"></script>
	<script type="text/javascript" src="leaderboard.js"></script>
</head>
<body>
	<h1>Leaderboard</h1>
	<div class="content_container">
		<!-- Navigation bar -->
		<ul class="navbar">
			<li class="navbar"><a href="welcome.html">Home</a></li>
			<li class="navbar"><a href="search.php">Search</a></li>
			<li class="navbar"><a href="leaderboard.php" class="current">Leaderboard</a></li>
			<li class="navbar"><a href="login.php">Login</a></li>
		</ul>
		<!-- Timer -->
		<div id="timer" style="text-align:right">Time Remaining: </div>

		<div class="leaderboard-container">

			<!-- Table for All Teams -->
			<div class="other-components-container" id="mainDisplay">
				<h2>Competition</h2>
				<canvas id="myChart" width="400" height="250"></canvas>
				<table id="leaderboard-table" style="width:50%"></table>
			</div>

			<div class="other-components-container">
				<!-- Top Team -->
				<div class="other-components-container" id="topTeam"></div>

				<!-- My selected Team -->
				<div class="other-components-container" id="myTeam"></div>

				<!-- Buttons to change view for the leaderboard -->
				<div class="other-components-container" style="clear: left">
					VIEW TYPE <br>
					<button type="button" id="chartButton">Chart</button>
					<button type="button" id="tableButton">Table</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Script for the chart -->
	<script type="text/javascript">
	var selectedTeam = "<?php
	if (isset($_SESSION["selectedTeam"])){
		echo $_SESSION["selectedTeam"];
	}
	?>";
	setSelectedTeam(selectedTeam);
	var activeCompetition = "<?php echo $activeCompetition?>";
	setActiveCompetition(activeCompetition);
	var startTime = "<?php echo $startTime ?>";
	setStartTime(startTime);


	</script>

</body>
</html>
