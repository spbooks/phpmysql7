<?php
namespace Ijdb\Entity;

class Author {
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

      $this->jokesTable->save($joke);

      return $this->jokesTable->find('id', $joke['id'])[0];
    }
}