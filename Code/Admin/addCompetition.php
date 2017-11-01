
<!--
PHP file used to display a list of competitions in the database
and present a form to the user which allows them to add a new
competition.
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
?>

<!DOCTYPE  html5>
<html lang="en">
<head>
	<title>Competitions Overview</title>
	<meta http-equiv="content-type" content="text/html>"; charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="../bootstrap-4.0.0-beta-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style/mainStyler.css">

	<script type="text/javascript" src="../JQuery/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../style/menuSelector.js"></script>
	<script src="../bootstrap-4.0.0-beta-dist/js/popper.min.js"></script>
	<script src="../bootstrap-4.0.0-beta-dist/js/bootstrap.min.js"></script>
</head>
<body>


	<div class="container">
		<div class="header">
			<h1>Competitions Overview</h1>
		</div>
		<div class="content_container">
			<ul class="nav nav-fill bg-dark" id="my_menu ">
				<li class="nav-item current">
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

			<div class="mx-auto center-div" style="padding: 30px">
				<!-- PHP code to print a message declaring the user that is logged in-->
				<?php echo $msg; ?>

				<!-- Form to add a competition -->
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
					<h2>New competition:</h2>
					<input type="text" name ="competitionid" style="width:40%" placeholder="Unique competition name" maxlength="6" required>
					<button type="submit" id="add" onclick="return confirm('Are you sure you wish to add this competition?')">Add</button>
				</form>

				<!-- PHP code to insert a newly created competition into the database-->
				<?php
				if (isset($_POST['competitionid'])) {
					$dbConn = openConnection();
					if (!$dbConn) {
						echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
					} else {

						$row = selectCompetitionID($dbConn, strtoupper($_POST['competitionid']));

						if (!$row[0]) {
							insertIntoCompetition($dbConn, $_POST['competitionid'], $time = date("h:i:s"));
							echo $msg = $_POST['competitionid'] . " has been successfully created!";
						} else {
							echo "That competition already exists!";
						}
					}
				}
				?>
				<br>
				<h2>Existing Competitions:</h2>
				<!-- List of Competitions -->
				<table style="width:50%">
					<tr>
						<th>Competition Name</th>
						<th>Active</th>
					</tr>

					<!--Code which creates a table entry for each competition entry in the database-->
					<?php
					$dbConn = openConnection();
					if (!$dbConn) {
						echo "Connection Failed: <br/>" . pg_last_error($dbConn);
					} else {
						$result = selectAllCompetitions($dbConn);
						while ($row = pg_fetch_array($result)) {
							echo "<tr>";
							echo "<td><a href='competitionAdmin.php?id=" . $row[0] . "'>$row[0]</a></td>";
							echo "<td>";
							if ($row[2] == 't') {
								echo "Yes";
							} else {
								echo "No";
							}
						}
					}
					?>

				</table>
			</div>
		</div>
	</body>
	</html>
