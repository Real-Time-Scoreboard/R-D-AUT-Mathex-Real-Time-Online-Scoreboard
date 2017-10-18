<?php
include '../ConnectionManager.php';
include '../SelectData.php';
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

			<select name="teams">
				<option value="">Select Team</option>
				<?php
				foreach($allTeams as $key => $value):
					echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
				endforeach;
				?>
			</select>

	<br>
</div>
</body>
</html>
