<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('inc/head.php'); ?>

  <title>SNOMED CT GP/FP RefSet Field Test - Review encounter</title>
</head>
<body>
<?php
if($_SESSION["logged"]){
  if($_POST["conceptsDropdown"] && $_POST["conceptRepresentation"] && $_POST["icpc2"] && $_POST["icpc2appropriate"]){ // all mandatory fields posted
    $sql = "UPDATE Encounter_Reasons SET refset_id = '$_SESSION[add_mode]', sct_id = '$_POST[conceptsDropdown]', sct_scale = '$_POST[conceptRepresentation]', sct_alt = '$_POST[conceptFreeText]', map_id = '$_POST[icpc2]', map_scale = '$_POST[icpc2appropriate]'".(!is_null($_POST["icpc2choice"]) ? ", map_alt_id = '$_POST[icpc2choice]'" : "")." WHERE rfe_id = '$_SESSION[rfe_id]'";
    mysql_query($sql) or die(mysql_error());
    $message = '<div class="alert alert-success">'.($_SESSION["add_mode"] == 0 ? "RFE" : "Health Issue").' number '.$_SESSION["rfe_id"].' successfully recorded.</div>';
  }
}
?>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">
      <div class="page-header">
        <h1>Profile</h1>
      </div>
<?php
if(!$_SESSION["logged"]){
  include('inc/not-logged-in.php');
} else {
  if($message){
    echo $message;
  }
?>
      <div class="row">
        <div class="span8 offset2">
          ENCOUNTERS GO HERE
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