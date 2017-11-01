<!--
This file is a login page for privileged users.
It lets them enter login credentials, checks the database if those credentials
are correct, and then redirects them to the appropriate page if the login is
successful.
-->

<?php
session_start();
include '../DataBaseManagement/ConnectionManager.php';
include '../DataBaseManagement/SelectData.php';
?>

<!DOCTYPE  html5>
<html lang="en">
<head>
  <title>Login</title>
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
      <h1>Login</h1>
    </div>
    <div class="content_container">
      <ul class="nav nav-fill bg-dark" id="my_menu ">
        <li class="nav-item ">
          <a class="nav-link " href="welcome.html">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="search.php">Search Team</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link "  href="leaderboard.php">Leaderboard</a>
        </li>
        <li class="nav-item current">
          <a class="nav-link" href="login.php">Login</a>
        </li>
      </ul>

      <div class="my-5 text-center">
        <p>
          Please note that login is only necessary for administrators and markers.<br>
          If you are a spectator, <a href="leaderboard.php">click here to return to the leaderboard</a>
        </p>
        <?php
        $msg = '';
        // If the form is completed properly, proceed.
        if (isset($_POST['login']) && !empty($_POST['userName'])
        && !empty($_POST['password'])) {
          // Create a connection with the database.
          $dbConn = openConnection();
          // If the database isn't successful, echo an error.
          // Else, proceed.
          if (!$dbConn) {
            echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
          } else {
            // Query the database for a user with the provided credentials.
            $row = selectPrivilegedUser($dbConn, $_POST['userName'], $_POST['password']);
            $privilege = $row[0];
            $fullname = $row[1];
            // If the privilege of the result of the query is Admin or Marker,
            // store the login credentials in the session.
            // Else, echo an error.
            if ($privilege == 'Marker' || $privilege == 'Admin' || $privilege == 'marker' || $privilege == 'admin'){
              echo $fullname . ": Marker";
              $_SESSION['valid'] = true;
              $_SESSION['privilege'] = $privilege;
              $_SESSION['fullName'] = $fullname;
              $_SESSION['userName'] = $_POST["userName"];
              // If the user is a Marker, redirect to Marker pages.
              // Otherwise, if user is an Admin, redirect to admin pages.
              if ($privilege == 'Marker' || $privilege == 'marker'){
                header("Location: ../Marker/MarkerMain.php");
                exit();
              } else if ($privilege == 'Admin' || $privilege == 'admin'){
                header("Location: ../Admin/addCompetition.php");
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
          <input type="text" name ="userName" >
          <br>
          Password
          <br>
          <input type="password" name ="password" >
          <br>
          <button type="submit" name="login" >Login</button>
        </form>

      </div>
    </div>
  </div>
</body>
</html>
