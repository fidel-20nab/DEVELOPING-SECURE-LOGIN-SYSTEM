<?php
session_start();
session_unset();
session_destroy();
setcookie("loggedin", "", time() - 3600); // Clear cookie
header("Location: index.html");
?>
