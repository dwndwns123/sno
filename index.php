<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('inc/head.php'); ?>

  <title>SNOMED CT GP/FP RefSet Field Test - Home</title>
</head>
<body>

<?php
// check for login post
if($_POST["loginEmail"] && $_POST["loginPassword"]){
  $rows = mysql_query("SELECT * FROM Users WHERE email='$_POST[loginEmail]'") or die(mysql_error());

  if(mysql_num_rows($rows)==1){
    $user = mysql_fetch_array($rows);
    if($user["password"]==md5($_POST["loginPassword"])){
      if($user["verified"]){
        $tRows = mysql_query("SELECT * FROM Title WHERE title_id='$user[title_id]'") or die(mysql_error());
        $uTitle = mysql_fetch_array($tRows);
        $_SESSION["title"] = $uTitle["title"];
        $_SESSION["first_name"] = $user["first_name"];
        $_SESSION["last_name"] = $user["last_name"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["logged"] = true;
      } else {
        $message = '<div class="alert">You have not yet verified your email address.<br>Please retrieve the verification code from the email you should by now have received, and enter it <a href="verify.php">here</a>.</div>';
      }
    } else {
      $message = '<div class="alert alert-error">Password incorrect</div>';
    }
  } else {
    $message = '<div class="alert alert-error">Email address not recognised</div>';
  }
  // echo $message;
}
?>

  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">
<?php
if($message){
  echo $message;
}
if(!$_SESSION["logged"]){
?>
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
          <form method="post" action="index.php" class="form-horizontal" id="loginForm" name="loginForm" data-validate="parsley">
            <fieldset>
              <div class="control-group">
                <label class="control-label" for="loginEmail">Email</label>
                <div class="controls">
                  <input type="text" name="loginEmail" id="loginEmail" placeholder="Email" data-trigger="change" data-required="true" data-type="email">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="loginPassword">Password</label>
                <div class="controls">
                  <input type="password" name="loginPassword" id="loginPassword" placeholder="Password" data-trigger="change" data-required="true">
                </div>
              </div>
              <div class="control-group">
                <div class="controls">
                  <a href="forgot-password.php">Forgotten your password?</a>
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
      <div class="page-header">
        <h1>Home</h1>
      </div>
      <div class="row">
        <div class="span12">
          <div class="well">
            <p class="lead">Welcome, <?= ($_SESSION['title'] !== 'Other' ? $_SESSION['title'].' ' : ''); ?><?= $_SESSION['first_name'].' '.$_SESSION['last_name'] ?>.</p>
            <p>You have completed 0 of 100 encounters.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="span2 offset5">
          <a class="btn btn-large btn-block btn-primary" href="new-encounter.php">Add encounter</a>
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
    </div>
    <?php require('inc/footer.php'); ?>
  </div>

<?php require('inc/script.php'); ?>
</body>
</html>