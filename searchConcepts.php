<?php include "inc/conn.php";

$recordType = ($_SESSION["add_mode"] == 0 ? "RFE" : "Health Issue");

$refset_type = 0;
$searchText = $_POST["searchText"];
if($recordType == "Health Issue") {
       $refset_type = 1;
} 

$sql = ('select DISTINCT Syn.conceptId, SCT_Concepts.label AS term from ICPCSynonyms Syn 
                        INNER JOIN SCT_Concepts ON Syn.ConceptId = SCT_Concepts.concept_id 
                        WHERE Syn.Synonym like "%'.$searchText.'%" AND SCT_Concepts.refset_type_id = "'.$refset_type.'"
                        ORDER BY term');

$result = mysql_query($sql) or die(mysql_error());
$rows = array();
error_log($sql);

while($row = mysql_fetch_array($result)){
  $rows[] = array("conceptId" => $row["conceptId"], "term" => $row["term"]);
}

echo json_encode($rows);
?>