<?php

function updateCompetitionEntry($dbConn, $compID,$active)
{
    $query = "UPDATE Competition SET startTime = current_time, active = '$active' WHERE competitionId = '$compID'";
    return $result = pg_query($dbConn, $query);
}

function updateTeamName($dbConn, $initials, $tName)
{
    $query = "Update Team
  SET
  teamName = '$tName'
  Where
  teamInitials = '$initials'";
    return $result = pg_query($dbConn, $query);
}

function updateTeamRecord($dbConn, $compId, $initials, $assigned, $currquestion, $correctquest, $passes, $score)
{
    $result = pg_prepare($dbConn, "UpdateRecord_query", "UPDATE TeamRecord
    SET
    	assigned = $1,
    	currentQuestion = $2,
    	totalCorrectQuestions = $3,
    	totalPasses = $4,
    	currentScore = $5
    Where
    competitionId = $6
    AND
    teamInitials = $7
    ");
    return $result = pg_execute($dbConn, "UpdateRecord_query", array($assigned, $currquestion, $correctquest,
    $passes, $score, $compId, $initials));
}

function assignMarkertoTeam($dbConn, $compId, $initials, $userName)
{
    $result = pg_prepare($dbConn, "UpdateRecordMarker_query", "UPDATE TeamRecord
    SET
    	assigned = $1,
    	userName = $2
    Where
    competitionId = $3
    AND
    teamInitials = $4
    ");
    return $result = pg_execute($dbConn, "UpdateRecordMarker_query", array(1, $userName,$compId, $initials));
}

function deselectTeam($dbConn, $compId, $initials)
{
    $result = pg_prepare($dbConn, "UpdateRecordMarker_query", "UPDATE TeamRecord
    SET
    	assigned = $1,
    	userName = $2
    Where
    competitionId = $3
    AND
    teamInitials = $4
    ");
    return $result = pg_execute($dbConn, "UpdateRecordMarker_query", array(0, null,$compId, $initials));
}

function deleteTeam($dbConn, $teamName, $teamInitials) {
  $query = "DELETE FROM team WHERE teamname = '$teamName' AND teaminitials = '$teamInitials'";
  return $result = pg_query($dbConn, $query);
}

function deleteUser($dbConn, $userName, $fullName) {
  $query = "DELETE FROM privilegeduser WHERE username = '$userName' AND fullname = '$fullName'";
  return $result = pg_query($dbConn, $query);
}

function deleteTeamRecord($dbConn, $teamInitials, $competitionid) {
  $query = "DELETE FROM TeamRecord WHERE teaminitials = '$teamInitials' AND competitionid = '$competitionid'";
  return $result = pg_query($dbConn, $query);
}

function deleteCompetition($dbConn, $competitionid) {
  $query = "DELETE FROM competition WHERE competitionid = '$competitionid'";
  return $result = pg_query($dbConn, $query);
}

?>
