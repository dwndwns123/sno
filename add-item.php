<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    require('inc/head.php');

    if(!is_null($_GET["type"]) && !is_null($_GET["enc"])){ // came from the review page
      $_SESSION["add_mode"] = $_GET["type"];
      $recordType = ($_GET["type"] == 0 ? "Reason For Encounter" : "Health Issue");
      $editLabel = false;
      $_SESSION["encounter_id"] = $_GET["enc"];

      $sql = "INSERT INTO Encounter_Reasons (encounter_id, refset_id) VALUES ('$_GET[enc]','$_GET[type]')";
      mysql_query($sql) or die(mysql_error());
      $_SESSION["rfe_id"] = mysql_insert_id();

      $returnTo = "review-encounter.php";

    } else {
      if($_SESSION["logged"]){
        if(!$_SESSION["encounter_id"]){ // no encounter id, so create new encounter and new RFE
          $sql = "INSERT INTO Encounters (user_id) VALUES ('$_SESSION[user_id]')";
          mysql_query($sql) or die(mysql_error());
          $_SESSION["encounter_id"] = mysql_insert_id();

          $_SESSION["add_mode"] = 0;
          $recordType = "Reason For Encounter";
          $editLabel = true;

          $sql = "INSERT INTO Encounter_Reasons (encounter_id, refset_id) VALUES ('$_SESSION[encounter_id]','$_SESSION[add_mode]')";
          mysql_query($sql) or die(mysql_error());
          $_SESSION["rfe_id"] = mysql_insert_id();
        } else { // there is an encounter id

          if($_POST["conceptsDropdown"] && $_POST["conceptRepresentation"] && $_POST["icpc2"] && $_POST["icpc2appropriate"]){ // all mandatory fields posted
            $sql = sprintf("UPDATE Encounter_Reasons SET refset_id = '$_SESSION[add_mode]', sct_id = '$_POST[conceptsDropdown]', sct_scale = '$_POST[conceptRepresentation]', sct_alt = '%s', map_id = '$_POST[icpc2]', map_scale = '$_POST[icpc2appropriate]'".(!is_null($_POST["icpc2choice"]) ? ", map_alt_id = '$_POST[icpc2choice]'" : "")." WHERE rfe_id = '$_SESSION[rfe_id]'",
                           mysql_real_escape_string($_POST[conceptFreeText]));
            mysql_query($sql) or die(mysql_error());
            $message = '<div class="alert alert-success">'.($_SESSION["add_mode"] == 0 ? "RFE" : "Health Issue").' number '.$_SESSION["rfe_id"].' successfully recorded.</div>';

            if($_POST["label"]){
              $sql = sprintf("UPDATE Encounters SET label = '%s' WHERE encounter_id = '$_SESSION[encounter_id]'",
                             mysql_real_escape_string($_POST[label]));
              mysql_query($sql) or die(mysql_error());
              $_SESSION["label"] = $_POST["label"];
            }

            if($_POST["addAnother"] == "false"){
              $_SESSION["add_mode"] = 1;
            }

            $recordType = ($_SESSION["add_mode"] == 0 ? "RFE" : "Health Issue");
            $editLabel = false;

            $sql = "INSERT INTO Encounter_Reasons (encounter_id, refset_id) VALUES ('$_SESSION[encounter_id]','$_SESSION[add_mode]')";
            mysql_query($sql) or die(mysql_error());
            $_SESSION["rfe_id"] = mysql_insert_id();
          } else if($_POST["conceptsDropdown"] || $_POST["conceptRepresentation"] || $_POST["icpc2"] || $_POST["icpc2appropriate"]){
            $message = '<div class="alert alert-error">There was an error - RFE/Health Issue was not recorded.</div>';
          }
        }
      }
      $returnTo = "add-item.php";
    }
  ?>
  <title>SNOMED CT GP/FP RefSet Field Test - Add <?= $recordType; ?></title>
