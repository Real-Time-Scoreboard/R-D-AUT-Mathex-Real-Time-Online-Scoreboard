
<?php

include '../../DataBaseManagement/ConnectionManager.php';
include '../../DataBaseManagement/SelectData.php';

$dbConn = openConnection();

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
} else {
    echo "Failed";
}
 closeConn($dbConn);

echo $string;

?>
