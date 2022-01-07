<?php
namespace Ijdb\Controllers;

class Joke {

    public function __construct(private \Ninja\DatabaseTable $jokesTable, private \Ninja\DatabaseTable $authorsTable, private \Ninja\Authentication $authentication) {
    }

	public function home() {
	    $title = 'Internet Joke Database';

	    return ['template' => 'home.html.php',
		    'title' => $title,
		    'variables' => []
		];
	}

	public function delete() {

	  $author = $this->authentication->getUser();

	  $joke = $this->jokesTable->find('id', $_POST['id'])[0];

	  if ($joke['authorId'] != $author['id']) {
	    return;
	  }

	  $this->jokesTable->delete('id', $_POST['id']);

	  header('location: /joke/list');
	}

	public function list() {
	    $result = $this->jokesTable->findAll();

	    $jokes = [];
	    foreach ($result as $joke) {
	        $author = $this->authorsTable->find('id', $joke->authorId)[0];

			$jokes[] = [
			  'id' => $joke->id,
			  'joketext' => $joke->joketext,
			  'jokedate' => $joke->jokedate,
			  'name' => $author->name,
			  'email' => $author->email,
			  'authorId' => $joke->authorId
			];

	    }

	    $title = 'Joke list';

	    $totalJokes = $this->jokesTable->total();

	    $user = $this->authentication->getUser();

	    return ['template' => 'jokes.html.php',
		    'title' => $title,
		    'variables' => [
		        'totalJokes' => $totalJokes,
		        'jokes' => $jokes,
		        'userId' => $user->id ?? null
		    ]
		];

	}

	public function editSubmit() {
		// Get the currently logged in user as the $author to associate the joke with
		$author = $this->authentication->getUser();

		// Create an `Author` entity instance
		$authorObject = new \Ijdb\Entity\Author($this->jokesTable);

		// Copy the values from the `$author` array into the corresponding properties in the entity object
		$authorObject->id = $author['id'];
		$authorObject->name = $author['name'];
		$authorObject->email = $author['email'];
		$authorObject->password = $author['password'];

		// Read the form submission and set the date
		$joke = $_POST['joke'];
		$joke['jokedate'] = new \DateTime();

		// Save the joke using the new addJoke method
		$authorObject->addJoke($joke);

		header('location: /joke/list');
	}

	public function edit($id = null) {
	    if (isset($id)) {
	        $joke = $this->jokesTable->find('id', $id)[0] ?? null;
	    }
	    else {
	    	$joke = null;
        }

	    $title = 'Edit joke';

	    $author = $this->authentication->getUser();

	    return ['template' => 'editjoke.html.php',
	        'title' => $title,
	        'variables' => [
	            'joke' => $joke,
	            'userId' => $author['id'] ?? null
	        ]
	    ];
	}
}