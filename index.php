<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('inc/head.php'); ?>

  <title>SNOMED CT GP/FP RefSet Field Test - Home</title>
</head>
<body>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">

<?php
if(!$_SESSION["logged"]){
?>
<!-- IF NOT LOGGED IN -->
      <div class="row">
        <div class="span12">
          <div class="hero-unit">
            <h1>Lorem ipsum headline</h1>
            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="span4">
          <h2>New users</h2>
          <p><a class="btn" href="register.php">Click here to register</a></p>
        </div>
        <div class="span4 offset2">
          <h2>Returning users</h2>
          <form method="post" action="login.php" class="form-horizontal" id="loginForm" name="loginForm">
            <fieldset>
              <div class="control-group">
                <label class="control-label" for="loginEmail">Email</label>
                <div class="controls">
                  <input type="text" name="loginEmail" id="loginEmail" placeholder="Email">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="loginPassword">Password</label>
                <div class="controls">
                  <input type="password" name="loginPassword" id="loginPassword" placeholder="Password">
                </div>
              </div>
              <div class="control-group">
                <div class="controls">
                  <button type="submit" class="btn">Sign in</button>
                </div>
              </div>
            </fieldset>
          </form>
        </div>
      </div>
<?php
} else {
?>
<!-- ELSE IF LOGGED IN -->

      <div class="page-header">
        <h1>Home</h1>
      </div>
      <div class="row">
        <div class="span12">
          <div class="well">
            <p class="lead">Welcome, Dr. Xxxx Yyyyyyy.</p>
            <p>You have completed 0 of 100 encounters.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="span2 offset5">
          <a class="btn btn-large btn-block btn-primary">Start field test</a>
        </div>
      </div>
      <div class="row disclaimer">
        <div class="span12">
          <h2 class="h4">Licensing information/disclaimer</h2>
          <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>
        </div>
      </div>
<?php
}
?>
<!-- END IF -->

    </div>
    <?php require('inc/footer.php'); ?>
  </div>

<?php require('inc/script.php'); ?>
</body>
</html>