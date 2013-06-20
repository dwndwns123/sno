<?php

if($recordType == "Health Issue")
    {
        $result = mysql_query("SELECT * FROM SCT_Concepts WHERE refset_type_id = 2 ORDER BY label") or die(mysql_error());
    } else {
        $result = mysql_query("SELECT * FROM SCT_Concepts WHERE refset_type_id = 1 ORDER BY label") or die(mysql_error());       
    }

while($row = mysql_fetch_array($result)){
  $selText = '';
  if($item){
    $selText = ($item['sct_id'] == $row['concept_id'] ? ' selected="selected"' : '');
  }
  ?>
  <option value="<?=$row['concept_id'];?>"<?= $selText; ?>><?=$row['label'];?></option>
  <?php
}
?>
