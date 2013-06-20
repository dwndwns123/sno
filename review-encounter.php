<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('inc/head.php'); ?>

  <title>SNOMED CT GP/FP RefSet Field Test - Review encounter</title>
</head>
<body>
<?php
if($_SESSION["logged"]){
  if($_POST["enc"]){
    $_SESSION["encounter_id"] = $_POST["enc"];
    $_SESSION["return_to"] = "encounters.php";
    $encRows = mysql_query("SELECT * FROM Encounters WHERE encounter_id = '$_POST[enc]'") or die(mysql_error());
    $enc = mysql_fetch_array($encRows);
    $_SESSION["label"] = $enc["label"];
  } else 
  // if($_POST["conceptsDropdown"] && $_POST["conceptRepresentation"] && $_POST["icpc2"] && $_POST["icpc2appropriate"])
  { // all mandatory fields posted
    $sql = sprintf("UPDATE Encounter_Reasons SET refset_id = '$_SESSION[add_mode]', sct_id = '$_POST[conceptsDropdown]', sct_scale = '$_POST[conceptRepresentation]', sct_alt = '%s', map_id = '$_POST[icpc2]', map_scale = '$_POST[icpc2appropriate]'".(!is_null($_POST["icpc2choice"]) ? ", map_alt_id = '$_POST[icpc2choice]'" : "")." WHERE rfe_id = '$_SESSION[rfe_id]'",
                   mysql_real_escape_string($_POST[conceptFreeText]));
    mysql_query($sql) or die(mysql_error());
    $message = '<div class="alert alert-success">'.($_SESSION["add_mode"] == 0 ? "RFE" : "Health Issue").' number '.$_SESSION["rfe_id"].' successfully recorded.</div>';
  }
}
?>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">
      <div class="page-header">
        <h1>Review encounter</h1>
      </div>
<?php
if(!$_SESSION["logged"]){
  include('inc/not-logged-in.php');
} else {
  if($message){
    echo $message;
  }

  $rows = mysql_query("SELECT * FROM Users WHERE user_id='$_SESSION[user_id]'") or die(mysql_error());
  $user = mysql_fetch_array($rows);
?>
      <div class="row">
        <div class="span8 offset2">
          <h2>Encounter <?= $_SESSION["encounter_id"].($_SESSION["label"] == '' ? '' : ''); ?></h2>
          <?php
          if($user["field_test_complete"] == 0){
            ?>
            <ul class="inline pull-right">
              <li><a href="add-item.php?type=0&amp;enc=<?= $_SESSION['encounter_id']; ?>" class="btn">Add Reason For Encounter</a></li>
              <li><a href="add-item.php?type=1&amp;enc=<?= $_SESSION['encounter_id']; ?>" class="btn">Add Health Issue</a></li>
            </ul>
            <?php
          }
          ?>
          <div class="accordion clearboth">
            <?php

            for($x = 0; $x <= 1; $x++){ // loop through once for RFEs and once for HIs
              $rows = mysql_query("SELECT * FROM Encounter_Reasons WHERE encounter_id='$_SESSION[encounter_id]'") or die(mysql_error());
              while($row = mysql_fetch_array($rows)){
                if($row['refset_id'] == $x){
                  $sql = mysql_query("SELECT * FROM SCT_Concepts WHERE concept_id='$row[sct_id]'") or die(mysql_error());
                  $conceptArr = mysql_fetch_array($sql);
                  $concept = $conceptArr['label'];
                  ?>
                  <div class="accordion-group">
                    <div class="accordion-heading">
                      <a class="accordion-toggle" data-toggle="collapse" href="#collapse<?= $row['rfe_id']; ?>">
                        <?= ($row['refset_id'] == 0 ? "Reason For Encounter" : "Health Issue").' - '.$concept; ?>
                      </a>
                    </div>
                    <div class="accordion-body collapse" id="collapse<?= $row['rfe_id']; ?>">
                      <div class="accordion-inner">
                        <dl>
                          <dt>SNOMED CT Concept</dt>
                          <dd><?= $concept; ?></dd>
                          <dt>How well does this SNOMED CT concept adequately represent the <?= ($row['refset_id'] == 0 ? "Reason For Encounter" : "Health Issue"); ?>? <br>(1 = Very well, 5 = Poorly)</dt>
                          <dd><?= $row['sct_scale']; ?></dd>
                          <dt>Alternative description of clinical term</dt>
                          <dd><?= ($row['sct_alt'] == '' ? '<em>None given</em>' : $row['sct_alt']); ?></dd>
                          
                        <?php
                        if($_SESSION["option"]<3){  //does not show ICPC-2 codes for users only reviewing SCT refset members
                          ?>  
                          <dt>ICPC-2 code</dt>
                          <dd><?= $row['map_id']; ?></dd>
                          <dt>Is this ICPC-2 code an appropriate match for the <?= ($row['refset_id'] == 0 ? "Reason For Encounter" : "Health Issue"); ?>? <br>(1 = Very, 5 = Not at all)</dt>
                          <dd><?= $row['map_scale']; ?></dd>
                          <dt>Alternate ICPC-2 code</dt>
                          <dd><?= $row['map_alt_id']; ?></dd>
                        <?php
                        }
                        ?>                        
                        
                        </dl>
                        <?php
                        if($user["field_test_complete"] == 0){
                          ?>
                          <form action="edit-item.php" method="post">
                            <fieldset>
                              <input type="hidden" id="item" name="item" value="<?= $row['rfe_id']; ?>">
                              <input type="hidden" id="from" name="from" value="review-encounter.php">
                              <input type="hidden" id="itemType" name="itemType" value="<?= $row['refset_id']; ?>">
                              <?php
                                $sql = mysql_query("SELECT rfe_id FROM Encounter_Reasons WHERE encounter_id='$_SESSION[encounter_id]' AND refset_id='$row[refset_id]'") or die(mysql_error());
                                $num = mysql_num_rows($sql);
                              ?>
                              <input type="hidden" id="numThis" name="numThis" value="<?= $num; ?>">
                              <ul class="inline pull-right">
                                <li><button type="submit" class="btn">Edit this <?= ($row['refset_id'] == 0 ? "Reason For Encounter" : "Health Issue"); ?></button></li>
                                <li><button class="btn btn-danger deleteItemBtn" id="delitem-<?= $row['rfe_id']; ?>">Delete this <?= ($row['refset_id'] == 0 ? "Reason For Encounter" : "Health Issue"); ?></button></li>
                              </ul>
                            </fieldset>
                          </form>
                          <?php
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                  <?php
                } // end of if
              } // end of while
            } // end of for
            ?>
          </div>

          <ul class="inline pull-right">
            <?php
            if($user["field_test_complete"] == 0){
              ?>
              <li><button class="btn btn-danger deleteEncounterBtn" id="delenc-<?= $_SESSION['encounter_id']; ?>">Delete this encounter</button></li>
              <?php
            }
            if($_SESSION["return_to"]){
              ?>
                <li><a href="<?= $_SESSION["return_to"]; ?>" class="btn">Review encounters</a></li>
              <?php
            } else if($user["field_test_complete"] == 0){
              ?>
                <li><a href="complete-encounter.php" class="btn btn-success">Complete encounter</a></li>
              <?php
              }
            ?>
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