<?php
namespace Ijdb\Controllers;

class Joke {

    public function __construct(private \Ninja\DatabaseTable $jokesTable, private \Ninja\DatabaseTable $authorsTable, private \Ninja\DatabaseTable $categoriesTable, private \Ninja\Authentication $authentication) {
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

		if ($joke->authorId != $author->id && !$author->hasPermission(\Ijdb\Entity\Author::DELETE_JOKE)) {
			return;
		}
		$this->jokesTable->delete('id', $_POST['id']);

		header('location: /joke/list');
	}

	public function list($categoryId = null) {
	  if (isset($categoryId)) {
	    $category = $this->categoriesTable->find('id', $categoryId)[0];
	    $jokes = $category->getJokes();
	  }
	  else {
	    $jokes = $this->jokesTable->findAll('jokedate DESC', 10);
	  }

	  $totalJokes = $this->jokesTable->total();

	  $user = $this->authentication->getUser();

	  return ['template' => 'jokes.html.php',
	        'title' => 'Joke List',
	        'variables' => [
			    'totalJokes' => $totalJokes,
		        'jokes' => $jokes,
		        'user' => $user,
		        'categories' => $this->categoriesTable->findAll()        
		    ]
	       ];
	}
	
	public function editSubmit() {
	  $author = $this->authentication->getUser();

	  if (!empty($id)) {
	     $joke = $this->jokesTable->find('id', $id)[0];

	    if ($joke->authorId != $author->id) {
	      return;
	    }
	  }   

	  $joke = $_POST['joke'];
	  $joke['jokedate'] = new \DateTime();

	  $jokeEntity = $author->addJoke($joke);

	  $jokeEntity->clearCategories();

	  foreach ($_POST['category'] as $categoryId) {
	    $jokeEntity->addCategory($categoryId);
	  }

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
	    $categories = $this->categoriesTable->findAll();

	    return ['template' => 'editjoke.html.php',
	        'title' => $title,
	        'variables' => [
	            'joke' => $joke,
	            'user' => $author,
	            'categories' => $categories
	        ]
	    ];
	}
}