<?php
	session_start();
	if (!$_SESSION['valid'] || $_SESSION['privilege'] != 'Admin'){
		header("Location: invalidLogin.html");
	} else {
		$msg = "Logged in as: " . $_SESSION['fullname'];
	}
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
		<form action="">
			<h2>Add a User:</h2>
			User ID:<br>
			<input type="text" name="username" style="width:40%" required>
			<br>Full Name:<br>
			<input type="text" name="fullname" style="width:40%" required>
			<br>Password:<br>
			<input type="text" name="password" style="width:40%" required>
			<br>Privilege:
			<select>
				<option value="TeamA">Marker</option>
				<option value="TeamB">Admin</option>
			</select>
			<button type="submit" id="add" onclick="confirm('Are you sure you wish to add this user?')">Add</button>
		</form>

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
