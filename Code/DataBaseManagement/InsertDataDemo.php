<?php
include 'ConnectionManager.php';
include 'InsertData.php';
include 'UpdateData.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="content-type" content="text/html";charset="utf-8"/>
  <meta name="description" content = "WebDevelopment: Assignment1"/>
  <meta name="keywords" content="web,development,assignment"/>
  <title>Testx</title>
</head>
<body>
  <h1>Demo</h1>

  <?php

  //get current Time from server
  date_default_timezone_set('NZ');
  //date('H:i:s');

  $dbConn = openConnection();

  if (!$dbConn) {
      echo "Connection Failed: <br/>".pg_last_error($dbConn) ;
  } else {
      echo "Connected succesfully <br/>";
  }


  insertIntoCompetition($dbConn, "Comp01", date('H:i:s'));
  insertIntoCompetition($dbConn, "Comp02", date('H:i:s'));
  insertIntoCompetition($dbConn, "Comp03", date('H:i:s'));
  insertIntoCompetition($dbConn, "Comp04", date('H:i:s'));


  insertIntoTeam($dbConn, "AUT", "Auckland University of technology");
  insertIntoTeam($dbConn, "AU", "Auckland University ");
  insertIntoTeam($dbConn, "SCO", "SCO");
  insertIntoTeam($dbConn, "TRE", "TRE");
  insertIntoTeam($dbConn, "TEST", "TEST");
  insertIntoTeam($dbConn, "NOS", "NOS");

  insertNewTeamRecord($dbConn, "COMP01", "AUT");
  insertNewTeamRecord($dbConn, "COMP01", "AU");
  insertNewTeamRecord($dbConn, "COMP01", "SCO");


  insertNewUser($dbConn, "Marker01", "Mathex", "password", "Marker");
  insertNewUser($dbConn, "Marker02", "Mathex", "password", "Marker");
  insertNewUser($dbConn, "Marker03", "Mathex", "password", "Marker");
  insertNewUser($dbConn, "Marker04", "Mathex", "password", "Marker");

  insertNewUser($dbConn, "Admin", "Admin", "password", "Admin");

  updateCompetitionEntry($dbConn, "COMP01", date('H:i:s'), 1);
  updateCompetitionEntry($dbConn, "COMP02", date('H:i:s'), 0);

  if (closeConn($dbConn)) {
      echo "<br/>Connection closed";
  }
  ?>
</body>
</html>
