<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('inc/head.php'); ?>

  <title>SNOMED CT GP/FP RefSet Field Test - Complete field test</title>
</head>
<body>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">
      <div class="page-header">
        <h1>Complete field test</h1>
      </div>
<?php
if(!$_SESSION["logged"]){
  include('inc/not-logged-in.php');
} else {
  $rows = mysql_query("SELECT * FROM Users WHERE user_id='$_SESSION[user_id]'") or die(mysql_error());
  $user = mysql_fetch_array($rows);

  $encountersData = mysql_query("SELECT * FROM Encounters WHERE user_id='$_SESSION[user_id]' AND complete='1'") or die(mysql_error());
  $encounters = mysql_num_rows($encountersData);
?>
      <div class="row">
        <div class="span8 offset2">
          <?php
          if($encounters < $configvars["encounters"]["maxencounters"]){
            ?>
            <p>You have only completed <?= $encounters; ?> out of <?= $configvars["encounters"]["maxencounters"]; ?> encounters.</p>
            <?php  
          } else {
            mysql_query("UPDATE Users SET field_test_complete = '1' WHERE user_id = '$_SESSION[user_id]'") or die(mysql_error());
            ?>
            <p class="lead">You have completed the SNOMED CT Field Test.</p>
            <p>Thank you for your participation.</p>
            <?php
          }
          ?>
          <ul class="unstyled bigButtons">
            <li><a class="btn btn-large btn-block btn-primary" href="/">Home</a></li>
          </ul>
        </div>
      </div>
<?php
}
?>
    </div>
    <?php require('inc/footer.php'); ?>
  </div>

<?php require('inc/script.php'); ?>
</body>
</html>