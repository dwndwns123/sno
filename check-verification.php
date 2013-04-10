<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('inc/head.php'); ?>

  <title>SNOMED CT GP/FP RefSet Field Test - Check verification</title>
</head>
<body>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">

      <div class="page-header">
        <h1>Check verification</h1>
      </div>
<?php
if($_SESSION["logged"]){
  include('inc/already-logged-in.php');
} else {
  $rows = mysql_query("SELECT * FROM Users WHERE email='$_POST[verEmail]'") or die(mysql_error());
  if(mysql_num_rows($rows)==1){
    $user = mysql_fetch_array($rows);
    if($_POST["verCode"]==$user["verification"]){

      $sql = "UPDATE Users SET verified='1' WHERE email='".$user['email']."'";
      mysql_query($sql) or die(mysql_error());

      $_SESSION["title"] = $user["title"];
      $_SESSION["first_name"] = $user["first_name"];
      $_SESSION["last_name"] = $user["last_name"];
      $_SESSION["email"] = $user["email"];
      $_SESSION["user_id"] = $user["user_id"];
      $_SESSION["logged"] = true;
      $_SESSION["sentpass"] = false;

      //TODO: generate and send 'you have verified' email

      $message = '<p class="lead">Verification successful.</p><p>You are now logged in as <strong>'.$_SESSION["email"].'</strong>.</p><p><a class="btn btn-primary" href="/">Home</a></p>';
    } else {
      $message = '<div class="alert alert-error">Verification unsuccessful.</div><p>Make sure you copy/paste the whole verification code.</p><p><a class="btn btn-primary" href="verify.php">Try again</a></p>';
    }
  } else {
    $message = '<div class="alert alert-error">Email address not recognised.</div><p><a class="btn btn-primary" href="verify.php">Try again</a></p>';
  }
?>
      <div class="row">
        <div class="span12">
          <!-- <p class="lead">Verification successful.</p><p>You are now logged in as <strong>xxx@yyyyyyy.zzz</strong>.</p><p><a class="btn btn-primary" href="/">Home</a></p> -->
          <?= $message; ?>
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