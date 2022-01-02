<?php
namespace Ijdb\Controllers;
use \Ninja\DatabaseTable;
class Author {
    public function __construct(private DatabaseTable $authorsTable) {
    }

    public function registrationForm() {
        return [
          'template' => 'register.html.php',
            'title' => 'Register an account'
         ];
    }

	public function registrationFormSubmit() {
		$author = $_POST['author'];

		// Start with an empty array
		$errors = [];

		// But if any of the fields have been left blank, set $valid to false
		if (empty($author['name'])) {
			$errors[] = 'Name cannot be blank';
		}

		if (empty($author['email'])) {
			$valid = false;
			$errors[] = 'Email cannot be blank';
		}
		else if (filter_var($author['email']) == false) {
			$valid = false;
			$errors[] = 'Invalid email address';
		}

		if (empty($author['password'])) {
			$errors[] = 'Password cannot be blank';
		}

		// If the $errors array is still empty, no fields were blank and the data can be added
		if (empty($errors)) {
			$this->authorsTable->save($author);

			header('Location: /author/success');
		}
		else {
		// If the data is not valid, show the form again
		return ['template' => 'register.html.php',
				'title' => 'Register an account',
				'variables' => [
				'errors' => $errors,
				'author' => $author
			]
			];
		}
	}

    public function success() {
        return ['template' => 'registersuccess.html.php',
            'title' => 'Registration Successful'];
    }
}