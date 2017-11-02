<!--
This page shows the leaderboard for the MATHEX competiton in real time.
It updates every 2 seconds with new data for the top 5 teams, as well as
extra stats for the top team, and the selected team (if applicable).
Uses chart.js for the chart display. Uses leaderboard.js and xhr.js for Ajax.
-->

<?php
include '../DataBaseManagement/SelectData.php';
include '../DataBaseManagement/ConnectionManager.php';
session_start();
// Create a connection with the database.
$dbConn = openConnection();
// Get the active compeition.
$activeCompetition = selectCurrentComp($dbConn);
// Initialise the start time variable.
$startTime = null;
// If there is no active competition, redirect the user to welcome.html.
// Else, get the start time for the competiton.
// The start time is used for the countdown.
if (!$activeCompetition){
	header("Location: welcome.html");
} else {
	$startTime = selectStartTime($dbConn, $activeCompetition);
}
?>

<!DOCTYPE html5>
<html lang="en">
<head>
	<title>Leaderboard</title>
	<meta http-equiv="content-type" content="text/html>"; charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="../bootstrap-4.0.0-beta-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style/mainStyle.css">
	<link rel="stylesheet" href="../style/leaderboardStyle.css">

	<script src="../node_modules/chart.js/dist/Chart.min.js"></script>
	<script type="text/javascript" src="xhr.js"></script>
	<script type="text/javascript" src="leaderboard.js"></script>
	<script type="text/javascript" src="../JQuery/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../style/menuSelector.js"></script>
	<script src="../bootstrap-4.0.0-beta-dist/js/popper.min.js"></script>
	<script src="../bootstrap-4.0.0-beta-dist/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="header">
			<h1>Leaderboard</h1>
		</div>
		<div class="content_container">
			<ul class="nav nav-fill bg-dark" id="my_menu ">
				<li class="nav-item">
					<a class="nav-link " href="welcome.html">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="search.php">Search Team</a>
				</li>
				<li class="nav-item current">
					<a class="nav-link "  href="leaderboard.php">Leaderboard</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="login.php">Login</a>
				</li>
			</ul>

			<div class="my-5">
				<div class="leaderboard-container">
					<!-- Timer -->
					<div id="timer" class="timer">Time Remaining: </div>
					<div class="mx-auto center_div" style="margin-top: 0px; text-align: center" id="mainDisplay">
						<h2>Competition</h2>
						<!-- Chart js object -->
						<canvas id="myChart" width="700" height="550"></canvas>
						<!-- leaderboard table -->
						<div id="leaderboard-table" style="width:100%"></div>
						<!-- Buttons to change view for the leaderboard -->
						<div class="other-components-container" style="width: 100%; padding-bottom: 10px">
							VIEW TYPE <br>
							<button type="button" id="chartButton">Chart</button>
							<button type="button" id="tableButton">Table</button>
						</div>
					</div>
					<div style="margin:0; width: 100%">
						<!-- Top Team -->
						<div class="other-components-container" id="topTeam"></div>
						<!-- My selected Team -->
						<div class="other-components-container" id="myTeam"></div>
					</div>
				</div>

				<!-- Script for the chart -->
				<script type="text/javascript">
				// Get the selectedTeam for the user from the php session and pass it to the
				// leaderboard.js file.
				var selectedTeam = "<?php
				if (isset($_SESSION["selectedTeam"])){
					echo $_SESSION["selectedTeam"];
				}
				?>";
				setSelectedTeam(selectedTeam);
				// Get the activeCompetition from the php session and pass it to the
				// leaderboard.js file.
				var activeCompetition = "<?php echo $activeCompetition?>";
				setActiveCompetition(activeCompetition);
				// Get the start time from the php session and pass it to the
				// leaderboard.js file.
				var startTime = "<?php echo $startTime ?>";
				setStartTime(startTime);
				</script>
			</div>
		</div>
	</div>
</body>
</html>
