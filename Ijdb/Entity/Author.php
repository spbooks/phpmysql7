<?php
namespace Ijdb\Entity;

class Author {

    const EDIT_JOKES = 1;
    const DELETE_JOKES = 2;
    const LIST_CATEGORIES = 4;
    const EDIT_CATEGORY = 8;
    const DELETE_CATEGORY = 16;
    const EDIT_USER_ACCESS = 32;

    public $id;
    public $name;
    public $email;
    public $password;

    public function __construct(private \Ninja\DatabaseTable $jokesTable) {

    }

    public function getJokes() {
        return $this->jokesTable->find('authorId', $this->id);
    }

    public function addJoke(array $joke) {
      // set the `authorId` in the new joke to the id stored in this instance
      $joke['authorId'] = $this->id;

      return $this->jokesTable->save($joke);
    }

    public function hasPermission(int $permission) {
        return $this->permissions & $permission;
    }

}