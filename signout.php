<?php
session_start();

$_SESSION = array(); // Load all session variables

session_destroy();

header("Location: index.php");
exit();
?>