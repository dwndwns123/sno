<?php include "inc/conn.php";
include "inc/logging.php";

// This function is to retrieve the SCT mapped codes depending on the provided ICPC-2 code 

$codeid = $_POST["codeid"];
$refid = $_POST["refid"];

$sql = "select DISTINCT concept_id, label FROM ICPC_SCT_Map, SCT_Concepts S WHERE sct_id = concept_id AND icpc_id = '$codeid' AND refset_type_id ='$refid' ORDER BY label";
$result = mysql_query($sql) or die(mysql_error());

$rows = array();

$log -> user($sql);

while($row = mysql_fetch_array($result)){
  $rows[] = array("conceptId" => $row["concept_id"], "term" => $row["label"]);
}

echo json_encode($rows);
?>