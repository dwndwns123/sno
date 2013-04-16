<?php
include "inc/conn.php";

mysql_query("TRUNCATE TABLE Countries") or die(mysql_error());

$file_handle = fopen("_assets/country-list-iso-codes.txt", "rb");
$c = 0;
while (!feof($file_handle)) {
  $line = fgets($file_handle);

  $cc = explode(":", $line)[0];
  $name = mysql_real_escape_string(explode(":", $line)[1]);

  $sql = "INSERT INTO Countries (country_id,country_code,name) VALUES ('$c','$cc','$name')";
  mysql_query($sql) or die(mysql_error());
  $c++;

  echo $cc." -> ".$name."<br>";
}
fclose($file_handle);
?>