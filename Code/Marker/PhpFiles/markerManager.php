
<?php

/** Handles the request from marker.js. Checque what the request is and then perform the corrrect updates on the database.
* It return the appropriate message to the client using jason encoding
**/

include '../../DataBaseManagement/ConnectionManager.php';
include '../../DataBaseManagement/SelectData.php';
include '../../DataBaseManagement/UpdateData.php';



$dbConn = openConnection();

//Array to be encoded
$msg = (object) [];
$msg -> result = true;

if(isset($_POST['request'])){// confirn request exists

  $request = $_POST['request'];
  $compId = $_POST['compId'];// this varaible is used for any request

  if( $request !== "DropBoxContent"){

    //Initiate all these variables if the request is not simply get the teams from the db (DropBoxContent)
    $currentQuestion = $_POST['currentQuestion'];
    $userName = $_POST['userName'];
    $initials = $_POST['teamInitials'];

    $result = selectTeamRecord($dbConn,$compId, $initials); // get the team to be updated. this is important to be able to update the information correctly

    if($result !== false) {
    	$TeamRecord = pg_fetch_assoc($result);
    	$currquestion =$TeamRecord['currentquestion'];
      $totalcorrectquestions = $TeamRecord['totalcorrectquestions'];
      $totalpasses = $TeamRecord['totalpasses'];
      $score = $TeamRecord['currentscore'];
    }

  }

  switch ($request) {
      case "DropBoxContent":

      $result = selectAllActiveTeams($dbConn,$compId);
         $string = "";

         if (($count= pg_num_rows($result)) >= 1) {
             for ($x = 1; $x <= $count; $x++) {
                 $row = pg_fetch_row($result);
                 $string .= $row[0];
                 if ($x != $count) {
                     $string .= ",";
                 }
             }
         }
         $msg -> result= $string;

          break;
      case "Correct":
      updateTeamRecord($dbConn, $compId, $initials, $TeamRecord['assigned'], $currquestion+1, $totalcorrectquestions + 1,$totalpasses ,$score+5);
          break;
      case "Undo":
            $prevAction = $_POST['prevAction'];

            if($prevAction ==="Correct"){
              updateTeamRecord($dbConn, $compId, $initials, $TeamRecord['assigned'], $currquestion-1, $totalcorrectquestions-1,$totalpasses ,$score-5);
            }
            if($prevAction === "Pass"){
              updateTeamRecord($dbConn, $compId, $initials, $TeamRecord['assigned'], $currquestion-1, $totalcorrectquestions,$totalpasses-1,$score);
            }
            if($prevAction === "Undo"){
              $msg -> result = false;
              $msg -> error = "You can't undo more than Once";
            }

          break;
      case "Pass":

          updateTeamRecord($dbConn, $compId, $initials, $TeamRecord['assigned'], $currquestion+1, $totalcorrectquestions,$totalpasses+1 ,$score);

          break;
      case "Incorrect":

          break;
  }
}

 closeConn($dbConn);
 echo json_encode($msg);


?>
