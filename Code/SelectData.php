
<?php

function selectTeamInitials($dbConn)
{
    $query = "SELECT teamInitials from team";
    return $result = pg_query($dbConn, $query);
}

?>
