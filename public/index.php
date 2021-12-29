<?php
try {
  $pdo = new PDO('mysql:host=mysql;dbname=ijdb;charset=utf8mb4', 'ijdbuser', 'mypassword');

  $sql = 'UPDATE joke SET jokedate="2021-04-01"
      WHERE joketext LIKE "%programmer%"';

  $affectedRows = $pdo->exec($sql);

  $output = 'Updated ' . $affectedRows .' rows.';
}
catch (PDOException $e) {
  $output = 'Database error: ' . $e->getMessage() . ' in ' .
  $e->getFile() . ':' . $e->getLine();
}

include  __DIR__ . '/../templates/output.html.php';