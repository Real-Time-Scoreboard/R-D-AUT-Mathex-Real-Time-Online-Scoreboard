<?php
	session_start();
	if (!$_SESSION['valid'] || $_SESSION['privilege'] != 'Admin'){
		header("Location: invalidLogin.html");
	} else {
		$msg = "Logged in as: " . $_SESSION['fullname'];
	}
	include '../DataBaseManagement/ConnectionManager.php';
	include '../DataBaseManagement/InsertData.php';
	include '../DataBaseManagement/SelectData.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Competitions Overview</title>
	<meta http-equiv="content-type" content="text/html>"; charset="utf-8" />
	<link rel="stylesheet" href="style/mainStyle.css">

</head>
<body>

	<h1>Competitions Overview</h1>
	<div class="content_container">

		<!-- Navigation bar -->
		<ul class="navbar">
			<li class="navbar"><a href="addCompetition.php" class="current">Competition</a></li>
			<li class="navbar"><a href="addTeam.php">Teams</a></li>
			<li class="navbar"><a href="addUser.php">Users</a></li>
			<li class="navbar"><a href="logout.php">Logout</a></li>
		</ul>

		<?php echo $msg; ?>

		<!-- Form to add a compeition -->
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			<h2>New competition:</h2>
			<input type="text" name ="competitionid" style="width:40%" placeholder="Unique competition name" maxlength="6" required>
			<button type="submit" id="add" onclick="return confirm('Are you sure you wish to add this competition?')">Add</button>
		</form>

		<?php
			if (isset($_POST['competitionid'])) {
				$dbConn = openConnection();
			  if (!$dbConn) {
		      echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
			  } else {

					$row = selectCompetitionID($dbConn, strtoupper($_POST['competitionid']));

					if (!$row[0]) {
						insertNewCompetition($dbConn, $_POST['competitionid']);
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
			<tr>
				<td><a href="competitionAdmin.php">Competition A</a></td>
				<td>No</td>
			</tr>
			<?php

				$dbConn = openConnection();
				if (!$dbConn) {
					echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
				} else {
					$result = selectAllCompetitions($dbConn);

					while ($row = pg_fetch_array($result)) {
						echo "<tr>";
						echo "<td><a href='competitionAdmin.php?id=" . $row[0] . "'>$row[0]</a></td>";
						echo "<td>";
						if ($row[2]) {
							echo "Yes";
						} else {
							echo "No";
						}
						echo "</td>";
						echo "</tr>";
					}
				}
			?>
		</table>

	</div>
</body>

</html>
