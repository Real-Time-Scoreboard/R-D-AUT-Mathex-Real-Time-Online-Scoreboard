<?php

function updateCompetitionEntry($dbConn, $compID, $startTime)
{
    $query = "UPDATE Competition SET startTime = '$startTime' WHERE competitionId = '$compID'";
    return $result = pg_query($dbConn, $query);
}

function updateSchoolName($dbConn, $initials, $sName)
{
    $query = "Update Schools
  SET
  Schoolname = '$sName'
  Where
  schoolInitials = '$initials'";
    return $result = pg_query($dbConn, $query);
}

function updateTeamRecord($dbConn, $compId, $Initials, $assigned, $currquestion, $correctquest, $passes, $score)
{
    $result = pg_prepare($dbConn, "UpdateRecord_query", "UPDATE TeamRecord
    SET
    	assigned = $1,
    	currentQuestionNumber = $2,
    	totalCorrectQuestion = $3,
    	totalPasses = $4,
    	currentScore = $5
    Where
    competitionId = $6
    AND
    schoolInitials = $7
    ");
    return $result = pg_execute($dbConn, "UpdateRecord_query", array($assigned, $currquestion, $correctquest,
    $passes, $score, $compId, $Initials));
}
