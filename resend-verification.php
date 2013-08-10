<?php
require ('inc/head.php');
require ('inc/conn.php');
?>

  <title>SNOMED CT GP/FP RefSet Field Test - Resend verification</title>
</head>
<body>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">

      <div class="page-header">
        <h1>Resend verification</h1>
      </div>
<?php
if($_SESSION["logged"]){
  include('inc/already-logged-in.php');
} else if($_POST["resendEmail"]){
  $sql = sprintf("SELECT * FROM Users WHERE email='%s'",
                 mysql_real_escape_string($_POST[resendEmail]));
  $rows = mysql_query($sql) or die(mysql_error());

  if(mysql_num_rows($rows)==1){
    $user = mysql_fetch_array($rows);
    if($user["verified"]){
      $message = '<div class="well"><p class="lead">'.$user["email"].' is already verified.</p><p><a class="btn btn-primary" href="/">Login</a></p></div>';
    } else {
      $emailText = "Hi ".$user["first_name"].".\r\n\r\nYou've asked to have your verification code re-sent, so here it is:\r\n".$user["verification"]."\r\n\r\nYou just need to go to ".$configvars["environment"]["url"]."/verify.php and enter it along with your email address to complete your registration.";
      $subject = $configvars["email"]["subjecttag"]." - Verification code reminder";
      $to = $_POST["resendEmail"];
      $headers = 'From: '.$configvars["email"]["fromname"].' <'.$configvars["email"]["fromemail"].'>' . "\r\n" . 'Reply-To: '.$configvars["email"]["fromname"].' <'.$configvars["email"]["fromemail"].'>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

      mail($to, $subject, $emailText, $headers);

      $message = '<div class="well"><p class="lead">Verification code resent to <strong>'.$user["email"].'</strong>.</p><p><a class="btn btn-primary" href="verify.php">Verify</a></p></div>';
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
} else {
?>
      <div class="row">
        <div class="span12">
          <div class="well">
            <p class="lead">Please enter your email address below to receive a reminder of your verification code.</p>
          </div>
        </div>
      </div>

      <div class="row span8 offset2">
        <form class="form-horizontal" id="resendVerification" name="resendVerification" method="post" action="resend-verification.php" data-validate="parsley">
          <fieldset>
            <div class="control-group">
              <label class="control-label" for="resendEmail">Email address</label>
              <div class="controls">
                <input type="text" id="resendEmail" name="resendEmail" placeholder="Email address" data-trigger="change" data-required="true" data-type="email">
              </div>
            </div>
            <div class="control-group">
              <div class="controls">
                <input type="submit" class="btn" value="Go">
              </div>
            </div>
            <div class="control-group">
              <div class="controls">
                <p><a href="verify.php">Enter verification code</a></p>
              </div>
            </div>
          </fieldset>
        </form>
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