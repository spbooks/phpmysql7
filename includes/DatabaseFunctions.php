<?php
function totalJokes($pdo) {
  $stmt = $pdo->prepare('SELECT COUNT(*) FROM `joke`');
  $stmt->execute();

  $row = $stmt->fetch();

  return $row[0];
}

function getJoke($pdo, $id) {
  $stmt = $pdo->prepare('SELECT * FROM `joke` WHERE `id` = :id');

  $values = [
      'id' => $id
  ];
  $stmt->execute($values);

  return $stmt->fetch();
}

function insertJoke($pdo, $values) {
	$query = 'INSERT INTO `joke` (';

	foreach ($values as $key => $value) {
		$query .= '`' . $key . '`,';
	}

	$query = rtrim($query, ',');

	$query .= ') VALUES (';

	foreach ($values as $key => $value) {
		$query .= ':' . $key . ',';
	}

	$query = rtrim($query, ',');

	$query .= ')';

	$stmt = $pdo->prepare($query);

	$stmt->execute($values);

}

function updateJoke($pdo, $values) {

	$query = ' UPDATE `joke` SET ';

	$updateFields = [];
	foreach ($values as $key => $value) {
		$updateFields[] = '`' . $key . '` = :' . $key;
	}

	$query .= implode(', ', $updateFields);

	$query .= ' WHERE `id` = :primaryKey';

	// Set the :primaryKey variable
	$values['primaryKey'] = $values['id'];

	$stmt = $pdo->prepare($query);
	$stmt->execute($values);
}

function deleteJoke($pdo, $id) {

  $stmt = $pdo->prepare('DELETE FROM `joke` WHERE `id` = :id');

  $values = [
    ':id' => $id
  ];

  $stmt->execute($values);
}

function allJokes($pdo) {
  $stmt = $pdo->prepare('SELECT `joke`.`id`, `joketext`, `name`, `email`
    FROM `joke` INNER JOIN `author`
      ON `authorid` = `author`.`id`');

  $stmt->execute();

  return $stmt->fetchAll();
}