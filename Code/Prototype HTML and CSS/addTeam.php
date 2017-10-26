<?php
	session_start();
	if (!$_SESSION['valid'] || $_SESSION['privilege'] != 'Admin'){
		header("Location: invalidLogin.html");
	} else {
		$msg = "Logged in as: " . $_SESSION['fullname'];
	}
	include '../ConnectionManager.php';
	include '../InsertData.php';
	include '../SelectData.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Teams Overview</title>
	<meta http-equiv="content-type" content="text/html>"; charset="utf-8" />
	<link rel="stylesheet" href="style/mainStyle.css">
</head>
<body>

	<h1>Teams Overview</h1>
	<div class="content_container">

		<!-- Navigation bar -->
		<ul class="navbar">
			<li class="navbar"><a href="addCompetition.php">Competition</a></li>
			<li class="navbar"><a href="addTeam.php" class="current">Teams</a></li>
			<li class="navbar"><a href="addUser.php">Users</a></li>
			<li class="navbar"><a href="logout.php">Logout</a></li>
		</ul>

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

		<?php
			if (isset($_POST['teamInitials']) && isset($_POST['teamName'])) {
				$dbConn = openConnection();
			  if (!$dbConn) {
		      echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
			  } else {

					$row = selectTeam($dbConn, strtoupper($_POST['teamInitials']), strtoupper($_POST['teamName']));

					if (!$row[0]) {
						insertNewTeam($dbConn, $_POST['teamInitials'], $_POST['teamName']);
						echo $msg = $_POST['teamName'] . " has been successfully created!";
					} else {
						echo "That team already exists!";
					}
				}
			}
		?>

		<br>
		<h2>Existing Teams:</h2>
		<!-- List of Teams -->
		<table style="width:35%">
			<tr>
				<th>Team Name</th>
				<th>Team Initials</th>
				<th>Delete</th>
			</tr>
			<tr>
				<td>Team A</td>
				<td>ABC</td>
				<td><button id="delete" onclick="confirm('Are you sure you wish to delete this team from the system?')">Delete</button></td>
			</tr>
			<tr>
				<td>Team B</td>
				<td>BCD</td>
				<td><button id="delete" onclick="confirm('Are you sure you wish to delete this team from the system?')">Delete</button></td>
			</tr>
			<tr>
				<td>Team C</td>
				<td>CDE</td>
				<td><button id="delete" onclick="confirm('Are you sure you wish to delete this team from the system?')">Delete</button></td>
			</tr>
		</table>
	</div>
</body>
</html>
