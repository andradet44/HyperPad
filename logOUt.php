<?php
// Ouvre session
session_start();

$_SESSION['user_id'] = NULL;
$_SESSION['login'] = NULL;

header("Location: index.php");
?>
