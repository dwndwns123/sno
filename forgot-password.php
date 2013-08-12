<?php require ('inc/head.php'); ?>

<title>SNOMED CT GP/FP RefSet Field Test - New password</title>
</head>
<body>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">

      <div class="page-header">
        <h1>New password</h1>
      </div>
<?php
if($_SESSION["logged"]){
  include('inc/already-logged-in.php');
} else if($_POST["forgotEmail"]){
  $sql = sprintf("SELECT * FROM Users WHERE email='%s'",
                 mysql_real_escape_string($_POST[forgotEmail]));
  $checkUser = mysql_query($sql) or die(mysql_error());
  $user = mysql_fetch_array($checkUser);
  if(mysql_num_rows($checkUser)==1){
    $pw = substr(md5(rand()), 0, 10);

    $emailText = "You have requested a new password for the SNOMED CT Field Test Website.\r\n\r\nA new password has been randomly generated for you, and has replaced your old password with immediate effect.\r\n\r\nYour new password is: ".$pw."\r\n\r\nYou may log into the site using this password, and then change it to something more memorable. Remember, it is case-sensitive.";
    $subject = $configvars["email"]["subjecttag"]." - Password Reset";
    $to = $user["email"];
    $headers = 'From: '.$configvars["email"]["fromname"].' <'.$configvars["email"]["fromemail"].'>' . "\r\n" . 'Reply-To: '.$configvars["email"]["fromname"].' <'.$configvars["email"]["fromemail"].'>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $emailText, $headers);

    $sql = "UPDATE Users SET password='".md5($pw)."' WHERE email='".$user['email']."'";
    mysql_query($sql) or die(mysql_error());

    $message = '<div class="well"><p class="lead">A temporary password has been sent to <strong>'.$user["email"].'</strong>.</p><p>Please check your email for instructions.</p><p><a class="btn btn-primary" href="/">Log in</a></p></div>';
  } else {
    $message = '<div class="alert alert-error">Email address not recognised.</div><p><a class="btn btn-primary" href="forgot-password.php">Try again</a></p>';
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
            <p class="lead">Please enter your email address below to receive a temporary password.</p>
          </div>
        </div>
      </div>

      <div class="row span8 offset2">
        <form class="form-horizontal" id="forgotPassword" name="forgotPassword" method="post" action="forgot-password.php" data-validate="parsley">
          <fieldset>
            <div class="control-group">
              <label class="control-label" for="forgotEmail">Email address</label>
              <div class="controls">
                <input type="text" id="forgotEmail" name="forgotEmail" placeholder="Email address" data-trigger="change" data-required="true" data-type="email">
              </div>
            </div>
            <div class="control-group">
              <div class="controls">
                <input type="submit" class="btn" value="Go">
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