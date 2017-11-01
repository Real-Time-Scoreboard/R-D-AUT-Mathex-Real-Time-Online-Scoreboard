<!--
This page allows spectators to select a team to track.
It retrieves a list of teams from the active competition and displays them.
Once a user selects a team, it is stored in the session and the user is
navigated to the leaderboard.php page.
-->

<?php
include '../DataBaseManagement/ConnectionManager.php';
include '../DataBaseManagement/SelectData.php';
session_start();
$dbConn = openConnection();
// Create connection with database
$activeCompetition = selectCurrentComp($dbConn);
// If there is no active competition, redirect to welcome.html
if (!$activeCompetition){
	header("Location: welcome.html");
}
// Get all teams participating in the active competition
$result = selectAllActiveTeams($dbConn, $activeCompetition);
// Store those teams in an array.
$teamNames = array();
while ($row = pg_fetch_row($result)) {
	array_push($teamNames, $row[0]);
}
?>

<!DOCTYPE  html5>
<html lang="en">
<head>
	<title>Search</title>
	<meta http-equiv="content-type" content="text/html>"; charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="../bootstrap-4.0.0-beta-dist/css/bootstrap.min.css">

	<link rel="stylesheet" href="../style/mainStyler.css">
	<script type="text/javascript" src="../JQuery/jquery-3.2.1.min.js"></script>

	<script src="../bootstrap-4.0.0-beta-dist/js/popper.min.js"></script>
	<script src="../bootstrap-4.0.0-beta-dist/js/bootstrap.min.js"></script>
</head>
<body>

		<div class="container">
	    <div class="content_container">

	      <div class="header">
	        <h1>Select team</h1>
	      </div>

	      <ul class="nav nav-fill bg-dark" id="my_menu ">
	        <li class="nav-item">
	        	<a class="nav-link" href="welcome.html">Home</a>
	      	</li>
	      	<li class="nav-item current">
	        	<a class="nav-link" href="search.php">Search Team</a>
	      	</li>
	      	<li class="nav-item ">
	        	<a class="nav-link "  href="leaderboard.php">Leaderboard</a>
	      	</li>
	      	<li class="nav-item">
	        	<a class="nav-link" href="login.php">Login</a>
	      	</li>
	    	</ul>

				<div class="mx-auto center_div">

					<h2>Search for the team you wish to track here:</h2>
					<p>
						Specific information will be displayed for your team on the
						<a href="leaderboard.php">Leaderboard</a> page. This information includes:
						<ul>
							<li>Score</li>
							<li>Question Number</li>
							<li>Number of questions answered correctly</li>
							<li>Number of passes used</li>
						</ul>
					</p>
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
						<!-- <input list="teams" name="selectedTeam"> -->
						<select id="teams" name="selectedTeam">
							<option value="" disabled selected>Select Team</option>
							<?php
							// Iterate through the array of teams.
							// For each team, echo a <option> html tag.
							for($i = 0; $i < count($teamNames); $i++){
								echo '<option value="'.$teamNames[$i].'">'.$teamNames[$i].'</option>';
							}
							?>
						</select>
						<button type="submit">Track Team</button>
					</form>

					<p>
						<?php
						// If the selected team is set when the form was submitted,
						// store the team in the session and redirect to leaderboard.php.
						if (isset($_GET['selectedTeam'])) {
							$_SESSION['selectedTeam'] = $_GET['selectedTeam'];
							header("Location: leaderboard.php");
						}
						// If the session already stores a team, display the team's name.
						// Otherwise display a default message.
						if (isset($_SESSION['selectedTeam'])) {
							echo "You are tracking " . $_SESSION['selectedTeam'] . "<br>";
						} else {
							echo "You haven't selected a team to track yet.<br>";
						}
						?>
					</p>
					<a href="leaderboard.php">Click here to go to the leaderboard</a>

				</div>
	  	</div>
		</div>
</body>
</html>
