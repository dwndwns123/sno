<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('inc/head.php'); ?>

  <title>SNOMED CT GP/FP RefSet Field Test - Home</title>
</head>
<body>

<?php
    if($_SESSION["logged"]) {
        
        // clean up unfinished encounters and encounter reasons on logging out based on complete flag and user id

        $sql = "DELETE FROM Encounter_Reasons WHERE encounter_id IN (SELECT encounter_id FROM Encounters WHERE complete = '0' AND user_id = '$_SESSION[user_id]')";
        mysql_query($sql) or die(mysql_error());
        error_log($sql);
    
        $sql = "DELETE FROM Encounters WHERE complete = '0' AND user_id = '$_SESSION[user_id]'";
        mysql_query($sql) or die(mysql_error());
        error_log($sql);
    }
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
?>

  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">

      <div class="page-header">
        <h1>Log out</h1>
      </div>
      <div class="row">
        <div class="span12">
          <div class="well">
            <p class="lead">You have logged out of the SNOMED CT field test tool.</p>
            <p>Thank you for your participation.</p>
            <a href="index.php" class="btn btn-primary">Home</a>
          </div>
        </div>
      </div>

    </div>
    <?php require('inc/footer.php'); ?>
  </div>

<?php require('inc/script.php'); ?>
</body>
</html>