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

  insertFullNewTeamRecord($dbConn, "COMP02", "TRE", 1, 1, 1, 1, 1);
  insertFullNewTeamRecord($dbConn, "COMP02", "TEST", 1, 1, 1, 1, 1);
  insertFullNewTeamRecord($dbConn, "COMP02", "NOS", 1, 1, 1, 1, 1);

  insertNewUser($dbConn, "Marker01", "Mathex", "maker01", "marker");
  insertNewUser($dbConn, "Marker02", "Mathex", "maker02", "marker");
  insertNewUser($dbConn, "Marker03", "Mathex", "maker03", "marker");
  insertNewUser($dbConn, "Marker04", "Mathex", "maker04", "marker");

  updateCompetitionEntry($dbConn, "COMP01", date('H:i:s'), 1);
  updateCompetitionEntry($dbConn, "COMP02", date('H:i:s'), 0);

  if (closeConn($dbConn)) {
      echo "<br/>Connection closed";
  }
  ?>
</body>
</html>
