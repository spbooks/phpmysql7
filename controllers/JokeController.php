<?php
class JokeController {

	private $authorsTable;
    private $jokesTable;

    public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable) {
        $this->jokesTable = $jokesTable;
        $this->authorsTable = $authorsTable;
    }

	public function home() {
	    $title = 'Internet Joke Database';

	    return ['template' => 'home.html.php',
		    'title' => $title,
		    'variables' => []
		];
	}

	public function delete() {
	    $this->jokesTable->delete('id', $_POST['id']);

	    header('location: index.php?action=list');
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
	            'email' => $author['email']
	        ];

	    }

	    $title = 'Joke list';

	    $totalJokes = $this->jokesTable->total();

	    return ['template' => 'jokes.html.php',
		    'title' => $title,
		    'variables' => [
		        'totalJokes' => $totalJokes,
		        'jokes' => $jokes
		    ]
		];

	}

	public function edit($id = null) {
	    if (isset($_POST['joke'])) {

	        $joke = $_POST['joke'];
	        $joke['jokedate'] = new DateTime();
	        $joke['authorId'] = 1;

	        $this->jokesTable->save($joke);

	  		header('location: index.php?action=list');

	    }
	    else {

	        if (isset($id)) {
	            $joke = $this->jokesTable->find('id', $_GET['id'])[0];
	        }
	        else {
	        	$joke = null;
	        } 


	        $title = 'Edit joke';

	        return ['template' => 'editjoke.html.php',
			    'title' => $title,
			    'variables' => [
			        'joke' => $joke
			    ]
			];
	    }
	}
}