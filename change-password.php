<?php
require ('inc/head.php');
require ('inc/conn.php');
?>

<title>SNOMED CT GP/FP RefSet Field Test - Change password</title>
</head>
<body>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">

      <div class="page-header">
        <h1>Change password</h1>
      </div>
<?php
if(!$_SESSION["logged"]){
  include('inc/not-logged-in.php');
} else {
  $rows = mysql_query("SELECT * FROM Users WHERE user_id='$_SESSION[user_id]'") or die(mysql_error());
  $user = mysql_fetch_array($rows);

  if($_POST["pwOldpw"] && $_POST["pwNewpw"] && $_POST["pwConfirmnewpw"]){
    if(md5($_POST["pwOldpw"]) == $user["password"]){
      if($_POST["pwNewpw"] == $_POST["pwConfirmnewpw"]){
        $pass = md5($_POST[pwNewpw]);
        $sql = mysql_query("UPDATE Users SET password = '$pass' WHERE user_id = $user[user_id]") or die(mysql_error());

        $message = '<div class="alert alert-success">Password successfully updated.</div>';
      } else {
        $message = '<div class="alert alert-error">Password and password confirmation did not match - no change has been made.</div>';
      }
    } else {
      $message = '<div class="alert alert-error">Old password is incorrect - no change has been made.</div>';
    }

    echo $message;
  }
?>
      <div class="row">
        <div class="span8 offset2">
          <form method="post" action="change-password.php" class="form-horizontal" id="changePassword" name="changePassword" data-validate="parsley">
            <fieldset>
              <div class="control-group">
                <label class="control-label" for="pwOldpw">Old password</label>
                <div class="controls">
                  <input type="password" class="input-xlarge" id="pwOldpw" name="pwOldpw" value="" placeholder="Password" data-trigger="change" data-required="true" data-minlength="6">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="pwNewpw">New password</label>
                <div class="controls">
                  <input type="password" class="input-xlarge" id="pwNewpw" name="pwNewpw" value="" placeholder="Password" data-trigger="change" data-required="true" data-minlength="6">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="pwConfirmnewpw">Confirm new password</label>
                <div class="controls">
                  <input type="password" class="input-xlarge" id="pwConfirmnewpw" name="pwConfirmnewpw" value="" placeholder="Confirm password" data-trigger="change" data-required="true" data-minlength="6" data-equalto="#pwNewpw">
                </div>
              </div>
              <div class="control-group">
                <div class="controls">
                  <input type="submit" class="btn" value="Save">
                  <a class="btn" href="profile.php">Cancel</a>
                </div>
              </div>
            </fieldset>
          </form>
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