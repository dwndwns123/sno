<?php require ('inc/conn.php');

// extra error logging for hosting solution
include('inc/logging.php');

if (( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) && ($_SESSION['logged'])) { //have we expired?
    //redirect to logout.php
	session_destroy();
    header('Location: logout.php'); 
} else{ //if we haven't expired:
    $_SESSION['last_activity'] = time(); //this was the moment of last activity.
}
$pageName = basename($_SERVER['SCRIPT_NAME']);
error_log("This page is - '$pageName'");
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
