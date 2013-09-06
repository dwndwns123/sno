<?php require ('inc/head.php');?>

  <title>SNOMED CT GP/FP RefSet Field Test - New user registration</title>
</head>
<body>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">

      <div class="page-header">
        <h1>Participant registration</h1>
      </div>
<?php
if($_SESSION["logged"]){
  include('inc/already-logged-in.php');
} else {
?>
      <div class="row">
        <div class="span8 offset2">
          <p><span class="req">*</span> Required</p>
          <form method="post" action="verify.php" class="form-horizontal" id="registrationForm" name="registrationForm" data-validate="parsley">
            <fieldset>
              <div class="control-group">
                <label class="control-label" for="regTitle"><span class="req">*</span> Title</label>
                <div class="controls">
                  <select class="input-xlarge" id="regTitle" name="regTitle" data-required="true">
                    <option value="">Please select</option>
                    <?php
                    $result = mysql_query("SELECT * FROM Title") or die(mysql_error());
                    while($row = mysql_fetch_array($result)){
                      ?>
                      <option value="<?=$row['title_id'];?>"><?=$row['title'];?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="regFirstname"><span class="req">*</span> First name</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" maxlength="30" id="regFirstname" name="regFirstname" placeholder="First name" data-trigger="change" data-required="true">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="regLastname"><span class="req">*</span> Last name</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" maxlength="30" id="regLastname" name="regLastname" placeholder="Last name" data-trigger="change" data-required="true">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="regEmail"><span class="req">*</span> Email address</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" maxlength="50" id="regEmail" name="regEmail" placeholder="Email address" data-trigger="change" data-required="true" data-type="email">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="regPassword"><span class="req">*</span> Password</label>
                <div class="controls">
                  <input type="password" class="input-xlarge" id="regPassword" name="regPassword" placeholder="Password" data-trigger="change" data-required="true" data-minlength="6"><span class="help-inline">Minimum 6 characters</span>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="regConfirmpassword"><span class="req">*</span> Confirm password</label>
                <div class="controls">
                  <input type="password" class="input-xlarge" id="regConfirmpassword" name="regConfirmpassword" placeholder="Confirm password" data-trigger="change" data-required="true" data-minlength="6" data-equalto="#regPassword">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="regCountry"><span class="req">*</span> Country</label>
                <div class="controls">
                  <select class="input-xlarge" id="regCountry" name="regCountry" data-required="true">
                    <option value="">Please select</option>
                    <?php
                    $result = mysql_query("SELECT * FROM Countries") or die(mysql_error());
                    while($row = mysql_fetch_array($result)){
                      ?>
                      <option value="<?=$row['country_id'];?>"><?=$row['name'];?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="regRole"><span class="req">*</span> Main role/occupation</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" maxlength="100" id="regRole" name="regRole" placeholder="Main role/occupation" data-required="true">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="regGender"><span class="req">*</span> Gender</label>
                <div class="controls">
                  <select class="input-xlarge" id="regGender" name="regGender" data-required="true">
                    <option value="">Please select</option>
                    <?php
                    $result = mysql_query("SELECT * FROM Gender") or die(mysql_error());
                    while($row = mysql_fetch_array($result)){
                      ?>
                      <option value="<?=$row['gender_id'];?>"><?=$row['gender'];?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
<!--              <div class="control-group">
                <label class="control-label" for="regAge"> Age</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" id="regAge" name="regAge" placeholder="Age" >
                </div>
              </div>
-->              <div class="control-group">
                <label class="control-label" for="regOption"><span class="req">*</span> Field Test Option</label>
                <div class="controls">
                  <select class="input-xlarge" id="regOption" name="regOption" data-required="true">
                    <option value="">Please select</option>
                    <?php
                    $result = mysql_query("SELECT * FROM TestApproach") or die(mysql_error());
                    while($row = mysql_fetch_array($result)){
                      ?>
                      <option value="<?=$row['option_id'];?>"><?=$row['option_label'];?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              
              <div class="control-group">
                <label class="control-label" for="regLicense"><span class="req">*</span> </label>
                <div class="controls">
                  <input type="checkbox" id="regLicense" name="regLicense" placeholder="license" data-trigger="change" data-required="true">
                  By creating an account, I agree to the terms of the license described below.</input>
                </div>
              </div>
  
              <div class="control-group">
                <div class="controls">
                  <input type="submit" class="btn" value="Register">
                </div>
              </div>
            </fieldset>
          </form>
      <div class="row disclaimer">
        <div class="span8">
          <h2 class="h4">Field Test Participant Agreement for the use of ICPC-2 and SNOMED CT for Field Testing</h2>
            <p>The field test participant accepts: 
                <ol>
                    <li>That the use of ICPC-2 and SNOMED CT shall be purely and strictly for the purposes of the field test of the International Family Medicine/General Practice SNOMED CT RefSet and map to ICPC-2.</li>
                    <li>That permission to use ICPC-2 and SNOMED CT for the purposes stated in clause 1, shall be granted free of charge.</li>
                    <li>That the use of ICPC-2 and SNOMED CT for the field testing will be valid until the end of December 2013.</li>
                    <li>That the copyright of ICPC-2 belongs to, and remains with, WONCA. That the copyright of SNOMED CT belongs to, and remains with, IHTSDO.</li>
                    <li>That no attempt is made to copy or reproduce ICPC-2 or SNOMED CT by any means or in any form without the prior written consent of the copyright holders as identified in clause 4.</li>
                    <li>That any work published as a result of the field testing and trials shall formally acknowledge WONCA and IHTSDO. These acknowledgements will be display the following statements: 
                    <ul><li>“ICPC-2 is Copyright © WONCA 2000”</li>
                    <li>“This material includes SNOMED Clinical Terms® (SNOMED CT®) which is used by permission of the International Health Terminology Standards Development Organisation (IHTSDO).  All rights reserved.  SNOMED CT® was originally created by The College of American Pathologists.  “SNOMED” and “SNOMED CT” are registered trademarks of the IHTSDO.”</li>
                    </ul>
                    </li>
                </ol>
                5th September, 2013
            </p>
		  </p>        
        </div>
      </div>
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