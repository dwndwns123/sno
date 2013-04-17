<?php
include "inc/conn.php";

$enc = $_POST["id"];

mysql_query("DELETE FROM Encounter_Reasons WHERE rfe_id = '".$enc."'") or die(mysql_error());

echo "success";
?>