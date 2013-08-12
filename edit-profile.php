<?php require ('inc/head.php'); ?>

<title>SNOMED CT GP/FP RefSet Field Test - Edit profile</title>
</head>
<body>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">

      <div class="page-header">
        <h1>Edit profile</h1>
      </div>
<?php
if(!$_SESSION["logged"]){
  include('inc/not-logged-in.php');
} else {
  $rows = mysql_query("SELECT * FROM Users WHERE user_id='$_SESSION[user_id]'") or die(mysql_error());
  $user = mysql_fetch_array($rows);
?>
      <div class="row">
        <div class="span8 offset2">
          <form method="post" action="profile.php" class="form-horizontal" id="editProfile" name="editProfile" data-validate="parsley">
            <fieldset>
              <div class="control-group">
                <label class="control-label" for="editTitle">Title</label>
                <div class="controls">
                  <select class="input-xlarge" id="editTitle" name="editTitle" data-required="true">
                    <option value="">Please select</option>
                    <?php
                    $result = mysql_query("SELECT * FROM Title") or die(mysql_error());
                    while($row = mysql_fetch_array($result)){
                      ?>
                      <option value="<?=$row['title_id'];?>"<?= ($row['title_id'] == $user['title_id'] ? ' selected="selected"' : '') ?>><?=$row['title'];?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="editFirstname">First name</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" maxlength="30" id="editFirstname" name="editFirstname" value="<?= $user['first_name']; ?>" placeholder="First name" data-trigger="change" data-required="true">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="editLastname">Last name</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" maxlength="30" id="editLastname" name="editLastname" value="<?= $user['last_name']; ?>" placeholder="Last name" data-trigger="change" data-required="true">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="editEmail">Email address</label>
                <div class="controls">
                  <span class="input-xlarge uneditable-input"><?= $user['email']; ?></span>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="editCountry">Country</label>
                <div class="controls">
                  <select class="input-xlarge" id="editCountry" name="editCountry" data-required="true">
                    <option value="">Please select</option>
                    <?php
                    $result = mysql_query("SELECT * FROM Countries") or die(mysql_error());
                    while($row = mysql_fetch_array($result)){
                      ?>
                      <option value="<?=$row['country_id'];?>"<?= ($row['country_id'] == $user['country_id'] ? ' selected="selected"' : '') ?>><?=$row['name'];?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="editRole">Main role/occupation</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" maxlength="100" id="editRole" name="editRole" value="<?= $user['role']; ?>" placeholder="Main role/occupation" data-required="true">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="editGender">Gender</label>
                <div class="controls">
                  <select class="input-xlarge" id="editGender" name="editGender" data-required="true">
                    <option value="">Please select</option>
                    <?php
                    $result = mysql_query("SELECT * FROM Gender") or die(mysql_error());
                    while($row = mysql_fetch_array($result)){
                      ?>
                      <option value="<?=$row['gender_id'];?>"<?= ($row['gender_id'] == $user['gender_id'] ? ' selected="selected"' : '') ?>><?=$row['gender'];?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="editAge">Age</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" id="editAge" name="editAge" value="<?= $user['age']; ?>" placeholder="Age" data-required="true">
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