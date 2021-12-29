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

	$values = processDates($values);

	$stmt = $pdo->prepare($query);
	$stmt->execute($values);
}

function updateJoke($pdo, $values) {

	$query = ' UPDATE `joke` SET ';

	foreach ($values as $key => $value) {
		$query .= '`' . $key . '` = :' . $key . ',';
	}

	$query = rtrim($query, ',');

	$query .= ' WHERE `id` = :primaryKey';

	// Set the :primaryKey variable
	$values['primaryKey'] = $values['id'];

	$values = processDates($values);

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

function processDates($values) {
	foreach ($values as $key => $value) {
		if ($value instanceof DateTime) {
			$values[$key] = $value->format('Y-m-d H:i:s');
		}
	}

	return $values;
}