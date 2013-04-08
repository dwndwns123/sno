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

      <div class="row">
        <div class="span8 offset2">
          <form method="post" action="register.php" class="form-horizontal" id="registration-form" name="registration-form">
            <fieldset>
              <div class="control-group">
                <label class="control-label" for="reg-title">Title</label>
                <div class="controls">
                  <select class="input-xlarge" id="reg-title" name="reg-title">
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
                <label class="control-label" for="reg-firstname">First name</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" maxlength="30" id="reg-firstname" name="reg-firstname" placeholder="First name">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-lastname">Last name</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" maxlength="30" id="reg-lastname" name="reg-lastname" placeholder="Last name">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-email">Email address</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" maxlength="50" id="reg-email" name="reg-email" placeholder="Email address">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-password">Password</label>
                <div class="controls">
                  <input type="password" class="input-xlarge" id="reg-password" name="reg-password" placeholder="Password">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-confirmpassword">Confirm password</label>
                <div class="controls">
                  <input type="password" class="input-xlarge" id="reg-confirmpassword" name="reg-confirmpassword" placeholder="Confirm password">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-country">Country</label>
                <div class="controls">
                  <select class="input-xlarge" id="reg-country" name="reg-country">
                    <option value="">Please select</option>
                    <?php require('inc/countries.php'); ?>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-role">Main role/occupation</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" maxlength="100" id="reg-role" name="reg-role" placeholder="Main role/occupation">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-gender">Gender</label>
                <div class="controls">
                  <select class="input-xlarge" id="reg-gender" name="reg-gender">
                    <option value="">Please select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-age">Age</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" maxlength="100" id="reg-age" name="reg-age" placeholder="Age">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-ftoption">Field test option</label>
                <div class="controls">
                  <select class="input-xlarge" id="reg-ftoption" name="reg-ftoption">
                    <option value="">Please select</option>
                    <option value="RefSet Only">RefSet Only</option>
                    <option value="RefSet + Map">RefSet + Map</option>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="reg-conditions">Conditions</label>
                <div class="controls">
                  <textarea class="input-xlarge" id="reg-conditions" name="reg-conditions"></textarea>
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