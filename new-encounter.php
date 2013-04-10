<?php include "inc/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('inc/head.php'); ?>

  <title>SNOMED CT GP/FP RefSet Field Test - New encounter</title>
</head>
<body>
  <div class="container">
    <?php require('inc/header.php'); ?>
    <div class="main clearfix">

      <div class="page-header">
        <h1>New encounter</h1>
      </div>

      <h2>Add reason for encounter (RFE)</h2>
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
                <input id="rfeSearch" name="rfeSearch" type="text" maxlength="50">
                <button class="btn" type="button">Search</button>
              </div>
              <select class="input-xlarge" id="rfeConcepts" name="rfeConcepts">
                <option value="">Select SNOMED concept</option>
                <?php require('inc/concepts.php'); ?>
              </select>
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
              <input type="text" class="span3" id="rfeIcpc2freetext" name="rfeIcpc2freetext" maxlength="250">

              <div class="form-actions">
                <button type="submit" class="btn">Add another RFE</button>
                <button type="button" class="btn">RFEs complete - add health issue(s)</button>
              </div>

            </fieldset>
          </form>
        </div>
      </div>

    </div>
    <?php require('inc/footer.php'); ?>
  </div>

<?php require('inc/script.php'); ?>
</body>
</html>