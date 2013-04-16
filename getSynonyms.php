<?php
include "inc/conn.php";

$syn = $_POST["syn"];

$result = mysql_query('select Synonym from ICPCSynonyms where conceptId like "'.$syn.'"') or die(mysql_error());
$rows = array();
while($row = mysql_fetch_array($result)){
  $rows[] = array("synonym" => $row["Synonym"]);
}

echo json_encode($rows);
?>