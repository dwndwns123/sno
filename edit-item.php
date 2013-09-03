<?php require ('inc/head.php');


if ($_SESSION["logged"]) {
    if (!$_POST["item"]) {
        $message = '<div class="alert alert-error">Something went wrong.</div>';
    } else {
        $rows = mysql_query("SELECT * FROM Encounter_Reasons WHERE reason_id = '$_POST[item]'") or die(mysql_error());
        $item = mysql_fetch_array($rows);

        $rows2 = mysql_query("SELECT * FROM SCT_Concepts WHERE concept_id='$item[sct_id]'") or die(mysql_error());
        $sct_details = mysql_fetch_array($rows2);

        $rows2 = mysql_query("SELECT * FROM ICPC_Codes WHERE id='$item[icpc_id]'") or die(mysql_error());
        $icpc_details = mysql_fetch_array($rows2);

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
    <?php
    require ('inc/header.php');
 ?>
    <div class="main clearfix">

      <div class="page-header">
        <h1>Edit <?= $recordType; ?></h1>
        <?php if ($recordType == "Reason For Encounter") 
        { ?>
        <blockquote>
            A Reason For Encounter is "an agreed statement of the reason(s) why a person enters the health care system, representing the demand for care by that person. The terms written down and later classified by the provider clarify the reason for encounter and consequently the patient’s demand for care without interpreting it in the form of a diagnosis. The reason for encounter should be recognised by the patient as an acceptable description of the demand for care” 
            <small>(Wonca Dictionary of General/Family Practice, 2003).</small>
        </blockquote>
        <input type="hidden" id="refType" name="refType" value="0">
        <?php 
         } else { ?>
        <blockquote>
            A Health Issue is an “issue related to the health of a subject of care, as identified or stated by a specific health care party”. This is further defined in the notes as “according to this definition, a health issue can correspond to a health problem, a disease, an illness”<br />
            <small>(Health informatics – System of concepts to support continuity of care – Part 1: basic concepts (CEN 13940-1))</small>
        </blockquote>
        <input type="hidden" id="refType" name="refType" value="1">
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
            <input type="hidden" id="edit_reason" name="edit_reason" value="<?= $_POST[item]; ?>">
            <input type="hidden" id="encid" name="encid" value="<?= $_POST[encid]; ?>">
            <input type="hidden" id="option" name="option" value="<?= $_SESSION["option"] ?>">

          <?php 
            switch ($_SESSION["option"]) {
              case 1:
          ?> 
          <!-- for the SCT first option -->

          <div class="row">
            <div class="span8 offset2">
              <p>The SNOMED CT concept previously selected was <strong><?= $sct_details["concept_id"]; ?> - <?= $sct_details["label"]; ?></strong></p>
              <p>1. Search for (and select) a SNOMED CT concept that represents the <?= $recordType; ?> you wish to edit.</p>
              <div class="input-append">
                <input id="searchBox" name="searchBox" type="text" maxlength="50" value="<?= $sct_details["label"]; ?>">
                <button id="searchBtn" class="btn" type="button">Search</button>
              </div>
              <select class="input-xlarge" id="conceptsDropdown" name="conceptsDropdown" size="5" data-error-container="#conceptValidation">
                <option value="<?= $sct_details["concept_id"]; ?>" selected>Select SNOMED concept</option>
              </select>
              <button id="clearBtn" class="btn" type="button">Reset</button>
              <div id="conceptValidation" style="display: none;"><font color='red'><strong>No Matches Found</strong></font></div>
              <dl class="dl-horizontal synonyms">
                <dt>Synonyms:</dt>
                <dd></dd>
              </dl>
              <hr>
              <p>2. How well does this SNOMED CT concept adequately represent the <?= $recordType; ?> you wish to record?</p>
              <div class="likert">
                <label class="radio inline">
                  <span>1</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation1" value="1"<?= ($item['sct_scale'] == 1) ? ' checked="checked"' : '' ?>><span>Very well</span>
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
              <p>4. The associated ICPC-2 code is: <strong><span class="icpcCode"><?= $icpc_details['id']; ?> - <?= $icpc_details['title']; ?></span></strong></p>
              <input type="hidden" id="icpc2" name="icpc2" value="<?= $icpc_details['id']; ?>">
              <hr>
              <p>5. In your opinion, is this ICPC-2 code an appropriate match for the <?= $recordType; ?> you recorded?</p>
              <div class="likert">
                <label class="radio inline">
                  <span>1</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate1" value="1"<?= ($item['icpc_scale'] == 1) ? ' checked="checked"' : '' ?> ><span>Very well</span>
                </label>
                <label class="radio inline">
                  <span>2</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate2" value="2"<?= ($item['icpc_scale'] == 2) ? ' checked="checked"' : '' ?>>
                </label>
                <label class="radio inline">
                  <span>3</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate3" value="3"<?= ($item['icpc_scale'] == 3) ? ' checked="checked"' : '' ?>>
                </label>
                <label class="radio inline">
                  <span>4</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate4" value="4"<?= ($item['icpc_scale'] == 4) ? ' checked="checked"' : '' ?>>
                </label>
                <label class="radio inline">
                  <span>5</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate5" value="5"<?= ($item['icpc_scale'] == 5) ? ' checked="checked"' : '' ?>><span>Not at all</span>
                </label>
              </div>
              <hr>
              <p>6. If the ICPC-2 code is not an appropriate match, please record your preferred ICPC-2 code:</p>
              <div class="input-append">
                <input id="icpcSearchBox" name="searchBox" type="text" maxlength="50">
                <button id="icpcSearchBtn" class="btn" type="button">Search</button>
              </div>
              <select class="input-xlarge" id="icpcDropdown" name="icpcDropdown" size="8" data-error-container="#icpcValidation">
                <option value="">Select ICPC-2 code</option>
              </select>
              <div id="icpcValidation" style="display: none;"><font color='red'><strong>No Matches Found</strong></font></div>

<?php
                break;
              case 2:
            ?>
          <!-- for the ICPC2 first option -->
              
          <div class="row">
            <div class="span8 offset2">
              <p>The ICPC-2 code previously selected was <strong><?= $icpc_details['id']; ?> - <?= $icpc_details['title']; ?></strong></p>
              <p>1. Search and (select) the <strong>ICPC-2</strong> code that represents the <?= $recordType; ?> you wish to record.</p>
              <div class="input-append">
                   <input id="icpcSearchBox" name="icpc2Search" type="text" maxlength="50" value="<?= $icpc_details["title"]; ?>">
                   <button id="icpcSearchBtn2" class="btn" type="button">Search</button>
              </div>
              <select class="input-xlarge" id="icpcDropdown" name="icpcDropdown" size="8" data-error-container="#icpcValidation">
                <option value="<?= $icpc_details['id']; ?>" selected>Select ICPC-2 code</option>
              </select>
              <button id="icpcClearBtn2" class="btn" type="button">Reset</button>
              <div id="icpcValidation" style="display: none;"><font color='red'><strong>No Matches Found</strong></font></div>

              <!-- SCT mapped concepts -->
              
                  <hr>
                  <p>The SNOMED CT concept previously associated is <strong><?= $sct_details["concept_id"]; ?> - <?= $sct_details["label"]; ?></strong></p>
                  <div id="SCT-Code" style="display: none;">
                      <p id="dropdownLabel">2. Select an associated SNOMED CT concept &nbsp;&nbsp;&nbsp;
                      <select class="input-xlarge" id="conceptsDropdown" name="conceptsDropdown" size="5" data-error-container="#conceptValidation">
                            <option value="<?= $sct_details["concept_id"]; ?>" selected>Select SNOMED concept</option>
                      </select>
                      <div id="conceptValidation" style="display: none;"><font color='red'><strong>No Matches Found</strong></font></div>
                      </p>
    
                      <dl class="dl-horizontal synonyms">
                        <dt>Synonyms:</dt>
                        <dd></dd>
                      </dl>
                  </div>    
                  <hr>

                  <p>2. How well does this SNOMED CT concept adequately represent the <?= $recordType; ?> you wish to record?</p>
                  <div class="likert">
                    <label class="radio inline">
                      <span>1</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation1" value="1"<?= ($item['sct_scale'] == 1) ? ' checked="checked"' : '' ?>><span>Very well</span>
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
                  <div id="representationValidation"></div>

                  <hr>
                  <p>4. If the SNOMED CT concept was not an accurate representation, or no appropriate SNOMED CT concept was found, please write in free text the clinical term you wished to record.</p>
                  <input type="text" class="span8" id="conceptFreeText" name="conceptFreeText" maxlength="250" value="<?= $item['sct_alt']; ?>">
                  <hr>
                      
<?php
            break;
            case 3:
        ?>
            
          <!-- for the Refset Only option -->          
                    <div class="row">
            <div class="span8 offset2">
              <p>The SNOMED CT concept previously selected was <strong><?= $sct_details["label"]; ?></strong></p>
              <p>1. Search for (and select) a SNOMED CT concept that represents the <?= $recordType; ?> you wish to edit.</p>
              <div class="input-append">
                <input id="searchBox" name="searchBox" type="text" maxlength="50" value="<?= $sct_details["label"]; ?>">
                <button id="searchBtn" class="btn" type="button">Search</button>
              </div>
              <select class="input-xlarge" id="conceptsDropdown" name="conceptsDropdown" size="5" data-error-container="#conceptValidation">
                <option value="">Select SNOMED concept</option>
                <?php /* require ('inc/concepts.php'); */ ?>
              </select>
              <button id="clearBtn" class="btn" type="button">Reset</button>
              <div id="conceptValidation" style="display: none;"><font color='red'><strong>No Matches Found</strong></font></div>
              <dl class="dl-horizontal synonyms">
                <dt>Synonyms:</dt>
                <dd></dd>
              </dl>
              <hr>
              <p>2. How well does this SNOMED CT concept adequately represent the <?= $recordType; ?> you wish to record?</p>
              <div class="likert">
                <label class="radio inline">
                  <span>1</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation1" value="1"<?= ($item['sct_scale'] == 1) ? ' checked="checked"' : '' ?> ><span>Very well</span>
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
            
              <div class="form-actions">
              <div id="ActionButtons">
                <a id="cancelBtn" class="btn" href="<?= $_POST['from'] ?>?cancel=1">Cancel</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn">Submit changes</button>
              </div>
              </div>

            </div>
          </div>
        </fieldset>
      </form>
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