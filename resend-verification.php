<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('inc/head.php'); ?>

  <title>SNOMED CT GP/FP RefSet Field Test - Resend verification</title>
</head>
<body>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">

      <div class="page-header">
        <h1>Resend verification</h1>
      </div>

      <div class="row">
        <div class="span12">
          <div class="well">
            <p class="lead">Please enter your email address below to receive a reminder of your verification code.</p>
          </div>
        </div>
      </div>

      <div class="row span8 offset2">
        <form class="form-horizontal" id="resend-verification" method="post" action="xxx.php">
          <fieldset>
            <div class="control-group">
              <label class="control-label" for="resend-email">Email address</label>
              <div class="controls">
                <input type="text" id="resend-email" name="resend-email" placeholder="Email address">
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

    </div>
    <?php require('inc/footer.php'); ?>
  </div>

<?php require('inc/script.php'); ?>
</body>
</html>