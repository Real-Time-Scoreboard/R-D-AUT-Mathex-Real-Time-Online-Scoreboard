<?php

function selectTeamInitials($dbConn)
{
    $query = "SELECT teamInitials FROM Team";
    return $result = pg_query($dbConn, $query);
}

function selectPrivilegedUser($dbConn, $username, $password)
{
	$query = "SELECT privilege, fullname FROM PrivilegedUser WHERE username = '$username' AND password = '$password'";
  $result = pg_query($dbConn, $query);
  return pg_fetch_row($result);
}

function selectActiveCompetition($dbConn){
  $query = "SELECT competitionid FROM Competition WHERE active = 'true'";
  $result = pg_query($dbConn, $query);
  return pg_fetch_row($result)[0];
}

function selectTopScores($dbConn, $activeCompetition){
  $query = "SELECT teaminitials, currentscore FROM TeamRecord WHERE competitionid = '$activeCompetition' ORDER BY currentscore DESC LIMIT 5";
  return pg_query($dbConn, $query);
}

function selectAllTeams($dbConn, $activeCompetition) {
  $query = "SELECT teamname FROM team INNER JOIN TeamRecord ON team.teamInitials = TeamRecord.teamInitials WHERE competitionid = '$activeCompetition' ORDER BY teamname DESC";
  return pg_query($dbConn, $query);
}

function selectCompetitionID($dbConn, $competitionid) {
  $query = "SELECT * FROM Competition WHERE competitionid = '$competitionid'";
  $result = pg_query($dbConn, $query);
  return pg_fetch_row($result);
}

function selectTeam($dbConn, $teamInitials, $teamName) {
  $query = "SELECT * FROM team WHERE teaminitials = '$teamInitials' OR teamname = '$teamName'";
  $result = pg_query($dbConn, $query);
  return pg_fetch_row($result);
}

function selectUser($dbConn, $username, $fullname, $password, $privilege) {
  $query = "SELECT * FROM privilegeduser WHERE username = '$username' AND fullname = '$fullname' AND password = '$password' AND privilege = '$privilege'";
  $result = pg_query($dbConn, $query);
  return pg_fetch_row($result);
}

?>