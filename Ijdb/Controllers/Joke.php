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

	public function deleteSubmit() {

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
	        $author = $this->authorsTable->find('id', $joke['authorId'])[0];

	        $jokes[] = [
	            'id' => $joke['id'],
	            'joketext' => $joke['joketext'],
	            'jokedate' => $joke['jokedate'],
	            'name' => $author['name'],
	            'email' => $author['email'],
	            'authorId' => $author['id']
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
		        'userId' => $user['id'] ?? null
		    ]
		];

	}

	public function editSubmit($id = null) {
		$author = $this->authentication->getUser();

	    $joke = $_POST['joke'];
	    $joke['jokedate'] = new \DateTime();
	    $joke['authorId'] = $author['id'];

	    $this->jokesTable->save($joke);

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