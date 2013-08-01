<?php
include "inc/conn.php";

$searchText = $_POST["searchText"];

$result = mysql_query('SELECT DISTINCT id, title 
                        FROM ICPC_Codes 
						WHERE title like "%'.$searchText.'%" OR id like "%'.$searchText.'%"
						ORDER BY title') 
						or die(mysql_error());
$rows = array();
while($row = mysql_fetch_array($result)){
  $rows[] = array("id" => $row["id"], "title" => $row["title"]);
}

echo json_encode($rows);
?>