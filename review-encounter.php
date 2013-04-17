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
  if($_POST["conceptsDropdown"] && $_POST["conceptRepresentation"] && $_POST["icpc2"] && $_POST["icpc2appropriate"]){ // all mandatory fields posted
    $sql = "UPDATE Encounter_Reasons SET refset_id = '$_SESSION[add_mode]', sct_id = '$_POST[conceptsDropdown]', sct_scale = '$_POST[conceptRepresentation]', sct_alt = '$_POST[conceptFreeText]', map_id = '$_POST[icpc2]', map_scale = '$_POST[icpc2appropriate]'".(!is_null($_POST["icpc2choice"]) ? ", map_alt_id = '$_POST[icpc2choice]'" : "")." WHERE rfe_id = '$_SESSION[rfe_id]'";
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
?>
      <div class="row">
        <div class="span8 offset2">
          <h2>Encounter <?= $_SESSION["encounter_id"].($_SESSION["label"] == '' ? '' : ' - '.$_SESSION["label"]); ?></h2>
          <div class="accordion">
            <?php
            $rows = mysql_query("SELECT * FROM Encounter_Reasons WHERE encounter_id='$_SESSION[encounter_id]'") or die(mysql_error());
            $count = 0;
            while($row = mysql_fetch_array($rows)){
              $sql = mysql_query("SELECT * FROM SCT_Concepts WHERE ConceptId='$row[sct_id]'") or die(mysql_error());
              $conceptArr = mysql_fetch_array($sql);
              $concept = $conceptArr['PT'];
              ?>
              <div class="accordion-group">
                <div class="accordion-heading">
                  <a class="accordion-toggle" data-toggle="collapse" href="#collapse<?= $count; ?>">
                    <?= ($row['refset_id'] == 0 ? "RFE" : "Health Issue")." #".$row['rfe_id'].' - '.$concept; ?>
                  </a>
                </div>
                <div id="collapse<?= $count; ?>" class="accordion-body collapse">
                  <div class="accordion-inner">
                    <dl>
                      <dt>SNOMED CT Concept</dt>
                      <dd><?= $concept; ?></dd>
                      <dt>How well does this SNOMED CT concept adequately represent the <?= ($row['refset_id'] == 0 ? "RFE" : "Health Issue"); ?>? (1 = Very well, 5 = Poorly)</dt>
                      <dd><?= $row['sct_scale']; ?></dd>
                      <dt>Alternative description of clinical term</dt>
                      <dd><?= ($row['sct_alt'] == '' ? '<em>None given</em>' : $row['sct_alt']); ?></dd>
                      <dt>ICPC-2 code</dt>
                      <dd><?= $row['map_id']; ?></dd>
                      <dt>Is this ICPC-2 code an appropriate match for the <?= ($row['refset_id'] == 0 ? "RFE" : "Health Issue"); ?>? (1 = Very, 5 = Not at all)</dt>
                      <dd><?= $row['map_scale']; ?></dd>
                      <dt>Alternate ICPC-2 code</dt>
                      <dd><?= $row['map_alt_id']; ?></dd>
                    </dl>
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
                          <li><button type="submit" class="btn pull-right">Edit this <?= ($row['refset_id'] == 0 ? "RFE" : "Health Issue"); ?></button></li>
                          <li><button class="btn btn-danger pull-right deleteItemBtn" id="delitem-<?= $row['rfe_id']; ?>">Delete this <?= ($row['refset_id'] == 0 ? "RFE" : "Health Issue"); ?></button></li>
                        </ul>
                      </fieldset>
                    </form>
                  </div>
                </div>
              </div>
              <?php
              $count++;
              }
            ?>
          </div>

          <ul class="inline pull-right">
            <li><button class="btn btn-danger pull-right deleteEncounterBtn" id="delenc-<?= $_SESSION['encounter_id']; ?>">Delete this encounter</button></li>
            <li><a href="complete-encounter.php" class="btn btn-success pull-right">Complete encounter</a></li>
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