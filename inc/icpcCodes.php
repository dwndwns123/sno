<?php

$result = mysql_query("SELECT * FROM ICPC_Codes ORDER BY title") or die(mysql_error());

while($row = mysql_fetch_array($result)){

  ?>
  <option value="<?=$row['id'];?>"><?=$row['title'];?></option>
  <?php
}
?>
