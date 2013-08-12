<?php include "inc/conn.php";

$enc = $_POST["id"];

mysql_query("DELETE FROM Encounter_Reasons WHERE reason_id = '".$enc."'") or die(mysql_error());

echo "success";
?>