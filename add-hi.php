<?php require ('inc/head.php');

$refset_id = 1;

if (!is_null($_GET["enc"])) {// came from the review page
    $log -> user("I am in here - the came from review page");
    $encounter_id = $_GET["enc"];
    $returnTo = "review-encounter.php";

} else {
    $log -> user("I am in the add-hi page - the first if else place");
    $log -> user("debugflag - encounter_id var is - '$_SESSION[encounter_id]'");

    if ($_SESSION["logged"]) {
        if ($_SESSION["option"] == 3) {// this is for refset verification only

            if ($_POST["conceptsDropdown"] || $_POST["conceptRepresentation"]) {

                if (!$_SESSION["encounter_id"]) {// no encounter id, so create new encounter and new Health Issue
                    $log -> user("I am in the add-hi page - no encounter id, so create new encounter and new Health Issue");

                    $sql = "INSERT INTO Encounters (user_id) VALUES ('$_SESSION[user_id]')";
                    mysql_query($sql) or die(mysql_error());
                    $_SESSION["encounter_id"] = mysql_insert_id();

                    $log -> user("debugFlag - session enc id is now - '$_SESSION[encounter_id]'");
                } 
                $log -> user("refset type before inserting is - '$_POST[refType]'");
                $tmpRefsetType = $refset_id;
                if ($_POST[refType] == 0){
                    $tmpRefsetType = 0;
                } 
                $sql = sprintf("INSERT INTO Encounter_Reasons (encounter_id, refset_id, sct_id, sct_scale, sct_alt) 
                                        VALUES ('$_SESSION[encounter_id]', '$tmpRefsetType', '$_POST[conceptsDropdown]', '$_POST[conceptRepresentation]', '%s')", mysql_real_escape_string($_POST["conceptFreeText"]));

                $log -> user($sql);

                mysql_query($sql) or die(mysql_error());
                $message = '<div class="alert alert-success">' . ($_POST["refType"] == 0 ? "Reason For Encounter" : "Health Issue") . ' successfully recorded. Please do not press back, or refresh the page, as this will re-submit the ' . ($_POST["refType"] == 0 ? "Reason For Encounter" : "Health Issue") . '</div>';

            } else {
                $message = '<div class="alert alert-error" id="errorMsg" name="errorMsg">There was an error - Please ensure the relevant fields are populated.</div>';
            } 
            
        } else {// this is for mapping verification

            // debug notices
            $log -> user("I am in here, ref adding - option 1 & 2 verification");
            $log -> user("debugFlag - session enc id is now - '$_SESSION[encounter_id]'");
            $log -> user("debugflag - concepts dropdown after newly set is - '$_POST[conceptsDropdown]'");
            $log -> user("debugflag - concepts alt text after newly set is - '$_POST[conceptFreeText]'");
            $log -> user("debugflag - icpc after newly set is - '$_POST[icpc2]'");
            $log -> user("debugflag - icpc alt text after newly set is - '$_POST[icpcDropdown]'");

            if (($_POST["conceptsDropdown"] || $_POST["conceptFreeText"]) && ($_POST["icpc2"] || $_POST["icpcDropdown"])) {// all mandatory fields posted

                if (!$_SESSION["encounter_id"]) {// no encounter id, so create new encounter and new Health Issue
                    $log -> user("I am in option 1&2 and the fields are populated - no encounter id, so create new encounter and new Health Issue");

                    $sql = "INSERT INTO Encounters (user_id) VALUES ('$_SESSION[user_id]')";
                    mysql_query($sql) or die(mysql_error());
                    $_SESSION["encounter_id"] = mysql_insert_id();

                    $log -> user("debugflag - encounter_id var after newly set (opt 1&2) is - '$_SESSION[encounter_id]'");
                    $log -> user("debugflag - recordType var after newly set is - ");

                }
                $icpcfield = ($_SESSION["option"] == 1 ? $_POST["icpc2"] : $_POST["icpcDropdown"] );
                $icpcAltfield = ($_SESSION["option"] == 1 ? $_POST["icpcDropdown"] : "" );
                $log -> user("icpcfield is '$icpcfield' and icpcAltfield is '$icpcAltfield'");
                
                $log -> user("refset type before inserting is - '$_POST[refType]'");
                $tmpRefsetType = $refset_id;
                if ($_POST[refType] == 0){
                    $tmpRefsetType = 0;
                } 
                
                $sql = sprintf("INSERT INTO Encounter_Reasons (encounter_id, refset_id, sct_id, sct_scale, sct_alt, icpc_id, icpc_scale, icpc_alt_id) 
                                        VALUES ('$_SESSION[encounter_id]', '$tmpRefsetType', '$_POST[conceptsDropdown]', '$_POST[conceptRepresentation]', '%s', '$icpcfield',
                                        '$_POST[icpc2appropriate]','$icpcAltfield')", mysql_real_escape_string($_POST["conceptFreeText"]));

                $log -> user($sql);
                mysql_query($sql) or die(mysql_error());

                $message = '<div class="alert alert-success">' . ($_POST["refType"] == 0 ? "Reason For Encounter" : "Health Issue") . ' successfully recorded. Please do not press back, or refresh the page, as this will re-submit the ' . ($_POST["refType"] == 0 ? "Reason For Encounter" : "Health Issue") . '</div>';
            
            } else {
                $prevPage = $_SERVER['HTTP_REFERER'];
                if ($prevPage != 'index.php') {
                    $message = '<div class="alert alert-error" id="errorMsg" name="errorMsg">There was an error - Health Issue/Health Issue was not recorded. Please ensure the relevant fields are populated.</div>';
                }
            }
        } //endif of checking the approach option
    }//endif of is logged in and page origin check

    $returnTo = "add-hi.php";
}
?>
  
 
<title>SNOMED CT GP/FP RefSet Field Test - Add Health Issue</title>
</head>
<body>
  <div class="container">
    <?php
    require ('inc/header.php');
 ?>
    <div class="main clearfix">
      <div class="page-header well">
        <h1>Add Health Issue</h1>
        <blockquote>
            A Health Issue is an “issue related to the health of a subject of care, as identified or stated by a specific health care party”. This is further defined in the notes as “according to this definition, a health issue can correspond to a health problem, a disease, an illness”<br />
            <small>(Health informatics – System of concepts to support continuity of care – Part 1: basic concepts (CEN 13940-1))</small>
        </blockquote>
        <p>
            <a id="homeBtn" class="btn" href="index.php">Return Home</a>
        </p>
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
        <input type="hidden" id="option" name="option" value="<?= $_SESSION["option"] ?>">
        <input type="hidden" id="refType" name="refType" value="1">
        <fieldset>

       <?php 
  			switch ($_SESSION["option"]) {
  			  case 1:
       ?> 
            
          <!-- for the SNOMED CT first option -->
            
          <div class="row">
            <div class="span8 offset2">
              <p>1. Search for (and select) a <strong>SNOMED CT</strong> concept that represents the Health Issue you wish to record.</p>
              <div class="input-append">
                <input id="searchBox" name="searchBox" type="text" maxlength="50">
                <button id="searchBtn" class="btn" type="button">Search</button>
              </div>
              <select class="input-xlarge" id="conceptsDropdown" name="conceptsDropdown" size="8" data-error-container="#conceptValidation" >
                <option value="">Select SNOMED concept</option>
                <?php /* require('inc/concepts.php'); */ ?> 
              </select>
              <button id="clearBtn" class="btn" type="button">Reset</button>
              <div id="conceptValidation" style="display: none;"><font color='red'><strong>No Matches Found</strong></font></div>
              <dl class="dl-horizontal selectedConceptDL">
                <dt>Selected SNOMED<br>Concept:</dt>
                <dd><strong><span class="selectedConcept"></span></strong></dd>
              </dl>
              <dl class="dl-horizontal synonyms">
                <dt>Synonyms:</dt>
                <dd></dd>
              </dl>
              <hr>
              <p>2. How well does this SNOMED CT concept adequately represent the Health Issue you wish to record?</p>
              <div id="representationValidation"></div>
              <div class="likert">
                <label class="radio inline">
                  <span>1</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation1" value="1" data-error-container="#representationValidation" data-required="true"><span>Very well</span>
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
              
          <!-- Display ICPC Codes after being matched (or not) to the chosen SCT code -->    
          <div id="ICPC-Code" style="display: none;">
              <p class="icpcListlabel">4. Select the appropriate ICPC-2 code:
              <select class="input-xlarge" id="icpcCodeDropdown" name="icpcCodeDropdown" size="4">
              </select></p>
              <dl class="dl-horizontal selectedICPCDL">
                <dt>Selected ICPC-2 code:</dt>
                <dd><ul><li><strong><span class="selectedICPC"></span></strong></li></ul></dd>
              </dl>
              <input type="hidden" id="icpc2" name="icpc2">
              <hr>
              <p>5. In your opinion, is this ICPC-2 code an appropriate match for the Health Issue you recorded?</p>
              <div id="appropriateValidation"></div>
              <div class="likert">
                <label class="radio inline">
                  <span>1</span><input type="radio" name="icpc2appropriate" id="icpc2appropriate1" value="1" data-error-container="#appropriateValidation" data-required="true"><span>Very well</span>
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
              <hr>
              <p>6. If the ICPC-2 code is not an appropriate match, please record your preferred ICPC-2 code or do a text search:</p>
              <div class="input-append">
                <input id="icpcSearchBox" name="searchBox" type="text" maxlength="50">
                <button id="icpcSearchBtn" class="btn" type="button">Search</button>
              </div>
              <select class="input-xlarge" id="icpcDropdown" name="icpcDropdown" size="8" data-error-container="#icpcValidation">
                <option value="">Select ICPC-2 code</option>
                <?php /* require('inc/icpccodes.php'); */ ?> 
              </select>
              <div id="icpcValidation" style="display: none;"><font color='red'><strong>No Matches Found</strong></font></div>
              <div id="icpcSelectedDiv" style="display: none;">7. <strong><span class="icpcSelected"></span></strong> has been selected as the preferred code.</div>
<!--              <button id="icpcClearBtn" class="btn" type="button" style="a">Reset</button> -->
          </div>
             
              
              
<?php
                break;
              case 2:
            ?>
            
          <!-- for the ICPC2 first option -->
              
          <div class="row">
            <div class="span8 offset2">
              <p>1. Search and (select) the <strong>ICPC-2</strong> code that represents the Health Issue you wish to record,  or do a text search:</p>
              <div class="input-append">
                   <input id="icpcSearchBox2" name="icpc2Search" type="text" maxlength="50">
                   <button id="icpcSearchBtn2" class="btn" type="button">Search</button>
              </div>
              <select class="input-xlarge" id="icpcDropdown" name="icpcDropdown" size="8" data-error-container="#icpcValidation">
              <option value="">Select ICPC-2 code</option>
              </select>
              <button id="icpcClearBtn2" class="btn" type="button">Reset</button>
              <div id="icpcValidation"></div>
              <dl class="dl-horizontal selectedICPCDL">
                <dt>Selected ICPC-2 code:</dt>
                <dd><ul><li><strong><span class="selectedICPC"></span></strong></li></ul></dd>
              </dl>

              <!-- SCT mapped concepts -->
              
              <div id="SCT-Code" style="display: none;">
     			  <hr>
                  <p id="dropdownLabel">2. Select an associated SNOMED CT concept &nbsp;&nbsp;&nbsp;
                  <select class="input-xlarge" id="conceptsDropdown" name="conceptsDropdown" size="5" data-error-container="#conceptValidation">
                        <option value="">Select SNOMED concept</option>
                  </select>
                  </p>
                  <div id="conceptValidation" style="display: none;"><font color='red'><strong>No Matches Found</strong></font></div>

                  <dl class="dl-horizontal selectedConceptDL">
                    <dt>Selected SNOMED<br>Concept:</dt>
                    <dd><ul><li><strong><span class="selectedConcept"></span></strong></li></ul></dd>
                  </dl>
                  <dl class="dl-horizontal synonyms">
                    <dt>Synonyms:</dt>
                    <dd></dd>
                  </dl>
                  
                  <hr>

                  <p>3. How well does this SNOMED CT concept adequately represent the Health Issue you wish to record?</p>
                  <div id="representationValidation"></div>
                  <div class="likert">
                    <label class="radio inline">
                      <span>1</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation1" value="1" data-error-container="#representationValidation" data-required="true"><span>Very well</span>
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

                  <hr>
                  <p>4. If the SNOMED CT concept was not an accurate representation, or no appropriate SNOMED CT concept was found, please write in free text the clinical term you wished to record.</p>
                  <input type="text" class="span8" id="conceptFreeText" name="conceptFreeText" maxlength="250">
                  <hr>
             </div>
          
<?php
            break;
            case 3:
        ?>              

		<!-- Refset member verification only option -->
            
          <div class="row">
            <div class="span8 offset2">
              <p>1. Search for (and select) a <strong>SNOMED CT</strong> concept that represents the Health Issue you wish to record.</p>
              <div class="input-append">
                <input id="searchBox" name="searchBox" type="text" maxlength="50">
                <button id="searchBtn" class="btn" type="button">Search</button>
              </div>
   
              <select class="input-xlarge" id="conceptsDropdown" name="conceptsDropdown" size="8" data-error-container="#conceptValidation">
                <option value="">Select SNOMED concept</option>
              </select>
              <button id="clearBtn" class="btn" type="button">Reset</button>
              <div id="conceptValidation" style="display: none;"><font color='red'><strong>No Matches Found</strong></font></div>
              <dl class="dl-horizontal selectedConceptDL">
                <dt>Selected SNOMED<br>Concept:</dt>
                <dd><ul><li><strong><span class="selectedConcept"></span></strong></li></ul></dd>
              </dl>
              <dl class="dl-horizontal synonyms">
                <dt>Synonyms:</dt>
                <dd></dd>
              </dl>
              <hr>
              <p>2. How well does this SNOMED CT concept adequately represent the Health Issue you wish to record?</p>
              <div id="representationValidation"></div>
              <div class="likert">
                  <label class="radio inline">
                    <span>1</span><input type="radio" name="conceptRepresentation" id="conceptRepresentation1" value="1" data-error-container="#representationValidation" data-required="true"><span>Very well</span>
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
 
<?php
    break;
    }
?>              
              
                
              <div class="form-actions">
               <div id="ActionButtons" style="display: none;">
                <?php
                if(!is_null($_GET["enc"])){
                  ?>
                  <button type="submit" class="btn">Save this Health Issue</button>
                   &nbsp;&nbsp;
                  <?php
                } else {
                  ?>
                  <input type="hidden" id="addAnother" name="addAnother" value="true">
                  <button type="submit" class="btn">Save & add another Health Issue</button>
                  &nbsp;&nbsp;
                  <a id="finishedBtn" class="btn" href="#">Health Issues complete - review encounter</a>
                  &nbsp;&nbsp;
                <?php
                }
                ?>
              <a id="cancelBtn" class="btn" href="index.php">Cancel</a>
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