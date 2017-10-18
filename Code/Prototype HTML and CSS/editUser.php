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
	<title>Edit User</title>
	<meta http-equiv="content-type" content="text/html>"; charset="utf-8" />
	<link rel="stylesheet" href="style/mainStyle.css">
</head>
<body>
	<h1>Edit User</h1>
	<div class="content_container">

		<!-- Navigation bar -->
		<ul class="navbar">
			<li class="navbar"><a href="addCompetition.php">Competition</a></li>
			<li class="navbar"><a href="addTeam.php">Teams</a></li>
			<li class="navbar"><a href="addUser.php" class="current">Users</a></li>
			<li class="navbar"><a href="logout.php">Logout</a></li>
		</ul>

		<?php echo $msg; ?>
		
		<!-- Form to edit user -->
		<form action="">
			<h2>Edit User:</h2>
			User ID:<br>
			<input type="text" name="username" value="User A" style="width:40%" required>
			<br>Full Name:<br>
			<input type="text" name="fullname" value="Bill English" style="width:40%" required>
			<br>Password:<br>
			<input type="text" name="password" value="Password A" style="width:40%" required>
			<br>Privilege:
			<select>
				<option value="Marker">Marker</option>
				<option value="Admin" selected>Admin</option>
			</select>
      <br><br>
			<button type="submit" id="edit" onclick="confirm('Are you sure you wish to edit this user?')">Edit</button>
      <button type="submit" id="remove" onclick="confirm('Are you sure you wish to delete this user?')">Delete</button>
		</form>
	</div>
</body>
</html>