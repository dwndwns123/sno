<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('inc/head.php'); ?>

  <title>SNOMED CT GP/FP RefSet Field Test - Add RFE</title>
</head>
<body>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">

      <div class="page-header">
        <h1>Add RFE</h1>
      </div>
<?php
if(!$_SESSION["logged"]){
  include('inc/not-logged-in.php');
} else {
?>
      <div class="row">
        <div class="span8 offset2">
          <div class="well">
            <dl class="dl-horizontal">
              <dt>Encounter ID:</dt>
              <dd>(new)</dd>
              <dt>RFE number:</dt>
              <dd>(new)</dd>
            </dl>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="span8 offset2">
          <form method="post" action="rfe" id="rfe" name="rfe" data-validate="parsley">
            <fieldset>
              <p>1. Search for(and select) a SNOMED CT concept that represents the RFE you wish to record.</p>
              <div class="input-append">
                <input id="searchBox" name="searchBox" type="text" maxlength="50">
                <button id="searchBtn" class="btn" type="button">Search</button>
              </div>
              <select class="input-xlarge" id="conceptsDropdown" name="conceptsDropdown">
                <option value="">Select SNOMED concept</option>
                <?php require('inc/concepts.php'); ?>
              </select>
              <button id="clearBtn" class="btn" type="button">Reset</button>
              <dl class="dl-horizontal synonyms">
                <dt>Synonyms:</dt>
                <dd></dd>
              </dl>
              <hr>
              <p>2. How well does this SNOMED CT concept adequately represent the RFE you wish to record?</p>
              <div class="likert">
                <label class="radio inline">
                  <span>1</span><input type="radio" name="rfeConceptrepresentation" id="rfeConceptrepresentation1" value="1"><span>Very</span>
                </label>
                <label class="radio inline">
                  <span>2</span><input type="radio" name="rfeConceptrepresentation" id="rfeConceptrepresentation2" value="2">
                </label>
                <label class="radio inline">
                  <span>3</span><input type="radio" name="rfeConceptrepresentation" id="rfeConceptrepresentation3" value="3">
                </label>
                <label class="radio inline">
                  <span>4</span><input type="radio" name="rfeConceptrepresentation" id="rfeConceptrepresentation4" value="4">
                </label>
                <label class="radio inline">
                  <span>5</span><input type="radio" name="rfeConceptrepresentation" id="rfeConceptrepresentation5" value="5"><span>Poorly</span>
                </label>
              </div>
              <hr>
              <p>3. If the SNOMED CT concept was not an accurate representation, or no appropriate SNOMED CT concept was found, please write in free text the clinical term you wished to record.</p>
              <input type="text" class="span8" id="rfeConceptfreetext" name="rfeConceptfreetext" maxlength="250">
              <hr>
              <p>4. The associated ICPC-2 code is: <span class="uneditable-input span3">xxxxx</span></p>
              <input type="hidden" id="rfeIcpc2" name="rfeIcpc2" value="xxxxx">
              <hr>
              <p>5. In your opinion, is this ICPC-2 code an appropriate match for the RFE you recorded?</p>
              <div class="likert">
                <label class="radio inline">
                  <span>1</span><input type="radio" name="rfeIcpc2appropriate" id="rfeIcpc2appropriate1" value="1"><span>Very</span>
                </label>
                <label class="radio inline">
                  <span>2</span><input type="radio" name="rfeIcpc2appropriate" id="rfeIcpc2appropriate2" value="2">
                </label>
                <label class="radio inline">
                  <span>3</span><input type="radio" name="rfeIcpc2appropriate" id="rfeIcpc2appropriate3" value="3">
                </label>
                <label class="radio inline">
                  <span>4</span><input type="radio" name="rfeIcpc2appropriate" id="rfeIcpc2appropriate4" value="4">
                </label>
                <label class="radio inline">
                  <span>5</span><input type="radio" name="rfeIcpc2appropriate" id="rfeIcpc2appropriate5" value="5"><span>Not at all</span>
                </label>
              </div>
              <hr>
              <p>6. If the ICPC-2 code is not an appropriate match, please record your preferred ICPC-2 code:</p>
              <select id="rfeIcpc2choice" name="rfeIcpc2choice" class="span8">
                <option value="">Select ICPC-2 code</option>
                <option value="">ICPC-2 code and label</option>
                <option value="">ICPC-2 code and label</option>
                <option value="">ICPC-2 code and label</option>
                <option value="">ICPC-2 code and label</option>
                <option value="">ICPC-2 code and label</option>
                <option value="">ICPC-2 code and label</option>
                <option value="">ICPC-2 code and label</option>
                <option value="">ICPC-2 code and label</option>
              </select>

              <div class="form-actions">
                <button type="submit" class="btn">Add another RFE</button>
                <a href="add-health-issue.php" class="btn">RFEs complete - add health issue(s)</a>
              </div>

            </fieldset>
          </form>
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