<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    require('inc/head.php');

    if($_SESSION["logged"]){
      if(!$_POST["item"]){
        $message = '<div class="alert alert-error">Something went wrong.</div>';
      } else {
        $rows = mysql_query("SELECT * FROM Encounter_Reasons WHERE rfe_id = '$_POST[item]'") or die(mysql_error());
        $item = mysql_fetch_array($rows);
        
        $rows2 = mysql_query("SELECT * FROM SCT_Concepts WHERE concept_id='$item[sct_id]'") or die(mysql_error());
		$sct_details= mysql_fetch_array($rows2);
        
        $recordType = ($item["refset_id"] == 0 ? "Reason For Encounter" : "Health Issue");
        $_SESSION['rfe_id'] = $_POST['item'];
        $encRows = mysql_query("SELECT * FROM Encounters WHERE encounter_id = '$item[encounter_id]'") or die(mysql_error());
        $enc = mysql_fetch_array($encRows);
      }
    }
  ?>
  <title>SNOMED CT GP/FP RefSet Field Test - Edit <?= $recordType; ?></title>
</head>
<body>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">

      <div class="page-header">
        <h1>Edit <?= $recordType; ?></h1>
        <?php if ($recordType == "Reason For Encounter") 
        { ?>
        <p class='muted'>
        A Reason For Encounter is "an agreed statement of the reason(s) why a person enters the health care system, representing the demand for care by that person. The terms written down and later classified by the provider clarify the reason for encounter and consequently the patient’s demand for care without interpreting it in the form of a diagnosis. The reason for encounter should be recognised by the patient as an acceptable description of the demand for care” (Wonca Dictionary of General/Family Practice, 2003).
        </p>
        <?php } else { ?>
        <p class='muted'>
        A Health Issue is an “issue related to the health of a subject of care, as identified or stated by a specific health care party”. This is further defined in the notes as “according to this definition, a health issue can correspond to a health problem, a disease, an illness” (Health informatics – System of concepts to support continuity of care – Part 1: basic concepts (CEN 13940-1))
        </p>
		<?php } ?>        
      </div>
