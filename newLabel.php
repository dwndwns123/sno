<?php
include "inc/conn.php";

$txt = $_POST["txt"];
$enc = $_POST["enc"];

$sql = "UPDATE Encounters SET label = '$txt' WHERE encounter_id = '$enc'";

mysql_query($sql) or die(mysql_error());

echo "success";
?>