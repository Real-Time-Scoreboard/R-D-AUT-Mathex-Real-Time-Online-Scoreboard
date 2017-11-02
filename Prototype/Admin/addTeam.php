
<!--
PHP file used to display a list of teams in the database
and present a form to the user which allows them to add or delete
a new team to the database.
-->

<?php
session_start();
if (!$_SESSION['valid'] || $_SESSION['privilege'] != 'Admin'){
	header("Location: ../Spectator/invalidLogin.html");
} else {
	$msg = "Logged in as: " . $_SESSION['fullName'];
}
include '../DataBaseManagement/ConnectionManager.php';
include '../DataBaseManagement/InsertData.php';
include '../DataBaseManagement/SelectData.php';
include '../DataBaseManagement/UpdateData.php';
?>

<!DOCTYPE  html5>
<html lang="en">
<head>
	<title>Teams Overview</title>
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
			<h1>Teams Overview</h1>
		</div>
		<div class="content_container">
			<ul class="nav nav-fill bg-dark" id="my_menu ">
				<li class="nav-item ">
					<a class="nav-link " href="addCompetition.php">Competition</a>
				</li>
				<li class="nav-item current">
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

				<!-- PHP code to print a message declaring the user that is logged in-->
				<?php echo $msg; ?>

				<!-- Form to add a team -->
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
					<h2>Add a Team:</h2>
					Team Initials:
					<br>
					<input type="text" name ="teamInitials" style="width:40%" required>
					<br>
					Team Name:
					<br>
					<input type="text" name ="teamName" style="width:40%" required>
					<br>
					<button type="submit" id="add" onclick="return confirm('Are you sure you wish to add this team?')">Add</button>
				</form>

				<!-- PHP code to add a new team to the database or delete one. -->
				<?php
				//checks if user wants to add a team to the database
				if (isset($_POST['teamInitials']) && isset($_POST['teamName'])) {
					$dbConn = openConnection();
					if (!$dbConn) {
						echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
					} else {
						//checks if the new team doesn't already exist in the database
						$row = selectTeam($dbConn, strtoupper($_POST['teamInitials']), strtoupper($_POST['teamName']));
						if (!$row[0]) {
							insertIntoTeam($dbConn, strtoupper($_POST['teamInitials']), $_POST['teamName']);
							echo $msg = $_POST['teamName'] . " has been successfully created!";
						} else {
							echo "That team already exists!";
						}
					}
				}
				//checks if user wishes to delete a team from the database
				if (isset($_POST['teamnametodelete']) && isset($_POST['teaminitialstodelete'])) {
					$dbConn = openConnection();
					if (!$dbConn) {
						echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
					} else {
						$result = deleteTeam($dbConn, $_POST['teamnametodelete'], $_POST['teaminitialstodelete']);
						if (isset($result)) {
							echo $_POST['teamnametodelete'] . " has been successfully deleted!";
						}
					}
				}
				?>

				<br>
				<h2>Existing Teams:</h2>
				<!-- List of Teams -->
				<table style="width:80%">
					<tr>
						<th>Team Name</th>
						<th>Team Initials</th>
						<th>Delete</th>
					</tr>
					<!--Code which creates a table entry for each team entry in the database-->
					<?php

					$dbConn = openConnection();
					if (!$dbConn) {
						echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
					} else {
						$result = selectAllTeams($dbConn);

						while ($row = pg_fetch_array($result)) {
							echo "<tr>";
							echo "<td>" . $row[1] . "</td>";
							echo "<td>" . $row[0] . "</td>";
							echo '<td><form action="', htmlspecialchars($_SERVER['PHP_SELF']), '" method="post">
							<input type="hidden" name="teamnametodelete" value="', $row[1], '">
							<input type="hidden" name="teaminitialstodelete" value="', $row[0], '">
							<button type="submit" id="delete" onclick="return confirm(\'Are you sure you wish to delete this team?\');">Delete</button>
							</form></td>';
							echo "</tr>";
						}
					}
					?>
				</table>
			</div>
		</div>
	</div>
</body>
</html>
