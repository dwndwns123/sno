<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('inc/head.php'); ?>

  <title>SNOMED CT GP/FP RefSet Field Test - New user registration</title>
</head>
<body>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main">

      <div class="page-header">
        <h1>Participant registration</h1>
      </div>

      <div class="row">
        <div class="span8 offset2">
          <p><span class="req">*</span> Required</p>
          <form method="post" action="register.php" class="form-horizontal" id="registration-form" name="registration-form" data-validate="parsley">
            <fieldset>
              <div class="control-group">
                <label class="control-label" for="reg-title"><span class="req">*</span> Title</label>
                <div class="controls">
                  <select class="input-xlarge" id="reg-title" name="reg-title" data-required="true">
                    <option value="">Please select</option>
                    <option value="Mr.">Mr.</option>
                    <option value="Mrs.">Mrs.</option>
                    <option value="Ms.">Ms.</option>
                    <option value="Miss">Miss</option>
                    <option value="Dr.">Dr.</option>
                    <option value="Prof.">Prof.</option>
                    <option value="Rev.">Rev.</option>
                    <option value="other">Other</option>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-firstname"><span class="req">*</span> First name</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" maxlength="30" id="reg-firstname" name="reg-firstname" placeholder="First name" data-trigger="change" data-required="true">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-lastname"><span class="req">*</span> Last name</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" maxlength="30" id="reg-lastname" name="reg-lastname" placeholder="Last name" data-trigger="change" data-required="true">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-email"><span class="req">*</span> Email address</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" maxlength="50" id="reg-email" name="reg-email" placeholder="Email address" data-trigger="change" data-required="true" data-type="email">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-password"><span class="req">*</span> Password</label>
                <div class="controls">
                  <input type="password" class="input-xlarge" id="reg-password" name="reg-password" placeholder="Password" data-trigger="change" data-required="true" data-minlength="6"><span class="help-inline">Minimum 6 characters</span>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-confirmpassword"><span class="req">*</span> Confirm password</label>
                <div class="controls">
                  <input type="password" class="input-xlarge" id="reg-confirmpassword" name="reg-confirmpassword" placeholder="Confirm password" data-trigger="change" data-required="true" data-minlength="6" data-equalto="#reg-password">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-country"><span class="req">*</span> Country</label>
                <div class="controls">
                  <select class="input-xlarge" id="reg-country" name="reg-country" data-required="true">
                    <option value="">Please select</option>
                    <?php require('inc/countries.php'); ?>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-role"><span class="req">*</span> Main role/occupation</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" maxlength="100" id="reg-role" name="reg-role" placeholder="Main role/occupation" data-required="true">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-gender"><span class="req">*</span> Gender</label>
                <div class="controls">
                  <select class="input-xlarge" id="reg-gender" name="reg-gender" data-required="true">
                    <option value="">Please select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-age"><span class="req">*</span> Age</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" maxlength="100" id="reg-age" name="reg-age" placeholder="Age" data-required="true">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-conditions">Conditions</label>
                <div class="controls">
                  <textarea class="input-xlarge" id="reg-conditions" name="reg-conditions"></textarea>
                </div>
              </div>
              <div class="control-group">
                <div class="controls">
                  <input type="submit" class="btn" value="Register">
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