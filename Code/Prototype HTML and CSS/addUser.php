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

		<?php
			if (isset($_POST['username']) && isset($_POST['fullname']) && isset($_POST['password']) && isset($_POST['privilege'])) {
				$dbConn = openConnection();
			  if (!$dbConn) {
		      echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
			  } else {

					$row = selectUser($dbConn, $_POST['username'], $_POST['fullname'], $_POST['password'], $_POST['privilege']);

					if (!$row[0]) {
						insertUser($dbConn, $_POST['username'], $_POST['fullname'], $_POST['password'], $_POST['privilege']);
						echo $msg = "User " . $_POST['username'] . " has been successfully created!";
					} else {
						echo "That User already exists!";
					}
				}
			}
		?>

		<br>
		<h2>Existing Users:</h2>
		<!-- List of Users -->
		<table style="width:55%">
			<tr>
				<th>User ID</th>
				<th>Full name</th>
				<th>Password</th>
				<th>Privilege</th>
			</tr>
			<tr>
				<td><a href="editUser.php">User A</a></td>
				<td>Bill English</td>
				<td>Password A</td>
				<td>Admin</td>
			</tr>
			<tr>
				<td><a href="editUser.php">User B</a></td>
				<td>Winston Peters</td>
				<td>Password B</td>
				<td>Marker</td>
			</tr>
			<tr>
				<td><a href="editUser.php">User C</a></td>
				<td>Jacinda Ardern</td>
				<td>Password C</td>
				<td>Marker</td>
			</tr>
		</table>
	</div>
</body>
</html>
