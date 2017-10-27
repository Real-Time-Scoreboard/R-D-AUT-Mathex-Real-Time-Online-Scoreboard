
<?php


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

}


echo json_encode($msg);
 closeConn($dbConn);
?>
