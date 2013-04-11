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
    if($user["verified"]){
      $message = '<div class="well"><p class="lead">'.$user["email"].' is already verified.</p><p><a class="btn btn-primary" href="/">Login</a></p></div>';
    } else {
      if($_POST["verCode"]==$user["verification"]){

        $sql = "UPDATE Users SET verified='1' WHERE email='".$user['email']."'";
        mysql_query($sql) or die(mysql_error());

        $tRows = mysql_query("SELECT * FROM Title WHERE title_id='$user[title_id]'") or die(mysql_error());
        $uTitle = mysql_fetch_array($tRows);

        $_SESSION["title"] = $uTitle["title"];
        $_SESSION["first_name"] = $user["first_name"];
        $_SESSION["last_name"] = $user["last_name"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["logged"] = true;

        $emailText = "Thanks for registering on the SNOMED CT Field Test Website.\r\n\r\nYour email address has now been verified and you can now log in normally at http://URL-TO-BE-DETERMINED/ any time.";
        $subject = "SNOMED CT Field Test Website - Registration Verified";
        $to = $_POST["regEmail"];
        $headers = 'From: SNOMED CT Field Test <test@example.com>' . "\r\n" . 'Reply-To: SNOMED CT Field Test <test@example.com>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $emailText, $headers);

        $message = '<div class="well"><p class="lead">Verification successful.</p><p>You are now logged in as <strong>'.$_SESSION["email"].'</strong>.</p><p><a class="btn btn-primary" href="/">Home</a></p></div>';
      } else {
        $message = '<div class="alert alert-error">Verification unsuccessful.</div><p>Make sure you copy/paste the whole verification code.</p><p><a class="btn btn-primary" href="verify.php">Try again</a></p>';
      }
    }
  } else {
    $message = '<div class="alert alert-error">Email address not recognised.</div><p><a class="btn btn-primary" href="verify.php">Try again</a></p>';
  }
?>
      <div class="row">
        <div class="span12">
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