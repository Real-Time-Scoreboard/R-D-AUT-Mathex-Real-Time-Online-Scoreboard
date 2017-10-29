
<?php

include '../../DataBaseManagement/ConnectionManager.php';
include '../../DataBaseManagement/SelectData.php';
include '../../DataBaseManagement/UpdateData.php';



$dbConn = openConnection();

$msg = (object) [];
$msg -> result = true;

if(isset($_POST['request'])){

  $request = $_POST['request'];

  if( $request !== "DropBoxContent"){

    $currentQuestion = $_POST['currentQuestion'];
    $userName = $_POST['userName'];
    $compId = $_POST['compId'];
    $initials = $_POST['teamInitials'];

    $result = selectTeamRecord($dbConn,$compId, $initials);

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

      $result = selectTeamInitials($dbConn);
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
         echo $string;

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
