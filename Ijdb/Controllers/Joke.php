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

	  if ($joke->authorId != $author->id) {
	    return;
	  }

	  $this->jokesTable->delete('id', $_POST['id']);

	  header('location: /joke/list');
	}

	public function list() {
	  $jokes = $this->jokesTable->findAll();

	  $totalJokes = $this->jokesTable->total();

	  $user = $this->authentication->getUser();

	  return ['template' => 'jokes.html.php',
	        'title' => 'Joke List',
	        'variables' => [
			    'totalJokes' => $totalJokes,
		        'jokes' => $jokes,
		        'userId' => $user->id ?? null	        
		    ]
	       ];
	}
	
	public function editSubmit() {
		$authorObject = $this->authentication->getUser();

		$joke = $_POST['joke'];
		$joke['jokedate'] = new \DateTime();

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