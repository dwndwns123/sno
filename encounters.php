<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('inc/head.php'); ?>

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
?>
      <div class="row">
        <div class="span8 offset2">

          <div class="accordion encounters-list">
          <?php
            $_SESSION ["encounter_id"] = null;
            $_SESSION ["add_mode"] = null;
            $_SESSION ["rfe_id"] = null;
            $_SESSION ["label"] = null;

            $encountersData = mysql_query("SELECT * FROM Encounters WHERE user_id='$_SESSION[user_id]' AND complete='1'") or die(mysql_error());
            $count = 0;
            while($row = mysql_fetch_array($encountersData)){
              ?>
              <div class="accordion-group">
                <div class="accordion-heading">
                  <a class="accordion-toggle" data-toggle="collapse" href="#collapse<?= $count; ?>">
                    Encounter #<?= $row['encounter_id']; ?> - <?= ($row['label'] == '' ? '<em>No label given</em>' : $row['label']) ?>
                  </a>
                </div>
                <div class="accordion-body collapse" id="collapse<?= $count; ?>">
                  <div class="accordion-inner">
                    <ul class="inline pull-right">
                      <li><button class="btn" id="">Edit label for this encounter</button></li>
                    </ul>
                    <div class="itemsHolder clearboth clearfix" id="enc-<?= $row['encounter_id']; ?>">
                      <div class="spin"></div>
                      <p>Fetching items...</p>
                    </div>
                    <ul class="inline pull-right">
                      <li><button class="btn" id="">Edit this encounter</button></li>
                    </ul>
                  </div>
                </div>
              </div>
              <?php
              $count++;
            }
          ?>
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