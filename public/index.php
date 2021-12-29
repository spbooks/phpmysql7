<?php
try {
  $pdo = new PDO('mysql:host=mysql;dbname=ijdb', 'ijdbuser',
    'mypassword');
   $output = 'Database connection established.';
}
catch (PDOException $e) {
  $output = 'Unable to connect to the database server: ' . $e->getMessage();
}

include  __DIR__ . '/../templates/output.html.php';