<?php



/***Pg_connect does not return a error message, it instead returns a ResourceBundle
* See : https://stackoverflow.com/questions/4253136/how-to-catch-pg-connect-function-error
* this method will set all pg methods to thow aerror  instead of returning false
**rememeber to use try and catch. Otherwise use methods pg_last_error($dbConn) and pg_result_error($dbConn)
*/
/*
function exception_error_handler($errno, $errstr, $errfile, $errline)
{
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
set_error_handler("exception_error_handler"); // set exception

function openConnection()
{
    $conn_string = "host=localhost port=5432 dbname=postgres user=postgres password=password";
    try {
        //check documentation for the [, connection type]
        return $conn=@pg_connect($conn_string, PGSQL_CONNECT_FORCE_NEW);// any error message is surpressed "@"
        //die(pg_last_error()) -- need to remove the @
    } catch (Exception $e) {
        echo $e->getMessage();
        //return false;
    }
}
*/

function openConnection()
{
    $conn_string = "host=localhost port=5432 dbname=postgres user=postgres password=password";
    return $conn=pg_connect($conn_string, PGSQL_CONNECT_FORCE_NEW);// any error message is surpressed "@"
}

function closeConn($dbConn)
{
    return pg_close($dbConn);
}
