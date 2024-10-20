<?php

try {

   $host = "localhost";
   $database = "db_hr_jt";
   $dsn = "mysql:host =".$host.";dbname=".$database;
   $user = 'root';
   $password = '';
   $conn = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
   echo "Issue-> Connection fail" . $e->getMessage();
}
