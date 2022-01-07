<?php
namespace Ijdb\Entity;

class Joke {
    public int $id;
    public int $authorId;
    public string $jokedate;
    public string $joketext;
    private $author;

    public function __construct(private ?\Ninja\DatabaseTable $authorsTable = null) {
    }

    public function getAuthor() {
      if (empty($this->author)) {
        $this->author = $this->authorsTable->find('id', $this->authorId)[0];
      }

      return $this->author;
    }
}