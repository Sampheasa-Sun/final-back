<?php
$m = new mysqli('127.0.0.1', 'root', '', 'cloudfinalback', 3306);
if ($m->connect_errno) { echo 'Error connecting'; exit(1); }
$r = $m->query('SHOW TABLES');
echo "=== Tables ===\n";
while($row = $r->fetch_row()) {
  echo $row[0] . "\n";
}
echo "=== Migrations ===\n";
$r2 = $m->query('SELECT * FROM migrations');
if($r2) {
   while($row = $r2->fetch_assoc()) print_r($row);
}
