<!--
PHP file which contains functionality for admin to manage a competition.
Can add/remove teams as well as start or delete the competition.
-->

<!--
PHP to check if user is actually logged into the page with correct privileges.
Redirects them if they are not.
-->

<?php
session_start();
if (!$_SESSION['valid'] || $_SESSION['privilege'] != 'Admin'){
	header("Location: ../Spectator/invalidLogin.html");
} else {
	$msg = "Logged in as: " . $_SESSION['fullName'];
	if (isset($_GET['id'])) {
		//gets the current competition id and saves to session variable
		$_SESSION['selectedCompetition'] = $_GET['id'];
	}
}
include '../DataBaseManagement/ConnectionManager.php';
include '../DataBaseManagement/InsertData.php';
include '../DataBaseManagement/SelectData.php';
include '../DataBaseManagement/UpdateData.php';
?>

<!DOCTYPE  html5>
<html lang="en">
<head>
	<title>Edit Competition</title>
	<meta http-equiv="content-type" content="text/html>"; charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="../bootstrap-4.0.0-beta-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style/mainStyle.css">
	<script type="text/javascript" src="../JQuery/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../style/menuSelector.js"></script>
	<script src="../bootstrap-4.0.0-beta-dist/js/popper.min.js"></script>
	<script src="../bootstrap-4.0.0-beta-dist/js/bootstrap.min.js"></script>
</head>
<body>


	<div class="container">
		<div class="header">
			<h1>Edit Competition</h1>
		</div>
		<div class="content_container">
			<ul class="nav nav-fill bg-dark" id="my_menu ">
				<li class="nav-item ">
					<a class="nav-link " href="addCompetition.php">Competition</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="addTeam.php">Teams</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link "  href="addUser.php">Users</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../Spectator/logout.php">Logout</a>
				</li>
			</ul>

			<div class="mx-auto center-div" style="padding:30px">

				<div class="content_container">

					<!-- PHP code to print a message declaring the user that is logged in-->
					<?php echo $msg; ?>

					<!-- PHP code to display the current status of the competition as well as start one-->
					<h2>Competition <?php echo $_SESSION['selectedCompetition'] ?> Status:
						<?php
						$dbConn = openConnection();

						//starts competition using the computer's current time
						if (isset($_POST['start'])) {
							$time = date("h:i:s");
							$result = selectAllActiveCompetitions($dbConn);

							while ($row = pg_fetch_array($result)) {
								updateCompetitionEntry($dbConn, $row[0], $time, 'false');
							}

							updateCompetitionEntry($dbConn, $_SESSION['selectedCompetition'],  $time, 'true');
						}

						//checks if competition is active or inactive
						$result = getCompetitionStatus($dbConn, $_SESSION['selectedCompetition']);
						if ($result) {
							echo "ACTIVE";
						} else {
							echo "INACTIVE";
						}
						?>
					</h2>

					<!-- Form to start competition-->
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
						<input type="hidden" name="start" value="placeholder">
						<button id="start" onclick="return confirm('Are you sure you wish to start this competition?')">Start Competition</button>
					</form>

					<!-- Form to delete competition-->
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
						<input type="hidden" name="delete" value="placeholder">
						<button id="remove" onclick="return confirm('Are you sure you wish to delete this competition?')">Delete Competition</button>
					</form>

					<br>
					<h2>Current Teams: </h2>
					<!-- List of Teams in the selected competition -->
					<table style="width:80%">
						<tr>
							<th>Team Name</th>
							<th>Team Initials</th>
							<th>Remove</th>
						</tr>
						<!--PHP to add/delete a team or delete the competition-->
						<?php
						if (!$dbConn) {
							echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
						} else {
							//checks if user wishes to add a new team
							if (isset($_POST['selectedTeam'])) {
								//checks that team exists
								$row = selectTeam($dbConn, $_POST['selectedTeam'], "DUMMY");
								if (isset($row[0])) {
									//checks that team is not already added to the current competition
									$row = selectTeamRecord($dbConn, $_SESSION['selectedCompetition'], $_POST['selectedTeam']);
									if (!$row) {
										insertNewTeamRecord($dbConn, $_SESSION['selectedCompetition'], $_POST['selectedTeam']);
										echo "Team " . $_POST['selectedTeam'] . " has been sucessfully added to the competition!";
									} else {
										echo "That team is already in the competition!";
									}
								}
							}
							//checks if user wishes to delete a team
							if (isset($_POST['teamInitialstodelete'])) {
								deleteTeamRecord($dbConn, $_POST['teamInitialstodelete'], $_SESSION['selectedCompetition']);
								echo "Team " . $_POST['teamInitialstodelete'] . " has been sucessfully removed!";
							}
							//checks if user wishes to delete the current competition
							if (isset($_POST['delete'])) {
								deleteCompetition($dbConn, $_SESSION['selectedCompetition']);
								header("Location: addCompetition.php");
							}
							//gets all teams in the current competition and creates a table entry for each team
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

					<!-- Form to select a team and add it to competition-->
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
						<h2>Search for the team you wish to add to this competition: </h2>
						<select name="selectedTeam">
							<option value="" selected disabled>Select Team</option>
							<?php
							if (!$dbConn) {
								echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
							} else {
								$result = selectAllTeams($dbConn);

								$allTeams = array();
								while ($row = pg_fetch_row($result)) {
									array_push($allTeams, $row[0]);
								}
							}
							foreach($allTeams as $key => $value):
								echo '<option value="'.$value.'">'.$value.'</option>';
							endforeach;
							?>
						</select>
						<button type="submit">Add Team</button>
					</form>

				</div>
			</div>
		</div>
	</div>

</body>
</html>
