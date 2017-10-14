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
  if (insertIntoCompetition($dbConn, "Comp02", date('H:i:s'))) {
      echo "<br/>Inserted into Competition Successfully <br/>";
  } else {
      echo "<br/>Insert into Competition Failed: <br/>".pg_last_error($dbConn)."<br/>".pg_result_error($dbConn);
  }

  insertIntoTeam($dbConn, "AU", "Auckland University of technology");
  if (insertIntoTeam($dbConn, "AU", "Auckland University ")) {
      echo "<br/>Inserted into Schools Successfully <br/>";
  } else {
      echo "<br/>Insert into Schools Failed: <br/>".pg_last_error($dbConn)."<br/>".pg_result_error($dbConn);
  }

  if (insertNewTeamRecord($dbConn, "COMP01", "AUT")) {
      echo "<br/>Inserted new team record successfully <br/>";
  } else {
      echo "<br/>Inserting new record failed: <br/>".pg_last_error($dbConn)."<br/>".pg_result_error($dbConn);
  }

  if (insertFullNewTeamRecord($dbConn, "COMP02", "AU", 1, 1, 1, 1, 1)) {
      echo "<br/>Inserted full new team record successfully <br/>";
  } else {
      echo "<br/>Inserting a full new record failed: <br/>".pg_last_error($dbConn)."<br/>".pg_result_error($dbConn);
  }

  if (insertNewUser($dbConn, "Marker04", "Mathex", "maker01", "marker")) {
      echo "<br/>Inserted new user successfully <br/>";
  } else {
      $error = pg_last_error($dbConn);
      echo "<br/>Insert new user failed: <br/>".$error."<br/>".pg_result_error($error);
  }

  if (updateCompetitionEntry($dbConn, "COMP01", date('H:i:s'))) {
      echo "<br/>updateCompetitionEntry successfully <br/>";
  } else {
      $error = pg_last_error($dbConn);
      echo "<br/>updateCompetitionEntry failed: <br/>".$error."<br/>";
  }

  if (updateTeamName($dbConn, "AUT", "MoneyMaker")) {
      echo "<br/>updateSchoolName successfully <br/>";
  } else {
      $error = pg_last_error($dbConn);
      echo "<br/>updateSchoolName failed: <br/>".$error."<br/>";
  }

  if (updateTeamRecord($dbConn, "COMP01", "AUT", 1, 5, 6, 0, 25)) {
      echo "<br/>updateTeamRecord successfully <br/>";
  } else {
      $error = pg_last_error($dbConn);
      echo "<br/>updateTeamRecord failed: <br/>".$error."<br/>";
  }

  if (closeConn($dbConn)) {
      echo "<br/>Connection closed";
  }
  ?>
</body>
</html>
