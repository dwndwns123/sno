<?php
include "inc/conn.php";

$codeid = $_POST["codeid"];

$result = mysql_query('select id, title FROM ICPC_SCT_Map, ICPC_Codes WHERE icpc_id = id AND sct_id = "'.$codeid.'"') or die(mysql_error());
$rows = array();
while($row = mysql_fetch_array($result)){
  $rows[] = array("id" => $row["id"], "title" => $row["title"]);
}

// to check if there has not been a match and populate with default 'no match'
if (count($rows) == 0) {
  $rows[] = array("id" => "", "title" => "No Match");   
  error_log("No match to icpc code");
}

echo json_encode($rows);
?>