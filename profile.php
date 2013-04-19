<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('inc/head.php'); ?>

  <title>SNOMED CT GP/FP RefSet Field Test - Profile</title>
</head>
<body>
<?php
if($_SESSION["logged"]){
  if(!is_null($_POST["editTitle"]) && $_POST["editFirstname"] && $_POST["editLastname"] && !is_null($_POST["editCountry"]) && $_POST["editRole"] && !is_null($_POST["editGender"]) && $_POST["editAge"]){
    $sql = sprintf("UPDATE Users SET title_id = '$_POST[editTitle]', first_name = '%s', last_name = '%s', country_id = '$_POST[editCountry]', role = '%s', gender_id = '$_POST[editGender]', age = '$_POST[editAge]' WHERE user_id = $_SESSION[user_id]",
                   mysql_real_escape_string($_POST[editFirstname]),
                   mysql_real_escape_string($_POST[editLastname]),
                   mysql_real_escape_string($_POST[editRole]));
    
    mysql_query($sql) or die(mysql_error());

    $tRows = mysql_query("SELECT * FROM Title WHERE title_id='$_POST[editTitle]'") or die(mysql_error());
    $uTitle = mysql_fetch_array($tRows);
    $_SESSION["title"] = $uTitle["title"];
    $_SESSION["first_name"] = $_POST["editFirstname"];
    $_SESSION["last_name"] = $_POST["editLastname"];

    $message = '<div class="alert alert-success">Profile successfully updated.</div>';
  }
}
?>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">
      <div class="page-header">
        <h1>Profile</h1>
      </div>
<?php
if(!$_SESSION["logged"]){
  include('inc/not-logged-in.php');
} else {
  $rows = mysql_query("SELECT * FROM Users WHERE user_id='$_SESSION[user_id]'") or die(mysql_error());
  $user = mysql_fetch_array($rows);
  $userCountry = mysql_fetch_array(mysql_query("SELECT name FROM Countries WHERE country_id='$user[country_id]'")) or die(mysql_error());
  $userGender = mysql_fetch_array(mysql_query("SELECT gender FROM Gender WHERE gender_id='$user[gender_id]'")) or die(mysql_error());
  $encountersData = mysql_query("SELECT * FROM Encounters WHERE user_id='$user[user_id]' AND complete='1'") or die(mysql_error());
  $encounters = mysql_num_rows($encountersData);

  if($message){
    echo $message;
  }
?>
      <div class="row">
        <div class="span8 offset2">
          <form class="form-horizontal faux-form">
            <dl class="dl-horizontal">
              <dt>Name</dt>
              <dd><?= ($_SESSION['title'] !== 'Other' ? $_SESSION['title'].' ' : ''); ?><?= $user['first_name'].' '.$user['last_name']; ?></dd>
              <dt>Email</dt>
              <dd><?= $user['email']; ?></dd>
              <dt>Country</dt>
              <dd><?= $userCountry['name']; ?></dd>
              <dt>Main role/occupation</dt>
              <dd><?= $user['role']; ?></dd>
              <dt>Gender</dt>
              <dd><?= $userGender['gender']; ?></dd>
              <dt>Age</dt>
              <dd><?= $user['age']; ?></dd>
            </dl>

            <div class="control-group">
              <div class="controls">
                <a class="btn" href="edit-profile.php">Edit profile</a>
                <a class="btn" href="change-password.php">Change password</a>
              </div>
            </div>

            <dl class="dl-horizontal">
              <dt>Encounters completed</dt>
              <dd><?= $encounters; ?></dd>
            </dl>

            <div class="control-group">
              <div class="controls">
                <a class="btn" href="encounters.php">Review/edit encounters</a>
              </div>
            </div>

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