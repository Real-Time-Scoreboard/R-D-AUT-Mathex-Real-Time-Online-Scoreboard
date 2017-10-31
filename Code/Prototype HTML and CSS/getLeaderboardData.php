<?php
include '../DataBaseManagement/ConnectionManager.php';
include '../DataBaseManagement/SelectData.php';

$dbConn = openConnection();
$activeCompetition = $_GET['activeCompetition'];
$selectedTeam = $_GET['selectedTeam'];

$teamNames = array();
$teamData = array();
$topTeamData = array();
$selectedTeamData = array();

$result = selectTopScores($dbConn,$activeCompetition);

while ($row = pg_fetch_row($result)){
  array_push($teamNames, $row[0]);
  array_push($teamData, $row[1]);
}

$result = selectTopTeam($dbConn, $activeCompetition);

while ($row = pg_fetch_row($result)){
  array_push($topTeamData, $row[0]);
  array_push($topTeamData, $row[1]);
  array_push($topTeamData, $row[2]);
  array_push($topTeamData, $row[3]);
  array_push($topTeamData, $row[4]);
}

if($selectedTeam != null){
  $result = selectTeamData($dbConn, $activeCompetition, $selectedTeam);
  while ($row = pg_fetch_row($result)){
    array_push($selectedTeamData, $row[0]);
    array_push($selectedTeamData, $row[1]);
    array_push($selectedTeamData, $row[2]);
    array_push($selectedTeamData, $row[3]);
    array_push($selectedTeamData, $row[4]);
  }
}

echo json_encode(array($teamNames,$teamData,$topTeamData,$selectedTeamData));
?>
