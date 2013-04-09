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
          <form method="post" action="login.php" class="form-horizontal" id="login-form" name="login-form">
            <fieldset>
              <div class="control-group">
                <label class="control-label" for="login-email">Email</label>
                <div class="controls">
                  <input type="text" name="login-email" id="login-email" placeholder="Email">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="login-password">Password</label>
                <div class="controls">
                  <input type="password" name="login-password" id="login-password" placeholder="Password">
                </div>
              </div>
              <div class="control-group">
                <div class="controls">
                  <label class="checkbox">
                    <input type="checkbox"> Remember me
                  </label>
                  <button type="submit" class="btn">Sign in</button>
                </div>
              </div>
            </fieldset>
          </form>
        </div>
      </div>

    </div>
    <?php require('inc/footer.php'); ?>
  </div>

<?php require('inc/script.php'); ?>
</body>
</html>