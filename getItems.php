<?php
include "inc/conn.php";

$enc = $_POST["enc"];

$result = mysql_query("SELECT * FROM Encounter_Reasons WHERE encounter_id = '$enc'") or die(mysql_error());
$rows = array();
while($row = mysql_fetch_array($result)){
  $sql = "SELECT PT FROM SCT_Concepts WHERE ConceptId = '$row[sct_id]'";
  $conceptResult = mysql_query($sql) or die(mysql_error());
  $concept = mysql_fetch_array($conceptResult);

  $rows[] = array("rfe_id" => $row["rfe_id"], "term" => $concept["PT"], "type" => $row["refset_id"]);
}

echo json_encode($rows);
?>