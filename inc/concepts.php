<?php
$result = mysql_query("SELECT * FROM SCT_Concepts") or die(mysql_error());
while($row = mysql_fetch_array($result)){
  ?>
  <option value="<?=$row['ConceptId'];?>"><?=$row['PT'];?></option>
  <?php
}
?>
