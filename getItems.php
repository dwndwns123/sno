<?php include "inc/conn.php";
include "inc/logging.php";

$enc = $_POST["enc"];
$option = $_SESSION["option"];
$log -> user("enc is - '$enc' - and option is - '$option'");

$reasonSQL = "SELECT * FROM Encounter_Reasons WHERE encounter_id = '$enc'";
$result = mysql_query($reasonSQL) or die(mysql_error());
$log -> user($reasonSQL);

$rows = array();
while ($row = mysql_fetch_array($result)) {

    if ($option == "2") {
        $sql = "SELECT title FROM ICPC_Codes WHERE id = '$row[icpc_id]'";
        $icpcResult = mysql_query($sql) or die(mysql_error());
        $icpc = mysql_fetch_array($icpcResult);

        $log -> user($sql);

        $rows[] = array("reason_id" => $row["reason_id"], "term" => $icpc["title"], "type" => $row["refset_id"]);
        $log -> user("the array looks like - '$row[reason_id]' - '$icpc[title]' - '$row[refset_id]'");

    } else {
        $sql = "SELECT label FROM SCT_Concepts WHERE concept_id = '$row[sct_id]'";
        $conceptResult = mysql_query($sql) or die(mysql_error());
        $concept = mysql_fetch_array($conceptResult);

        $log -> user($sql);
        
        if ($row['sct_id'] == '0') {
            $rows[] = array("reason_id" => $row["reason_id"], "term" => $row["sct_alt"], "type" => $row["refset_id"]);
        } else {
            $rows[] = array("reason_id" => $row["reason_id"], "term" => $concept["label"], "type" => $row["refset_id"]);
        }
        
    }
}

echo json_encode($rows);
?>