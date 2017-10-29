<?php
	session_start();
	include '../DataBaseManagement/DataBaseManagement/ConnectionManager.php';
	include '../DataBaseManagement/DataBaseManagement/SelectData.php';
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
			<li class="navbar"><a href="search.html"  class="current">Search</a></li>
			<li class="navbar"><a href="leaderboard.html">Leaderboard</a></li>
			<li class="navbar"><a href="login.php">Login</a></li>
		</ul>

		<?php
		$dbConn = openConnection();
		if (!$dbConn) {
			echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
		} else {
			$competitionid = selectActiveCompetition($dbConn);
			$result = selectAllTeams($dbConn, $competitionid);

			$allTeams = array();
			while ($row = pg_fetch_row($result)) {
				array_push($allTeams, $row[0]);
			}
		}
		?>
			<h2>Search for the team you wish to track here:</h2>

			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
				<input list="teams" name="selectedTeam">
				<datalist id="teams">
					<option value="">Select Team</option>
					<?php
					foreach($allTeams as $key => $value):
						echo '<option value="'.$value.'">'.$value.'</option>';
					endforeach;
					?>
				</datalist>
				<button type="submit">Track Team</button>
			</form>

			<?php
				if (isset($_POST['selectedTeam'])) {
					$row = selectTeam($dbConn, "DUMMY", $_POST['selectedTeam']);
					if (isset($row[0])) {
						$_SESSION['selectedTeam'] = $_POST['selectedTeam'];
					}
				}
				if (isset($_SESSION['selectedTeam'])) {
					echo "You are currently tracking " . $_SESSION['selectedTeam'];

				}
			?>

	<br>
</div>
</body>
</html>
