<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('inc/head.php'); ?>

  <title>SNOMED CT GP/FP RefSet Field Test - Profile</title>
</head>
<body>
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
    // this breaks and I don't know why
    // $encounters = mysql_num_rows(mysql_query("SELECT * FROM Encounters WHERE user_id='$user[user_id]'")) or die(mysql_error());
?>
      <div class="row">
        <div class="span8 offset2">
          <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd><?= ($user['title'] !== 'Other' ? $user['title'].' ' : ''); ?><?= $user['first_name'].' '.$user['last_name']; ?></dd>
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
            <dt>Encounters recorded</dt>
            <dd><?= $encounters; ?></dd>
          </dl>
          <ul class="inline">
            <li><a class="btn" href="edit=profile.php">Edit profile</a></li>
            <li><a class="btn" href="change-password.php">Change password</a></li>
          </ul>
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