<?php
include '../DataBaseManagement/ConnectionManager.php';
include '../DataBaseManagement/SelectData.php';
session_start();
$dbConn = openConnection();
$activeCompetition = selectCurrentComp($dbConn);
if (!$activeCompetition){
	header("Location: welcome.html");
}
$result = selectAllActiveTeams($dbConn, $activeCompetition);
$teamNames = array();
while ($row = pg_fetch_row($result)) {
	array_push($teamNames, $row[0]);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search</title>
	<meta http-equiv="content-type" content="text/html>"; charset="utf-8" />
	<link rel="stylesheet" href="style/mainStyle.css">
</head>
<body>
	<h1>Select team</h1>
	<div class="content_container">
		<!-- Navigation bar -->
		<ul class="navbar">
			<li class="navbar"><a href="welcome.html">Home</a></li>
			<li class="navbar"><a href="search.php"  class="current">Search</a></li>
			<li class="navbar"><a href="leaderboard.php">Leaderboard</a></li>
			<li class="navbar"><a href="login.php">Login</a></li>
		</ul>

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
				for($i = 0; $i < count($teamNames); $i++){
					echo '<option value="'.$teamNames[$i].'">'.$teamNames[$i].'</option>';
				}
				?>
			</select>
			<button type="submit">Track Team</button>
		</form>

		<p>
			<?php
			if (isset($_GET['selectedTeam'])) {
				$_SESSION['selectedTeam'] = $_GET['selectedTeam'];
				header("Location: leaderboard.php");
			}
			if (isset($_SESSION['selectedTeam'])) {
				echo "You are tracking " . $_SESSION['selectedTeam'] . "<br>";
			} else {
				echo "You haven't selected a team to track yet.<br>";
			}
			?>
		</p>
		<a href="leaderboard.php">Click here to go to the leaderboard</a>
		<br>
	</div>
</body>
</html>
