
<?php
/**
* Note: pg_escape_string is said to increase security agaisnt attacks; however, parts of doumenation says you don't need
*to use it when using prepare statements, which helps with security too. I used it anyway. Also, pg_escape_literal is recommended but
* it will save the variables in the DB withing single quotes.
*/

function insertNewUser($dbConn, $userName, $name, $psw, $priv)
{
  $result = pg_prepare($dbConn, "newUser_query", "INSERT INTO privilegeduser VALUES ($1,$2, $3,$4)");
  return $result = pg_execute($dbConn, "newUser_query", array(pg_escape_string($userName),pg_escape_string($name),
  pg_escape_string($psw),pg_escape_string($priv)));
}

function insertIntoCompetition($dbConn, $compID, $startTime)
{
  //$query = "INSERT INTO Competition (competitionId, startTime, competitionDate)
  //VALUES ('pg_escape_string($compID)',pg_escape_string('$startTime'),CURRENT_DATE)";

  //$result = pg_query($dbConn, $query);

  $result = pg_prepare($dbConn, "competition_query", "INSERT INTO Competition (competitionId, startTime)
  VALUES ($1,$2)");

  return $result = pg_execute($dbConn, "competition_query", array(pg_escape_string($compID),pg_escape_string($startTime)));
}

function insertIntoTeam($dbConn, $initials, $tName)
{
  $result = pg_prepare($dbConn, "team_query", "INSERT INTO team (teamInitials, teamName) VALUES ($1,$2)");
  return $result = pg_execute($dbConn, "team_query", array(pg_escape_string($initials),pg_escape_string($tName)));
}

function insertNewTeamRecord($dbConn, $compID, $initials)
{
  $result = pg_prepare($dbConn, "createNewRecord_query", "INSERT INTO teamRecord (competitionid, teamInitials) VALUES ($1,$2)");
  return $result = pg_execute($dbConn, "createNewRecord_query", array(pg_escape_string($compID),pg_escape_string($initials)));
}

function insertFullNewTeamRecord($dbConn, $v1, $v2, $v3, $v4, $v5, $v6, $v7)
{
  $result = pg_prepare($dbConn, "createFullNewRecord_query", "INSERT INTO teamRecord
    (competitionid,teaminitials,assigned,currentquestion,totalcorrectquestions,totalpasses,currentscore)
    VALUES ($1,$2,$3,$4,$5,$6,$7)");
  return $result = pg_execute($dbConn, "createFullNewRecord_query", array($v1, $v2, $v3, $v4, $v5, $v6, $v7));
}

?>
