<?php
require ('inc/head.php');
?>

<title>SNOMED CT GP/FP RefSet Field Test - Encounters</title>
</head>
<body>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">
      <div class="page-header">
        <h1>Encounters</h1>
      </div>
<?php
if(!$_SESSION["logged"]){
  include('inc/not-logged-in.php');
} else {
  $_SESSION["return_to"] = null;
  $_SESSION ["encounter_id"] = null;
  $_SESSION ["add_mode"] = null;

  $encountersData = mysql_query("SELECT * FROM Encounters WHERE user_id='$_SESSION[user_id]' AND complete='1' AND active='y'") or die(mysql_error());

  $rows = mysql_query("SELECT * FROM Users WHERE user_id='$_SESSION[user_id]'") or die(mysql_error());
  $user = mysql_fetch_array($rows);

  if($user["field_test_complete"]){
    ?>
    <div class="alert alert-warning">Encounters may not be edited since your field test results have been submitted.</div>
    <?php
  }
?>
      <div class="row">
        <div class="span8 offset2">

          <div class="accordion encounters-list">
          <?php
            if(mysql_num_rows($encountersData)){
              while($row = mysql_fetch_array($encountersData)){
              
              	$date = date_create($row['date_created']);
              	
                ?>
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" href="#collapse<?= $row['encounter_id']; ?>">
                      Encounter #<?= $row['encounter_id']; ?>  - created <?php echo date_format($date, '\o\n l\, jS F Y'); ?>
                    </a>
                  </div>
                  <div class="accordion-body collapse" id="collapse<?= $row['encounter_id']; ?>">
                    <div class="accordion-inner">
                      <div class="itemsHolder clearboth clearfix" id="enc-<?= $row['encounter_id']; ?>">
                        <div class="spin"></div>
                        <p>Fetching items...</p>
                      </div>
                      <form action="review-encounter.php" method="post">
                        <input type="hidden" id="enc" name="enc" value="<?= $row['encounter_id']; ?>">
                        <ul class="inline pull-right">
<?php  if($user["field_test_complete"]){
    ?>
                          <li><button type="submit" class="btn">Review this encounter</button></li>
<?php } else {
    ?>
                          <li><button type="submit" class="btn">Review/Edit this encounter</button></li>
<?php } ?>
                        </ul>
                      </form>
                    </div>
                  </div>
                </div>
                <?php
              }
            } else {
              ?>
              <p class="lead">You have not yet completed any encounters.</p>
              <a href="add-rfe.php?new=1" class="btn">Add Encounter</a>
              <?php
            }
          ?>
          </div>

          <ul class="unstyled bigButtons">
            <li><a class="btn btn-large btn-block btn-primary" href="index.php">Home</a></li>
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