
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

?>
