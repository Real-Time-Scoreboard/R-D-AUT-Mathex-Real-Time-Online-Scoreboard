<!-- 
	PHP file used to display a list of users in the database
	and present a form to the user which allows them to add a new 
	user or delete an existing one.
-->

<!-- 
	PHP to check if user is actually logged into the page with correct privileges. 
	Redirects them if they are not.
-->
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
	include '../DataBaseManagement/UpdateData.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Users Overview</title>
	<meta http-equiv="content-type" content="text/html>"; charset="utf-8" />
	<link rel="stylesheet" href="style/mainStyle.css">
</head>
<body>

	<h1>Users Overview</h1>
	<div class="content_container">

		<!-- Navigation bar -->
		<ul class="navbar">
			<li class="navbar"><a href="addCompetition.php">Competition</a></li>
			<li class="navbar"><a href="addTeam.php">Teams</a></li>
			<li class="navbar"><a href="addUser.php" class="current">Users</a></li>
			<li class="navbar"><a href="logout.php">Logout</a></li>
		</ul>
		
		<!-- PHP code to print a message declaring the user that is logged in-->
		<?php echo $msg; ?>

		<!-- Form to add a user -->
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			<h2>Add a User:</h2>
			User ID:<br>
			<input type="text" name="username" style="width:40%" required>
			<br>Full Name:<br>
			<input type="text" name="fullname" style="width:40%" required>
			<br>Password:<br>
			<input type="text" name="password" style="width:40%" required>
			<br>Privilege:
			<select name="privilege">
				<option value="TeamA">Marker</option>
				<option value="TeamB">Admin</option>
			</select>
			<button type="submit" id="add" onclick="return confirm('Are you sure you wish to add this user?')">Add</button>
		</form>
		
		<!-- PHP code to add or delete a user-->
		<?php
			//checks if user wants to add a new user to the database
			if (isset($_POST['username']) && isset($_POST['fullname']) && isset($_POST['password']) && isset($_POST['privilege'])) {
				$dbConn = openConnection();
			  	if (!$dbConn) {
		      			echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
			  	} else {
					//checks if tbhe new user doesn't already exist in the database
					$row = selectUser($dbConn, $_POST['username'], $_POST['fullname'], $_POST['password'], $_POST['privilege']);

					if (!$row[0]) {
						insertNewUser($dbConn, $_POST['username'], $_POST['fullname'], $_POST['password'], $_POST['privilege']);
						echo $msg = "User " . $_POST['username'] . " has been successfully created!";
					} else {
						echo "That User already exists!";
					}
				}
			}
			//checks if user wants to delete an existing user from the database
			if (isset($_POST['usernametodelete']) && isset($_POST['fullnametodelete'])) {
				$dbConn = openConnection();
				if (!$dbConn) {
					echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
				} else {
					$result = deleteUser($dbConn, $_POST['usernametodelete'], $_POST['fullnametodelete']);
					if (isset($result)) {
						echo "User " . $_POST['usernametodelete'] . " has been successfully deleted!";
					}
				}
			}
		?>

		<br>
		<h2>Existing Users:</h2>
		<!-- List of Users -->
		<table style="width:90%">
			<tr>
				<th>User ID</th>
				<th>Full name</th>
				<th>Password</th>
				<th>Privilege</th>
				<th>Delete</th>
			</tr>
			<!--Code which creates a table entry for each user entry in the database-->
			<?php
				$dbConn = openConnection();
				if (!$dbConn) {
					echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
				} else {
					$result = selectAllUsers($dbConn);

					while ($row = pg_fetch_array($result)) {
						echo "<tr>";
						echo "<td>" . $row[0] . "</td>";
						echo "<td>" . $row[1] . "</td>";
						echo "<td>" . $row[2] . "</td>";
						echo "<td>" . $row[3] . "</td>";
						//checks each user to see if they are the user currently logged in or not
						//to prevent user from accidentally deleting themselves
						if ($row[1] != $_SESSION['fullname']) {
							echo '<td><form action="', htmlspecialchars($_SERVER['PHP_SELF']), '" method="post">
												<input type="hidden" name="usernametodelete" value="', $row[0], '">
												<input type="hidden" name="fullnametodelete" value="', $row[1], '">
												<button type="submit" id="delete" onclick="return confirm(\'Are you sure you wish to delete this team?\');">Delete</button>
												</form></td>';
						} else {
							echo "<td>Logged In</td>";
						}
						echo "</tr>";
					}
				}
			?>
		</table>
	</div>
</body>
</html>
