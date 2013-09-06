<?php require ('inc/head.php'); ?>

<title>SNOMED CT GP/FP RefSet Field Test - Review encounter</title>
</head>
<body>
    
<?php

if ($_SESSION["logged"]) {
    if ($_GET["enc"]) {
        $log -> user("and the encounter from enc page is - '$_GET[enc]'");
        $_SESSION["encounter_id"] = $_GET["enc"];
    }
    if ($_POST["enc"]) {

        $_SESSION["encounter_id"] = $_POST["enc"];
        $log -> user("and the encounter from enc page is - '$_POST[enc]'");
        $_SESSION["return_to"] = "encounters.php";
        $encRows = mysql_query("SELECT * FROM Encounters WHERE encounter_id = '$_POST[enc]'") or die(mysql_error());
        $enc = mysql_fetch_array($encRows);
        $endUserId = $enc['user_encounter_id'];

    } else {
        $userEncId = intval($_SESSION["completed_encs"]);

        if ($_POST["edit_reason"]) {
            $endUserId = $userEncId;
        } else {
            $endUserId = $userEncId+1;
        }
       
        if ($_SESSION["option"] == 3) {
            $log -> user("Reviewing in option 3, dropdown is - '$_POST[conceptsDropdown]' - alt field is - '$_POST[conceptFreeText]'");
            if ($_POST["conceptsDropdown"] || $_POST["conceptFreeText"])// all mandatory fields posted
            {
                // debug messages
                $log -> user("debugflag - Refset Only encounter_id var after entering review-enc is - '$_SESSION[encounter_id]'");

                if ($_POST["edit_reason"]) {
                    $log -> user("Come from the edit page");
                    $log -> user("refset type before inserting is - '$_POST[refType]'");

                    $sql = sprintf("UPDATE Encounter_Reasons SET sct_id = '$_POST[conceptsDropdown]', sct_scale = '$_POST[conceptRepresentation]', 
                        sct_alt = '%s' WHERE reason_id = '$_POST[edit_reason]'", mysql_real_escape_string($_POST[conceptFreeText]));

                } else {
    
                    $sql = sprintf("INSERT INTO Encounter_Reasons (encounter_id, refset_id, sct_id, sct_scale, sct_alt) 
                        VALUES ('$_SESSION[encounter_id]', 1, '$_POST[conceptsDropdown]', '$_POST[conceptRepresentation]', '%s')", 
                        mysql_real_escape_string($_POST["conceptFreeText"]));
                }
                $log -> user("review encounter update incoming");
                $log -> user($sql);
                mysql_query($sql) or die(mysql_error());

                $message = '<div class="alert alert-success">' . ($_POST["refType"] == 0 ? "Reason For Encounter" : "Health Issue") . ' successfully recorded. Please do not press back, or refresh the page, as this will re-submit the ' . ($_POST["refType"] == 0 ? "Reason For Encounter" : "Health Issue") . '</div>';
            } else {
                if ($_GET["cancel"] != '1') {
                    $message = '<div class="alert alert-error" id="errorMsg" name="errorMsg">There was an error - ' . ($_POST["refType"] == 0 ? "RFE" : "Health Issue") . ' was not recorded.</div>';
                }
            }

        } else {
            $icpcfield = ($_SESSION["option"] == 1 ? $_POST["icpc2"] : $_POST["icpcDropdown"]);
            $icpcAltfield = ($_SESSION["option"] == 1 ? $_POST["icpcDropdown"] : "");

            if (($_POST["conceptsDropdown"] || $_POST["conceptFreeText"]) && (($icpcfield != "" || $icpcAltfield != "")))// all mandatory fields posted
            {
                // debug messages
                $log -> user("debugflag - encounter_id var after entering review-enc is - '$_SESSION[encounter_id]'");
                $log -> user("debugflag - add_mode var after newly set is - '$_SESSION[add_mode]'");

                if ($_POST["edit_reason"]) {
                    $log -> user("Come from the edit page");
                    $sql = sprintf("UPDATE Encounter_Reasons SET sct_id = '$_POST[conceptsDropdown]', sct_scale = '$_POST[conceptRepresentation]', 
                        sct_alt = '%s', icpc_id = '$icpcfield', icpc_scale = '$_POST[icpc2appropriate]', icpc_alt_id = '$icpcAltfield' 
                        WHERE reason_id = '$_POST[edit_reason]'", mysql_real_escape_string($_POST[conceptFreeText]));

                } else {
                        
                    $log -> user("session enc id for adding HI is now - '$_SESSION[encounter_id]' - and the post enc id is - '$_POST[encid]'");                   
                    
                    $sql = sprintf("INSERT INTO Encounter_Reasons (encounter_id, refset_id, sct_id, sct_scale, sct_alt, icpc_id, icpc_scale, icpc_alt_id) 
                        VALUES ('$_SESSION[encounter_id]', 1, '$_POST[conceptsDropdown]', '$_POST[conceptRepresentation]', '%s', '$icpcfield',
                        '$_POST[icpc2appropriate]','$icpcAltfield')", mysql_real_escape_string($_POST["conceptFreeText"]));
                                        }
                $log -> user("review encounter update incoming");
                $log -> user($sql);
                mysql_query($sql) or die(mysql_error());

                $message = '<div class="alert alert-success">' . ($_POST["refType"] == 0 ? "Reason For Encounter" : "Health Issue") . ' successfully recorded. Please do not press back, or refresh the page, as this will re-submit the ' . ($_POST["refType"] == 0 ? "Reason For Encounter" : "Health Issue") . '</div>';
            } else {
                if ($_GET["cancel"] != '1') {
                    $message = '<div class="alert alert-error" id="errorMsg" name="errorMsg">There was an error - ' . ($_POST["refType"] == 0 ? "RFE" : "Health Issue") . ' was not recorded.</div>';
                }
            }
        }
    }
}
?>
  <div class="container">
    <?php
    require ('inc/header.php');
 ?>
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
          <h2>Encounter #<?= $endUserId; ?></h2>
          <?php
          if($user["field_test_complete"] == 0){
            ?>
            <ul class="inline pull-right">
              <li><a href="add-rfe.php?enc=<?= $_SESSION['encounter_id']; ?>" class="btn">Add Reason For Encounter</a></li>
              <li><a href="add-hi.php?enc=<?= $_SESSION['encounter_id']; ?>" class="btn">Add Health Issue</a></li>
            </ul>
            <?php
            }
          ?>
          <div class="accordion clearboth">
            <?php

            for($x = 0; $x <= 1; $x++){ // loop through once for RFEs and once for HIs
              $rows = mysql_query("SELECT * FROM Encounter_Reasons WHERE encounter_id='$_SESSION[encounter_id]'") or die(mysql_error());
         	  $date = date_create($rows['date_created']);
              
              while($row = mysql_fetch_array($rows)){
                if($row['refset_id'] == $x){
                  $sql = mysql_query("SELECT * FROM SCT_Concepts WHERE concept_id='$row[sct_id]'") or die(mysql_error());
                  $conceptArr = mysql_fetch_array($sql);
                  $conceptId = $conceptArr['concept_id'];
                  $concept = $conceptArr['label'];

                  $sql = mysql_query("SELECT * FROM ICPC_Codes WHERE id='$row[icpc_id]'") or die(mysql_error());
                  $icpcArr = mysql_fetch_array($sql);
                  $icpcId = $icpcArr['id'];
                  $icpc = $icpcArr['title'];
                  $sql = mysql_query("SELECT * FROM ICPC_Codes WHERE id='$row[icpc_alt_id]'") or die(mysql_error());
                  $icpcArr = mysql_fetch_array($sql);
                  $icpcAltLabel = $icpcArr['title'];

                  if ($_SESSION["option"] == 2) {
                      $rowLabel = $icpc;
                  } else {
                      if ($conceptArr['label'] == '') {
                          $rowLabel = $row['sct_alt'];
                      } else {
                          $rowLabel = $conceptArr['label'];
                      }
                  }

                  ?>
                  <div class="accordion-group">
                    <div class="accordion-heading">
                      <a class="accordion-toggle" data-toggle="collapse" href="#collapse<?= $row['reason_id']; ?>">
                        <?= ($row['refset_id'] == 0 ? "Reason For Encounter" : "Health Issue") . ' - ' . $rowLabel; ?>
                      </a>
                    </div>
                    <div class="accordion-body collapse" id="collapse<?= $row['reason_id']; ?>">
                      <div class="accordion-inner">
       
    <?php 
            //check for SCT first option
            switch ($_SESSION["option"]) {
              case 1:
	?>

                        <dl>
                          <dt>SNOMED CT Concept</dt>
                          <dd><?= $conceptId; ?> - <?= $concept; ?></dd>
                          <dt>How well does this SNOMED CT concept adequately represent the <?= ($row['refset_id'] == 0 ? "Reason For Encounter" : "Health Issue"); ?>? <br>(1 = Very well, 5 = Poorly)</dt>
                          <dd><?= $row['sct_scale']; ?></dd>
                          <dt>Alternative description of clinical term</dt>
                          <dd><?= ($row['sct_alt'] == '' ? '<em>None given</em>' : $row['sct_alt']); ?></dd>
                          
                          <dt>Mapped ICPC-2 code</dt>
                          <dd><?php
                            if (strpos($icpcId, 'UNMCH') === false) {
                          ?>
                              <?= $icpcId; ?>  - <?= $icpc; ?>
                          <?php } else { ?>    
                              <?= $icpc; ?>
                          <?php } ?>
                          </dd>
                          <dt>Is this ICPC-2 code an appropriate match for the <?= ($row['refset_id'] == 0 ? "Reason For Encounter" : "Health Issue"); ?>? <br>(1 = Very, 5 = Not at all)</dt>
                          <dd><?= $row['icpc_scale']; ?></dd>
                          <dt>Alternate ICPC-2 code</dt>
                          <dd><?= $row['icpc_alt_id']; ?> - <?= $icpcAltLabel; ?></dd>
                          <dt></dt>
                          <dd> </dd>
<!--                          <dt>Date created</dt>
                          <dd><?= date_format($date, 'l\, jS F Y'); ?></dd> -->
                        </dl>
                        <?php
                        if($user["field_test_complete"] == 0){
                          ?>
                          <form action="edit-item.php" method="post">
                            <fieldset>
                              <input type="hidden" id="item" name="item" value="<?= $row['reason_id']; ?>">
                              <input type="hidden" id="from" name="from" value="review-encounter.php">
                              <input type="hidden" id="encid" name="encid" value="<?= $_SESSION[encounter_id]; ?>">
                              <input type="hidden" id="itemType" name="itemType" value="<?= $row['refset_id']; ?>">
                              <?php
                            $sql = mysql_query("SELECT reason_id FROM Encounter_Reasons WHERE encounter_id='$_SESSION[encounter_id]' AND refset_id='$row[refset_id]'") or die(mysql_error());
                            $num = mysql_num_rows($sql);
                              ?>
                              <input type="hidden" id="numThis" name="numThis" value="<?= $num; ?>">
                              <ul class="inline pull-right">
                                <li><button type="submit" class="btn">Edit this <?= ($row['refset_id'] == 0 ? "Reason For Encounter" : "Health Issue"); ?></button></li>
                                <li><button class="btn btn-danger deleteItemBtn" id="delitem-<?= $row['reason_id']; ?>">Delete this <?= ($row['refset_id'] == 0 ? "Reason For Encounter" : "Health Issue"); ?></button></li>
                              </ul>
                            </fieldset>
                          </form>
                          <?php
                        }

                        // ICPC first option

                        break;
                        case 2:
            ?>
                        <dl>
                          <dt>ICPC-2 code</dt>
                          <dd><?= $icpcId; ?> - <?= $icpc; ?></dd>

                          <dt>SNOMED CT Concept</dt>
                          <dd><?= $conceptId; ?> - <?= $concept; ?></dd>
                          <dt>How well does this SNOMED CT concept adequately represent the <?= ($row['refset_id'] == 0 ? "Reason For Encounter" : "Health Issue"); ?>? <br>(1 = Very well, 5 = Poorly)</dt>
                          <dd><?= $row['sct_scale']; ?></dd>
                          <dt>Alternative description of clinical term</dt>
                          <dd><?= ($row['sct_alt'] == '' ? '<em>None given</em>' : $row['sct_alt']); ?></dd>
                          <dt></dt>
                          <dd> </dd>
<!--                          <dt>Date created</dt>
                          <dd><?= date_format($date, 'l\, jS F Y'); ?></dd>
-->
                          
                          
                        </dl>
                        <?php
                        if($user["field_test_complete"] == 0){
                          ?>
                          <form action="edit-item.php" method="post">
                            <fieldset>
                              <input type="hidden" id="item" name="item" value="<?= $row['reason_id']; ?>">
                              <input type="hidden" id="from" name="from" value="review-encounter.php">
                              <input type="hidden" id="itemType" name="itemType" value="<?= $row['refset_id']; ?>">
                              <?php
                            $sql = mysql_query("SELECT reason_id FROM Encounter_Reasons WHERE encounter_id='$_SESSION[encounter_id]' AND refset_id='$row[refset_id]'") or die(mysql_error());
                            $num = mysql_num_rows($sql);
                              ?>
                              <input type="hidden" id="numThis" name="numThis" value="<?= $num; ?>">
                              <ul class="inline pull-right">
                                <li><button type="submit" class="btn">Edit this <?= ($row['refset_id'] == 0 ? "Reason For Encounter" : "Health Issue"); ?></button></li>
                                <li><button class="btn btn-danger deleteItemBtn" id="delitem-<?= $row['reason_id']; ?>">Delete this <?= ($row['refset_id'] == 0 ? "Reason For Encounter" : "Health Issue"); ?></button></li>
                              </ul>
                            </fieldset>
                          </form>
                          <?php
                        }
                        break;
                        case 3:
            ?>
                        <dl>
                          <dt>SNOMED CT Concept</dt>
                          <dd><?= $conceptId; ?> - <?= $concept; ?></dd>
                          <dt>How well does this SNOMED CT concept adequately represent the <?= ($row['refset_id'] == 0 ? "Reason For Encounter" : "Health Issue"); ?>? <br>(1 = Very well, 5 = Poorly)</dt>
                          <dd><?= $row['sct_scale']; ?></dd>
                          <dt>Alternative description of clinical term</dt>
                          <dd><?= ($row['sct_alt'] == '' ? '<em>None given</em>' : $row['sct_alt']); ?></dd>
<!--                          <dt>Date created</dt>
                          <dd><?= date_format($date, 'l\, jS F Y'); ?></dd>
-->

                        </dl>
                        <?php
                        if($user["field_test_complete"] == 0){
                          ?>
                          <form action="edit-item.php" method="post">
                            <fieldset>
                              <input type="hidden" id="item" name="item" value="<?= $row['reason_id']; ?>">
                              <input type="hidden" id="from" name="from" value="review-encounter.php">
                              <input type="hidden" id="itemType" name="itemType" value="<?= $row['refset_id']; ?>">
                              <?php
                            $sql = mysql_query("SELECT reason_id FROM Encounter_Reasons WHERE encounter_id='$_SESSION[encounter_id]' AND refset_id='$row[refset_id]'") or die(mysql_error());
                            $num = mysql_num_rows($sql);
                              ?>
                              <input type="hidden" id="numThis" name="numThis" value="<?= $num; ?>">
                              <ul class="inline pull-right">
                                <li><button type="submit" class="btn">Edit this <?= ($row['refset_id'] == 0 ? "Reason For Encounter" : "Health Issue"); ?></button></li>
                                <li><button class="btn btn-danger deleteItemBtn" id="delitem-<?= $row['reason_id']; ?>">Delete this <?= ($row['refset_id'] == 0 ? "Reason For Encounter" : "Health Issue"); ?></button></li>
                              </ul>
                            </fieldset>
                          </form>
                          <?php
                        }
                        break;
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
              <li><button class="btn btn-danger deleteEncounterBtn" id="delenc-<?= $_SESSION['encounter_id']; ?>-<?=$endUserId; ?>">Delete this encounter</button></li>
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
    <?php
    require ('inc/footer.php');
 ?>
  </div>

<?php
require ('inc/script.php');
 ?>
</body>
</html>