</head>
<body>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">

      <div class="page-header">
        <h1>Add <?= $recordType; ?></h1>
        <?php if ($recordType == "Reason For Encounter") 
        { ?>
        <p>REF text - Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
		<?php } else { ?>
        <p>HI text - Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
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

      <form method="post" action="<?= $returnTo; ?>" id="addItem" name="addItem" data-validate="parsley">
        <fieldset>
          <div class="row">
            <div class="span8 offset2">
              <div class="well">
                <dl class="dl-horizontal">
                  <dt>Encounter ID:</dt>
                  <dd><?= $_SESSION["encounter_id"]; ?></dd>
                </dl>
              </div>
            </div>
          </div>

          <?php if($_SESSION["option"] == 1){ 
          ?> 
            
          <!-- for the SNOMED CT first option -->
            
          <div class="row">
            <div class="span8 offset2">
              <p>1. Search for(and select) a <strong>SNOMED CT</strong> concept that represents the <?= $recordType; ?> you wish to record.</p>
              <div class="input-append">
                <input id="searchBox" name="searchBox" type="text" maxlength="50">
                <button id="searchBtn" class="btn" type="button">Search</button>
              </div>
<!--              
              <div class="itemsHolder clearboth clearfix" id="SCT-spinner">
                  <div class="spin"></div>
                  <p>Fetching items...</p>
              </div>
    -->          
              <select class="input-xlarge" id="conceptsDropdown" name="conceptsDropdown" size="5" data-required="true" data-error-container="#conceptValidation">
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
                  <span>1</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation1" value="1" data-required="true" data-error-container="#representationValidation"><span>Very</span>
                </label>
                <label class="radio inline">
                  <span>2</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation2" value="2">
                </label>
                <label class="radio inline">
                  <span>3</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation3" value="3">
                </label>
                <label class="radio inline">
                  <span>4</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation4" value="4">
                </label>
                <label class="radio inline">
                  <span>5</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation5" value="5"><span>Poorly</span>
                </label>
              </div>


              <div id="representationValidation"></div>
              <hr>
              <p>3. If the SNOMED CT concept was not an accurate representation, or no appropriate SNOMED CT concept was found, please write in free text the clinical term you wished to record.</p>
              <input type="text" class="span8" id="conceptFreeText" name="conceptFreeText" maxlength="250">
              <hr>
          <div id="ICPC-Code" style="display: none;">
              <p>4. The associated ICPC-2 code is: <span class="uneditable-input span3">123456</span></p>
              <input type="hidden" id="icpc2" name="icpc2" value="123456">
              <hr>
              <p>5. In your opinion, is this ICPC-2 code an appropriate match for the <?= $recordType; ?> you recorded?</p>
              <div class="likert">
                <label class="radio inline">
                  <span>1</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate1" value="1" data-required="true" data-error-container="#appropriateValidation"><span>Very</span>
                </label>
                <label class="radio inline">
                  <span>2</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate2" value="2">
                </label>
                <label class="radio inline">
                  <span>3</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate3" value="3">
                </label>
                <label class="radio inline">
                  <span>4</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate4" value="4">
                </label>
                <label class="radio inline">
                  <span>5</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate5" value="5"><span>Not at all</span>
                </label>
              </div>
              <div id="appropriateValidation"></div>
              <hr>
              <p>6. If the ICPC-2 code is not an appropriate match, please record your preferred ICPC-2 code:</p>
              <select id="icpc2choice" name="icpc2choice" class="span8">
<!-- example codes until they are available -->
                <option value="">Select ICPC-2 code</option>
                <option value="123">ICPC-2 code and label</option>
                <option value="456">ICPC-2 code and label</option>
                <option value="789">ICPC-2 code and label</option>
              </select>
          </div>
             
              
              
<?php } else {  ?>
            
          <!-- for the ICPC2 first option -->
              
              
          <div class="row">
            <div class="span8 offset2">
              <p>1. Search and (select) the <strong>ICPC-2</strong> code that represents the <?= $recordType; ?> you wish to record.</p>

              <div class="input-append">
                <input id="icpcSearchBox" name="icpcSearchBox" type="text" maxlength="50">
                <button id="icpcSearchBtn" class="btn" type="button">Search</button>
              </div>
              <select class="input-xlarge" id="icpcDropdown" name="icpcDropdown" size="5" data-required="true" data-error-container="#icpcValidation">
                <option value="">Select ICPC-2 code</option>
                <option value="123">ICPC-2 code and label</option>
                <option value="456">ICPC-2 code and label</option>
                <option value="789">ICPC-2 code and label</option>
              </select>
              
              <button id="clearBtn" class="btn" type="button">Reset</button>
              
              <hr>
              <p>2. In your opinion, is this ICPC-2 code an appropriate match for the <?= $recordType; ?> you recorded?</p>
              <div class="likert">
                <label class="radio inline">
                  <span>1</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate1" value="1" data-required="true" data-error-container="#appropriateValidation"><span>Very</span>
                </label>
                <label class="radio inline">
                  <span>2</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate2" value="2">
                </label>
                <label class="radio inline">
                  <span>3</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate3" value="3">
                </label>
                <label class="radio inline">
                  <span>4</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate4" value="4">
                </label>
                <label class="radio inline">
                  <span>5</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate5" value="5"><span>Not at all</span>
                </label>
              </div>
 
                
<!-- SCT selection -->
 			  <hr>
 			  <p>	
 			  	             
              <p>4. The associated SNOMED CT concept: <span class="uneditable-input span3">example concept id & label</span></p>
              <p>5. How well does this SNOMED CT concept adequately represent the <?= $recordType; ?> you wish to record?</p>
              <div class="likert">
                <label class="radio inline">
                  <span>1</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation1" value="1" data-required="true" data-error-container="#representationValidation"><span>Very</span>
                </label>
                <label class="radio inline">
                  <span>2</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation2" value="2">
                </label>
                <label class="radio inline">
                  <span>3</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation3" value="3">
                </label>
                <label class="radio inline">
                  <span>4</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation4" value="4">
                </label>
                <label class="radio inline">
                  <span>5</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation5" value="5"><span>Poorly</span>
                </label>
              </div>
              <div id="representationValidation"></div>
              <hr>
              <p>6. If the SNOMED CT concept was not an accurate representation, please search for(and select) a SNOMED CT concept that represents the <?= $recordType; ?> you wish to record.</p>
              <div class="input-append">
                <input id="searchBox" name="searchBox" type="text" maxlength="50">
                <button id="searchBtn" class="btn" type="button">Search</button>
              </div>
              <select class="input-xlarge" id="conceptsDropdown" name="conceptsDropdown" size="5" data-required="true" data-error-container="#conceptValidation">
                <option value="">Select SNOMED concept</option>
                <?php require('inc/concepts.php'); ?>
              </select>
              <button id="clearBtn" class="btn" type="button">Reset</button>
              <div id="conceptValidation"></div>
              <dl class="dl-horizontal synonyms">
                <dt>Synonyms:</dt>
                <dd></dd>
              </dl>
<!--              <hr>

              <p>3. If the SNOMED CT concept was not an accurate representation, or no appropriate SNOMED CT concept was found, please write in free text the clinical term you wished to record.</p>
              <input type="text" class="span8" id="conceptFreeText" name="conceptFreeText" maxlength="250"> -->
<?php } ?>              
              
              
    
              
              
              
              <div class="form-actions">
                <?php
                if(!is_null($_GET["type"]) && !is_null($_GET["enc"])){
                  ?>
                  <button type="submit" class="btn">Add this <?= $recordType; ?></button>
                  <?php
                } else {
                  ?>
                  <input type="hidden" id="addAnother" name="addAnother" value="true">
                  <button type="submit" class="btn">Add another <?= $recordType; ?></button>
                  <?php
                  if($_SESSION["add_mode"] == 0){
                    ?>
                    <a id="nextBtn" class="btn" href="#">Reason For Encounters complete - add Health Issues</a>
                    <?php
                  } else {
                    ?>
                    <a id="finishedBtn" class="btn" href="#">Health Issues complete - review encounter</a>
                    <?php
                  }
                }
                ?>
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