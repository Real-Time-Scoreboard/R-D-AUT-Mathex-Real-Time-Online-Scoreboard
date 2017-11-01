<!-- Refers to the MarkerMain.php Page for more details -->

<?php
session_start();

$name ;

if (isSet($_SESSION['fullName'])){
  $name =  $_SESSION['fullName'];

}

?>

<!DOCTYPE html5>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="../bootstrap-4.0.0-beta-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../style/mainStyler.css">
  <script type="text/javascript" src="../JQuery/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="JsFiles/marker.js"></script>
  <script src="../bootstrap-4.0.0-beta-dist/js/bootstrap.min.js"></script>
</head>

<body>

  <div class="mx-auto text-center center_div" id="homePage">
    <h2>Welcome to MATHEX Marker System</h2>

    <p>Logged in as: <?php echo $name?></p>
    <p>Please select the teams you want to mark to get started</p>
    <p>Go to the tab "Select Team"</p>
  </div </body>

</html>
