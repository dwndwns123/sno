<?php
$result = mysql_query("SELECT * FROM SCT_Concepts") or die(mysql_error());
while($row = mysql_fetch_array($result)){
  $selText = '';
  if($item){
    $selText = ($item['sct_id'] == $row['ConceptId'] ? ' selected="selected"' : '');
  }
  ?>
  <option value="<?=$row['ConceptId'];?>"<?= $selText; ?>><?=$row['PT'];?></option>
  <?php
}
?>
