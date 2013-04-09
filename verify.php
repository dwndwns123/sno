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

<?php
if($_SESSION["logged"]){
  //TODO: implement 'already logged in' component with link to homepage
  echo "Already logged in.";
} else {
  if($_POST["regTitle"] && $_POST["regFirstname"] && $_POST["regLastname"] && $_POST["regEmail"] && $_POST["regPassword"] && !is_null($_POST["regCountry"]) && $_POST["regRole"] && !is_null($_POST["regGender"]) && $_POST["regAge"]){// we arrived by posting from the registration form and all the fields are here

    $checkUser = mysql_query("SELECT * FROM Users WHERE email='$_POST[regEmail]'") or die(mysql_error());
    $user = mysql_fetch_array($checkUser);
    if(mysql_num_rows($checkUser)==1){
      echo "User already in DB";
    } else {
      $ver = md5($_POST["regEmail"]);
      $pass = md5($_POST["password"]);

      $sql="INSERT INTO Users (title,first_name,last_name,email,password,role,age,gender_id,country_id,verification) VALUES ('$_POST[regTitle]','$_POST[regFirstname]','$_POST[regLastname]','$_POST[regEmail]','$pass','$_POST[regRole]','$_POST[regAge]','$_POST[regGender]','$_POST[regCountry]','$ver')";
      mysql_query($sql) or die(mysql_error());

      //TODO: generate and send email here
      echo "User added";
    }
  } else if($_POST["regTitle"] && $_POST["regFirstname"] && $_POST["regLastname"] && $_POST["regEmail"] && $_POST["regPassword"] && !is_null($_POST["regCountry"]) && $_POST["regRole"] && !is_null($_POST["regGender"]) && $_POST["regAge"]) {// we arrived by posting from the registration form and all the fields are NOT here
    //TODO: This shouldn't happen due to client-side validation, but should handle it anyway
    echo "Not all required fields present in POST";
  } else {
    //do nothing - we arrived by another means, most likely the link in the verification email
  }
?>

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
              <label class="control-label" for="verEmail">Email address</label>
              <div class="controls">
                <input type="text" id="verEmail" name="verEmail" placeholder="Email address" value="<?= (empty($_POST["regEmail"]) ? '' : $_POST["regEmail"]); ?>" data-trigger="change" data-required="true" data-type="email">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="verCode">Verification code</label>
              <div class="controls">
                <input type="text" id="verCode" name="verCode" placeholder="Verification code" data-required="true">
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
<?php
}
?>
    </div>
    <?php require('inc/footer.php'); ?>
  </div>

<?php require('inc/script.php'); ?>
</body>
</html>