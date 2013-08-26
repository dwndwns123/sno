<?php
include "inc/conn.php";
include "inc/logging.php";

$recordType = ($_SESSION["add_mode"] == 0 ? "RFE" : "Health Issue");

$refset_type = 0;
$searchText = $_POST["searchText"];
if ($recordType == "Health Issue") {
    $refset_type = 1;
}

$searchWords = explode(" ", $searchText);
$arrayCount = count($searchWords);
$log -> user("easrch words index 1 - '$searchWords[1]'");
$log -> user("easrch words length is - '$arrayCount'");
if ($arrayCount > 1) {
    $searchText = ('"%'.$searchWords[0].'%"');
    for ($x = 1; $x < $arrayCount; $x++) {
        if ($searchWords[$x] != '') {
            $searchText = (''.$searchText.' AND Syn.Synonym LIKE "%'.$searchWords[$x].'%"');
            $log -> user($searchText);
        }
    }
} else {
    $searchText = ('"%'.$searchWords[0].'%"');
}

$sql = ('select DISTINCT Syn.conceptId, SCT_Concepts.label AS term from ICPCSynonyms Syn 
                        INNER JOIN SCT_Concepts ON Syn.ConceptId = SCT_Concepts.concept_id 
                        WHERE Syn.Synonym LIKE ' . $searchText . ' AND SCT_Concepts.refset_type_id = "' . $refset_type . '"
                        ORDER BY term');

$result = mysql_query($sql) or die(mysql_error());
$rows = array();
$log -> user($sql);

while ($row = mysql_fetch_array($result)) {
    $rows[] = array("conceptId" => $row["conceptId"], "term" => $row["term"]);
}

echo json_encode($rows);
?>