<?php
if(!$_SESSION["logged"]){
  include('inc/not-logged-in.php');
} else {
  if($message){
    echo $message;
  }
?>

      <form method="post" action="<?= $_POST['from'] ?>" id="editItem" name="editItem" data-validate="parsley">
        <fieldset>
          <div class="row">
            <div class="span8 offset2">
              <div class="well">
                <dl class="dl-horizontal">
                  <dt>Encounter ID:</dt>
                  <dd><?= $item["encounter_id"]; ?></dd>
                  <dt><?= $recordType; ?></dt>
                </dl>
              </div>
            </div>
          </div>

          <?php 
            switch ($_SESSION["option"]) {
              case 1:
          ?> 

          <div class="row">
            <div class="span8 offset2">
              <p>The SNOMED CT concept previously selected was <strong><?= $sct_details["label"]; ?></strong></p>
              <p>1. Search for (and select) a SNOMED CT concept that represents the <?= $recordType; ?> you wish to edit.</p>
              <div class="input-append">
                <input id="searchBox" name="searchBox" type="text" maxlength="50" value="<?= $sct_details["label"]; ?>">
                <button id="searchBtn" class="btn" type="button">Search</button>
              </div>
              <select class="input-xlarge" id="conceptsDropdown" name="conceptsDropdown" data-required="true" size="5" data-error-container="#conceptValidation">
                <option value="">Select SNOMED concept</option>
                <?php require('inc/concepts.php'); ?>
              </select>
              <button id="clearBtn" class="btn" type="button">Reset</button>
              <div id="conceptValidation"></div>
              <dl class="dl-horizontal synonyms">
                <dt>Synonyms:</dt>
                <dd></dd>
              </dl>
              <hr>
              <p>2. How well does this SNOMED CT concept adequately represent the <?= $recordType; ?> you wish to record?</p>
              <div class="likert">
                <label class="radio inline">
                  <span>1</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation1" value="1"<?= ($item['sct_scale'] == 1) ? ' checked="checked"' : '' ?> data-required="true"><span>Very well</span>
                </label>
                <label class="radio inline">
                  <span>2</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation2" value="2"<?= ($item['sct_scale'] == 2) ? ' checked="checked"' : '' ?>>
                </label>
                <label class="radio inline">
                  <span>3</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation3" value="3"<?= ($item['sct_scale'] == 3) ? ' checked="checked"' : '' ?>>
                </label>
                <label class="radio inline">
                  <span>4</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation4" value="4"<?= ($item['sct_scale'] == 4) ? ' checked="checked"' : '' ?>>
                </label>
                <label class="radio inline">
                  <span>5</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation5" value="5"<?= ($item['sct_scale'] == 5) ? ' checked="checked"' : '' ?>><span>Poorly</span>
                </label>
              </div>
              <hr>
              <p>3. If the SNOMED CT concept was not an accurate representation, or no appropriate SNOMED CT concept was found, please write in free text the clinical term you wished to record.</p>
              <input type="text" class="span8" id="conceptFreeText" name="conceptFreeText" maxlength="250" value="<?= $item['sct_alt']; ?>">
              <hr>
              <p>4. The associated ICPC-2 code is: <span class="uneditable-input span3"><?= $item['map_id']; ?></span></p>
              <input type="hidden" id="icpc2" name="icpc2" value="<?= $item['map_id']; ?>">
              <hr>
              <p>5. In your opinion, is this ICPC-2 code an appropriate match for the <?= $recordType; ?> you recorded?</p>
              <div class="likert">
                <label class="radio inline">
                  <span>1</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate1" value="1"<?= ($item['map_scale'] == 1) ? ' checked="checked"' : '' ?> data-required="true"><span>Very well</span>
                </label>
                <label class="radio inline">
                  <span>2</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate2" value="2"<?= ($item['map_scale'] == 2) ? ' checked="checked"' : '' ?>>
                </label>
                <label class="radio inline">
                  <span>3</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate3" value="3"<?= ($item['map_scale'] == 3) ? ' checked="checked"' : '' ?>>
                </label>
                <label class="radio inline">
                  <span>4</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate4" value="4"<?= ($item['map_scale'] == 4) ? ' checked="checked"' : '' ?>>
                </label>
                <label class="radio inline">
                  <span>5</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate5" value="5"<?= ($item['map_scale'] == 5) ? ' checked="checked"' : '' ?>><span>Not at all</span>
                </label>
              </div>
              <hr>
              <p>6. If the ICPC-2 code is not an appropriate match, please record your preferred ICPC-2 code:</p>
              <select id="icpc2choice" name="icpc2choice" class="span8">
                <option value="">Select ICPC-2 code</option>
                <option value="123">ICPC-2 code and label</option>
                <option value="456">ICPC-2 code and label</option>
                <option value="789">ICPC-2 code and label</option>
              </select>
<?php 
        break;
    case 2:
?>
            
          <!-- for the ICPC2 first option -->
          
<?php 
        break;
    case 3:
?>
            
          <!-- for the ICPC2 first option -->          
                    <div class="row">
            <div class="span8 offset2">
              <p>The SNOMED CT concept previously selected was <strong><?= $sct_details["label"]; ?></strong></p>
              <p>1. Search for (and select) a SNOMED CT concept that represents the <?= $recordType; ?> you wish to edit.</p>
              <div class="input-append">
                <input id="searchBox" name="searchBox" type="text" maxlength="50" value="<?= $sct_details["label"]; ?>">
                <button id="searchBtn" class="btn" type="button">Search</button>
              </div>
              <select class="input-xlarge" id="conceptsDropdown" name="conceptsDropdown" data-required="true" size="5" data-error-container="#conceptValidation">
                <option value="">Select SNOMED concept</option>
                <?php require('inc/concepts.php'); ?>
              </select>
              <button id="clearBtn" class="btn" type="button">Reset</button>
              <div id="conceptValidation"></div>
              <dl class="dl-horizontal synonyms">
                <dt>Synonyms:</dt>
                <dd></dd>
              </dl>
              <hr>
              <p>2. How well does this SNOMED CT concept adequately represent the <?= $recordType; ?> you wish to record?</p>
              <div class="likert">
                <label class="radio inline">
                  <span>1</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation1" value="1"<?= ($item['sct_scale'] == 1) ? ' checked="checked"' : '' ?> data-required="true"><span>Very well</span>
                </label>
                <label class="radio inline">
                  <span>2</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation2" value="2"<?= ($item['sct_scale'] == 2) ? ' checked="checked"' : '' ?>>
                </label>
                <label class="radio inline">
                  <span>3</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation3" value="3"<?= ($item['sct_scale'] == 3) ? ' checked="checked"' : '' ?>>
                </label>
                <label class="radio inline">
                  <span>4</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation4" value="4"<?= ($item['sct_scale'] == 4) ? ' checked="checked"' : '' ?>>
                </label>
                <label class="radio inline">
                  <span>5</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation5" value="5"<?= ($item['sct_scale'] == 5) ? ' checked="checked"' : '' ?>><span>Poorly</span>
                </label>
              </div>
              <hr>
              <p>3. If the SNOMED CT concept was not an accurate representation, or no appropriate SNOMED CT concept was found, please write in free text the clinical term you wished to record.</p>
              <input type="text" class="span8" id="conceptFreeText" name="conceptFreeText" maxlength="250" value="<?= $item['sct_alt']; ?>">

<?php 
        break;
        }
?>
            
          <!-- for the ICPC2 first option -->
              <div class="form-actions">
                <a id="cancelBtn" class="btn" href="<?= $_POST['from'] ?>">Cancel</a>
                <button type="submit" class="btn">Submit changes</button>
              </div>

            </div>
          </div>
        </fieldset>
      </form>
<?php
}
?>
    </div>
    <?php require('inc/footer.php'); ?>
  </div>

<?php require('inc/script.php'); ?>
</body>
</html>