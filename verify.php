<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('inc/head.php'); ?>

  <title>SNOMED CT GP/FP RefSet Field Test - Registration confirmation</title>
</head>
<body>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">

      <div class="page-header">
        <h1>Registration confirmation</h1>
      </div>

      <div class="row">
        <div class="span12">
          <div class="well">
            <p class="lead">Thank you for registering for the GP/FP RefSet and ICPC mapping field test.</p>
            <p>A verification email has been sent to you.</p>
            <p>Please retrieve the verification code from this email and enter it below to confirm your email address.</p>
          </div>
        </div>
      </div>

      <div class="row span8 offset2">
        <form class="form-horizontal" id="verify" method="post" action="xxx.php" data-validate="parsley">
          <fieldset>
            <div class="control-group">
              <label class="control-label" for="ver-email">Email address</label>
              <div class="controls">
                <input type="text" id="username" name="ver-email" placeholder="Email address" value="xxx@yyyyyyy.zzz" data-trigger="change" data-required="true" data-type="email">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="verification">Verification code</label>
              <div class="controls">
                <input type="text" id="verification" name="verification" placeholder="Verification code">
              </div>
            </div>
            <div class="control-group">
              <div class="controls">
                <input type="submit" class="btn" value="Go">
              </div>
            </div>
            <div class="control-group">
              <div class="controls">
                <p><a href="resend-verification.php">Resend verification?</a></p>
              </div>
            </div>
          </fieldset>
        </form>
      </div>

    </div>
    <?php require('inc/footer.php'); ?>
  </div>

<?php require('inc/script.php'); ?>
</body>
</html>