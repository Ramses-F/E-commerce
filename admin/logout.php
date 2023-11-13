<?php
session_start();
$_SESSION = array();
$_SESSION[] = array();
session_unset();
session_destroy();

header("location: index.php");
?>

