<?php include "inc/conn.php";

$enc = $_POST["id"];

//mysql_query("DELETE FROM Encounter_Reasons WHERE encounter_id = '".$enc."'") or die(mysql_error());
//mysql_query("DELETE FROM Encounters WHERE encounter_id = '".$enc."'") or die(mysql_error());

mysql_query("UPDATE Encounter_Reasons SET active='n' WHERE encounter_id = '".$enc."'") or die(mysql_error());
mysql_query("UPDATE Encounters SET active='n' WHERE encounter_id = '".$enc."'") or die(mysql_error());

echo "success";
?>