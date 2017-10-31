<?php
	session_start();
	if (!$_SESSION['valid'] || $_SESSION['privilege'] != 'Admin'){
		header("Location: invalidLogin.html");
	} else {
		$msg = "Logged in as: " . $_SESSION['fullname'];
		if (isset($_GET['id'])) {
			$_SESSION['selectedCompetition'] = $_GET['id'];
		}
	}
	include '../DataBaseManagement/ConnectionManager.php';
	include '../DataBaseManagement/InsertData.php';
	include '../DataBaseManagement/SelectData.php';
	include '../DataBaseManagement/UpdateData.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Competition</title>
	<meta http-equiv="content-type" content="text/html>"; charset="utf-8" />
	<link rel="stylesheet" href="style/mainStyle.css">
</head>
<body>

	<h1>Edit Competition</h1>
	<div class="content_container">

		<!-- Navigation bar -->
		<ul class="navbar">
			<li class="navbar"><a href="addCompetition.php" class="current">Competition</a></li>
			<li class="navbar"><a href="addTeam.php">Teams</a></li>
			<li class="navbar"><a href="addUser.php">Users</a></li>
			<li class="navbar"><a href="logout.php">Logout</a></li>
		</ul>

		<?php echo $msg; ?>

		<h2>Competition <?php echo $_SESSION['selectedCompetition'] ?> Status: INACTIVE</h2>

		<!-- Start competition or remove it from the system-->
		<button id="start" onclick="confirm('Are you sure you wish to start this competition?')">Start</button>
		<button id="remove" onclick="confirm('Are you sure you wish to delete this competition?')">Delete Competition</button>

		<br>
		<h2>Current Teams: </h2>
		<!-- List of Teams in the selected competition -->
		<table style="width:80%">
			<tr>
				<th>Team Name</th>
				<th>Team Initials</th>
				<th>Remove</th>
			</tr>
			<?php

				$dbConn = openConnection();
				if (!$dbConn) {
					echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
				} else {
					if (isset($_POST['selectedTeam'])) {
						$row = selectTeam($dbConn, $_POST['selectedTeam'], "DUMMY");
						if (isset($row[0])) {
							insertNewTeamRecord($dbConn, $_SESSION['selectedCompetition'], $_POST['selectedTeam']);
							echo "Team " . $_POST['selectedTeam'] . " has been sucessfully added to " . $_SESSION['selectedCompetition'];
						} else {
							echo "That team does not exist!";
						}
					}

					if (isset($_POST['teamInitialstodelete'])) {
						deleteTeamRecord($dbConn, $_POST['teamInitialstodelete'], $_SESSION['selectedCompetition']);
						echo "Team " . $_POST['teamInitialstodelete'] . " has been sucessfully removed!";
					}

					$result = selectAllActiveTeams($dbConn, $_SESSION['selectedCompetition']);

					while ($row = pg_fetch_array($result)) {
						echo "<tr>";
						echo "<td>" . $row[1] . "</td>";
						echo "<td>" . $row[0] . "</td>";
						echo '<td><form action="', htmlspecialchars($_SERVER['PHP_SELF']), '" method="post">
											<input type="hidden" name="teamInitialstodelete" value="', $row[0], '">
											<button type="submit" id="delete" onclick="return confirm(\'Are you sure you wish to remove this team?\');">Remove</button>
											</form></td>';
					}
				}
			?>
		</table>

		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			<h2>Search for the team you wish to add to this competition: </h2>
			<input list="teams" name="selectedTeam">
			<datalist id="teams">
				<option value="">Select Team</option>
				<?php
					if (!$dbConn) {
						echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
					} else {
						$result = selectAllTeamsNotInCompetition($dbConn, $_SESSION['selectedCompetition']);

						$allTeams = array();
						while ($row = pg_fetch_row($result)) {
							array_push($allTeams, $row[0]);
						}
					}

					foreach($allTeams as $key => $value):
						echo '<option value="'.$value.'">'.$value.'</option>';
					endforeach;
				?>
			</datalist>
			<button type="submit">Add Team</button>
		</form>

	</div>
</body>
</html>
