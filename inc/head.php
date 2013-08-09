<?php
session_start();
// set time-out period (in seconds)
$inactive = 600;

// check to see if $_SESSION["timeout"] is set
if (isset($_SESSION["timeout"])) {
    // calculate the session's "time to live"
    $sessionTTL = time() - $_SESSION["timeout"];
    if ($sessionTTL > $inactive) {
        session_destroy();
        header("Location: /logout.php");
    }
}
$_SESSION["timeout"] = time();
?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/bootstrap-responsive.css">
<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />

<!--[if lt IE 8]><link rel="stylesheet" href="css/bootstrap-ie7buttonfix.css"><![endif]-->
<!--[if IE 8]><link rel="stylesheet" href="css/bootstrap-ie8buttonfix.css"><![endif]-->

<link rel="stylesheet" href="/css/style.css">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="IHTSDO">

<!--[if lt IE 9]>
<script src="/js/html5shiv.js"></script>
<![endif]-->
