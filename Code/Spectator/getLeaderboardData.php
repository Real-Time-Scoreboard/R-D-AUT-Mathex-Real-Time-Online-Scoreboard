<?php
// This page is used in conjunction with leaderboard.php, leaderboard.js,
// and xhr.js for an ajax implementation of the system.
// This file is called by the getData method inside leaderboard.js through an
// xhr object.
// It gathers the data from the database and returns it to the leaderboard.js file
// as an array containing arrays.

include '../DataBaseManagement/ConnectionManager.php';
include '../DataBaseManagement/SelectData.php';

// Create connection with database.
$dbConn = openConnection();
// Get the activeCompetition from the url.
$activeCompetition = $_GET['activeCompetition'];
// Get the selectedTeam from the url. Note this may be null.
$selectedTeam = $_GET['selectedTeam'];

// Initialise arrays for storing query data.
$teamNames = array();
$teamData = array();
$topTeamData = array();
$selectedTeamData = array();

// Get the top 5 scores for the competition.
$result = selectTopScores($dbConn,$activeCompetition);
// Iterate through the result object. Store the team initials and scores
// in the appropriate arrays.
while ($row = pg_fetch_row($result)){
  array_push($teamNames, $row[0]);
  array_push($teamData, $row[1]);
}

// Get the stats for the top team.
$result = selectTopTeam($dbConn, $activeCompetition);
// Store each field of data in an array.
while ($row = pg_fetch_row($result)){
  array_push($topTeamData, $row[0]);
  array_push($topTeamData, $row[1]);
  array_push($topTeamData, $row[2]);
  array_push($topTeamData, $row[3]);
  array_push($topTeamData, $row[4]);
}

// If selectedTeam isn't null, query the database for the stats of that team.
if($selectedTeam != null){
  $result = selectTeamData($dbConn, $activeCompetition, $selectedTeam);
  // Store each field of data in an array.
  while ($row = pg_fetch_row($result)){
    array_push($selectedTeamData, $row[0]);
    array_push($selectedTeamData, $row[1]);
    array_push($selectedTeamData, $row[2]);
    array_push($selectedTeamData, $row[3]);
    array_push($selectedTeamData, $row[4]);
  }
}

// return the data as a json encoded array containing 4 other arrays.
echo json_encode(array($teamNames,$teamData,$topTeamData,$selectedTeamData));
?>
