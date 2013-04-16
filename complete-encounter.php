<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('inc/head.php'); ?>

  <title>SNOMED CT GP/FP RefSet Field Test - Complete encounter</title>
</head>
<body>
<?php
if($_SESSION["logged"]){
  if(!is_null($_SESSION["encounter_id"])){
    $sql = "UPDATE Encounters SET complete = 1 WHERE encounter_id = '$_SESSION[encounter_id]'";
    mysql_query($sql) or die(mysql_error());
    $_SESSION ["encounter_id"] = null;
    $_SESSION ["add_mode"] = null;
    $_SESSION ["rfe_id"] = null;
    $_SESSION ["label"] = null;

    $message = '<div class="alert alert-success">Encounter successfully completed</div>';
  }
}
?>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">
      <div class="page-header">
        <h1>Complete encounter</h1>
      </div>
<?php
if(!$_SESSION["logged"]){
  include('inc/not-logged-in.php');
} else {
  if($message){
    echo $message;
  }

  $encountersData = mysql_query("SELECT * FROM Encounters WHERE user_id='$_SESSION[user_id]' AND complete='1'") or die(mysql_error());
  $encounters = mysql_num_rows($encountersData);
?>
      <div class="row">
        <div class="span8 offset2">
          <p class="lead">You have completed <?= $encounters; ?> of 100 encounters.</p>
          <a class="btn btn-large btn-block btn-primary" href="add-item.php">Add another encounter</a>
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