<?php
namespace Ijdb\Controllers;

use \Ninja\DatabaseTable;

class Register {
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

	  $this->authorsTable->save($author);

	  header('Location: /author/success');
	}

    public function success() {
        return ['template' => 'registersuccess.html.php',
            'title' => 'Registration Successful'];
    }
}