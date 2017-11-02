<?php
/**
*Handles only action from the select menu option from markers page.
*it either select and assign it to the marker or deselect it.
*Also do checks to ensure:
*- if marker has not more than 2 teans assigned to them
*- if a selected team is not already selected
*- if a team is not assigned already
**/

include '../../DataBaseManagement/ConnectionManager.php';
include '../../DataBaseManagement/SelectData.php';
include '../../DataBaseManagement/UpdateData.php';

$msg = (object) [];
$msg -> result = false;

$dbConn = openConnection();

if(isset($_POST['selectTeam'])){

  $initials = $_POST['selectTeam'];
  $userName = $_POST['marker'];
  $compId = $_POST['compId'];

  if( $compId === false){
        $msg -> error = "There is no active competition";
  }
  else{
      if(canMakerAssignedTeam($dbConn,$compId, $userName)){

         if( isTeamNotSelected($dbConn,$compId,$initials) === true){
            if(assignMarkertoTeam($dbConn, $compId, $initials, $userName)){
              $msg -> result = true;
              $msg -> error = "Team Assigned successfully";
            }
        }else{
          $msg -> error = "This team is already been marked by another marker";
        }
      }else{
        $msg -> error = "You have 2 teams already assigned to you in the current competition";
      }
    }

}else{
  $initials = $_POST['unselectTeam'];
  $compId = $_POST['compId'];

  if(deselectTeam($dbConn, $compId, $initials)){
    $msg -> result = true;
    $msg -> error = "Team has been deselected successfully";
  }else{
    $msg -> result = false;
    $msg -> error = "Deselected Failed";
  }
}


echo json_encode($msg);
 closeConn($dbConn);
?>
