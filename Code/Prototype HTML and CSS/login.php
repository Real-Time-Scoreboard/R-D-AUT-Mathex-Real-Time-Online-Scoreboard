<?php
   session_start();
	 include '../DataBaseManagement/ConnectionManager.php';
	 include '../DataBaseManagement/SelectData.php';
?>

<html>
<head>
	<title>Login</title>
	<meta http-equiv="content-type" content="text/html>"; charset="utf-8" />
	<link rel="stylesheet" href="style/mainStyle.css">
</head>
<body>
	<h1>Login</h1>
	<div class="content_container">
		<!-- Navigation bar -->
		<ul class="navbar">
			<li class="navbar"><a href="welcome.html">Home</a></li>
			<li class="navbar"><a href="search.html">Search</a></li>
			<li class="navbar"><a href="leaderboard.html">Leaderboard</a></li>
			<li class="navbar"><a href="login.php" class="current">Login</a></li>
		</ul>
		<!--Login form-->
		<?php
			$msg = '';
			if (isset($_POST['login']) && !empty($_POST['username'])
			&& !empty($_POST['password'])) {
				$dbConn = openConnection();
			  if (!$dbConn) {
		      echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
			  } else {
		      $row = selectPrivilegedUser($dbConn, $_POST['username'], $_POST['password']);
					$privilege = $row[0];
					$fullname = $row[1];
					if ($privilege == 'Marker' || $privilege == 'Admin'){
						echo $fullname . ": Marker";
						$_SESSION['valid'] = true;
						$_SESSION['privilege'] = $privilege;
						$_SESSION['fullname'] = $fullname;
						if ($privilege == 'Marker'){
							header("Location: marker.php");
							exit();
						} else if ($privilege == 'Admin'){
							header("Location: addCompetition.php");
							exit();
						}
					} else {
						echo "Incorrect username or password";
					}
			  }
			}
		?>
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			<?php echo $msg; ?><br>
			Username
			<br>
			<input type="text" name ="username" >
			<br>
			Password
			<br>
			<input type="password" name ="password" >
			<br>
			<button type="submit" name="login" >Login</button>
		</form>
	</div>

</body>

</html>
