<?php
	session_start();
	if (!$_SESSION['valid'] || $_SESSION['privilege'] != 'Marker'){
		header("Location: invalidLogin.html");
	} else {
		$msg =  "Logged in as: " . $_SESSION['fullname'];
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Team Selection</title>
	<meta http-equiv="content-type" content="text/html>"; charset="utf-8" />
	<link rel="stylesheet" href="style/mainStyle.css">
	<link rel="stylesheet" href="style/markerStyle.css">
</head>
<body>
	<h1> Select Team </h1>
	<div class="content_container">
		<!-- Navigation bar -->
		<ul class="navbar">
			<!-- Navigation bar -->
			<li class="navbar"><a href="teamSelect.php">Select Team</a></li>
			<li class="navbar"><a href="" class="current">Team A</a></li>
			<li class="navbar"><a href="">Team B</a></li>
			<li class="navbar"><a href="logout.php">Logout</a></li>
		</ul>

		<?php echo $msg; ?>
		<!-- Form to search teams -->
		<h2>Team A
			<br><br>
			Current Question: <br>
		</h2>
		<div class="btn-group">
			<button class="correct-button" onclick="confirm('Are you sure you wish to mark this question as Correct?')">Correct</button>
			<button class="undo-button" onclick="confirm('Are you sure you return to the previous question?')">Undo</button>
			<button class="pass-button" onclick="confirm('Are you sure you wish to pass this question?')">Pass</button>
		</div>
	</body>
	</html>
