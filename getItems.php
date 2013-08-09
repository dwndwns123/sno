<?php
include "inc/conn.php";

$enc = $_POST["enc"];

$reasonSQL = "SELECT * FROM Encounter_Reasons WHERE encounter_id = '$enc'";
$result = mysql_query($reasonSQL) or die(mysql_error());
error_log($reasonSQL);

$rows = array();
while ($row = mysql_fetch_array($result)) {

    if ($_SESSION["option"] == 2) {
        $sql = "SELECT title FROM ICPC_Codes WHERE id = '$row[icpc_id]'";
        $icpcResult = mysql_query($sql) or die(mysql_error());
        $icpc = mysql_fetch_array($icpcResult);

        error_log($sql);

        $rows[] = array("reason_id" => $row["reason_id"], "term" => $icpc["title"], "type" => $row["refset_id"]);
    } else {
        $sql = "SELECT label FROM SCT_Concepts WHERE concept_id = '$row[sct_id]'";
        $conceptResult = mysql_query($sql) or die(mysql_error());
        $concept = mysql_fetch_array($conceptResult);

        error_log($sql);
        $rows[] = array("reason_id" => $row["reason_id"], "term" => $concept["label"], "type" => $row["refset_id"]);
    }
}

echo json_encode($rows);
?>