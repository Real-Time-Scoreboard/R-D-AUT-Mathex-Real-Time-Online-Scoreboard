<?php

function updateCompetitionEntry($dbConn, $compID, $startTime)
{
    $query = "UPDATE Competition SET startTime = '$startTime' WHERE competitionId = '$compID'";
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

?>
