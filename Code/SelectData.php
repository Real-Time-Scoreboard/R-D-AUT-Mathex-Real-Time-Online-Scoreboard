
<?php

function selectTeamInitials($dbConn)
{
    $query = "SELECT teamInitials FROM Team";
    return $result = pg_query($dbConn, $query);
}

function selectPrivilegedUser($dbConn, $username, $password)
{
	$query = "SELECT privilege, fullname FROM PrivilegedUser WHERE username = '$username' AND password = '$password'";
  $result = pg_query($dbConn, $query);
  return $row = pg_fetch_row($result);
}
?>
