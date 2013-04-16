<?php
include "inc/conn.php";

$searchText = $_POST["searchText"];

$result = mysql_query('select DISTINCT Syn.conceptId, SCT_Concepts.pt AS term from ICPCSynonyms Syn INNER JOIN SCT_Concepts ON Syn.ConceptId = SCT_Concepts.ConceptId where Syn.Synonym like "%'.$searchText.'%"') or die(mysql_error());
$rows = array();
while($row = mysql_fetch_array($result)){
  $rows[] = array("conceptId" => $row["conceptId"], "term" => $row["term"]);
}

echo json_encode($rows);
?>