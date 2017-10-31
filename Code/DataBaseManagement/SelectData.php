
<?php

function selectTeamInitials($dbConn)
{
    $query = "SELECT teamInitials from team";
    return $result = pg_query($dbConn, $query);
}

function selectCurrentComp($dbConn){
  $query = "SELECT competitionid FROM competition where active = true";
  $result = pg_query($dbConn, $query);
  if (( pg_num_rows($result)) > 0) {
      $row = pg_fetch_row($result);
      return $row[0];
  } else {
      return false;
  }
}

function selectTeamRecord($dbConn,$compId, $teamName)
{
    $query = "SELECT * from teamrecord WHERE teamInitials = '$teamName' and competitionID = '$compId' ";
    $result = pg_query($dbConn, $query);

    if ((pg_num_rows($result)) > 0) {
        return $result;
    } else {
        return false;
    }

}
function isTeamNotSelected ($dbConn,$compId, $teamName){
  $query = "SELECT teamInitials from teamrecord WHERE teamInitials = '$teamName' and competitionID = '$compId' AND assigned = false";
  $result = pg_query($dbConn, $query);

  if ((pg_num_rows($result)) > 0) {
      return true;
  } else {
      return false;
  }
}

function canMakerAssignedTeam($dbConn,$compId, $userName){
  $query = "SELECT COUNT(teamInitials) from teamrecord WHERE  competitionID = '$compId' AND username = '$userName'";
  $result = pg_query($dbConn, $query);
  $row = pg_fetch_row($result);
  if ($row[0] >= 2) {
      return false;
  } else {
      return true;
  }
}

function getMakerAssignedTeam($dbConn,$compId, $userName){
  $query = "SELECT teamInitials from teamrecord WHERE  competitionID = '$compId' AND username = '$userName'";
  return $result = pg_query($dbConn, $query);

}

function selectPrivilegedUser($dbConn, $username, $password)
{
	$query = "SELECT privilege, fullname FROM PrivilegedUser WHERE username = '$username' AND password = '$password'";
  $result = pg_query($dbConn, $query);
  return pg_fetch_row($result);
}

function selectTopScores($dbConn, $activeCompetition){
  $query = "SELECT teaminitials, currentscore FROM TeamRecord WHERE competitionid = '$activeCompetition' ORDER BY currentscore DESC LIMIT 5";
  return pg_query($dbConn, $query);
}

function selectAllActiveTeams($dbConn, $activeCompetition) {
  $query = "SELECT * FROM team INNER JOIN TeamRecord ON team.teamInitials = TeamRecord.teamInitials WHERE competitionid = '$activeCompetition' ORDER BY teamname ASC";
  return pg_query($dbConn, $query);
}

function selectAllTeams($dbConn) {
  $query = "SELECT * FROM team ORDER BY teamname ASC";
  return pg_query($dbConn, $query);
}

function selectAllUsers($dbConn) {
  $query = "SELECT * FROM privilegeduser ORDER BY fullname DESC";
  return pg_query($dbConn, $query);
}

function selectAllCompetitions($dbConn) {
  $query = "SELECT * FROM competition ORDER BY competitionid DESC";
  return pg_query($dbConn, $query);
}

function selectCompetitionID($dbConn, $competitionid) {
  $query = "SELECT * FROM Competition WHERE competitionid = '$competitionid'";
  $result = pg_query($dbConn, $query);
  return pg_fetch_row($result);
}

function selectUser($dbConn, $username, $fullname, $password, $privilege) {
  $query = "SELECT * FROM privilegeduser WHERE username = '$username' AND fullname = '$fullname' AND password = '$password' AND privilege = '$privilege'";
  $result = pg_query($dbConn, $query);
  return pg_fetch_row($result);
}

function selectStartTime($dbConn, $activeCompetition){
  $query = "SELECT starttime FROM competition WHERE competitionid = '$activeCompetition'";
  return pg_fetch_row(pg_query($dbConn, $query))[0];
}

function selectTopTeam($dbConn, $activeCompetition){
  $query = "SELECT teaminitials, currentscore, currentQuestion, totalCorrectQuestions, totalPasses FROM TeamRecord WHERE competitionId = '$activeCompetition' ORDER BY currentscore DESC LIMIT 1";
  return pg_query($dbConn, $query);
}

function selectTeamData($dbConn, $activeCompetition, $selectedTeam){
  $query = "SELECT teaminitials, currentscore, currentQuestion, totalCorrectQuestions, totalPasses FROM TeamRecord WHERE competitionId = '$activeCompetition' AND teaminitials = '$selectedTeam' LIMIT 1";
  return pg_query($dbConn, $query);
}
?>
