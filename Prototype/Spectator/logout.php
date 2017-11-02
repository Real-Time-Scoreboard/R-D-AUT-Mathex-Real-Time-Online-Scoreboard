<!--
This file is called to logout the user.
It destroys the session in which the login data is stored.
After that, it redirects the user to welcome.html.
-->

<?php
  session_start();
  session_unset();
  session_destroy();
  header("Location: welcome.html");
?>
