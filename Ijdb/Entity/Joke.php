<?php
namespace Ijdb\Entity;

class Joke {
    public int $id;
    public int $authorId;
    public string $jokedate;
    public string $joketext;
    private ?object $author;

    public function __construct(private ?\Ninja\DatabaseTable $authorsTable, private ?\Ninja\DatabaseTable $jokeCategoriesTable) {
    }

    public function getAuthor() {
      if (empty($this->author)) {
        $this->author = $this->authorsTable->find('id', $this->authorId)[0];
      }

      return $this->author;
    }

    public function addCategory($categoryId) {
      $jokeCat = ['jokeId' => $this->id, 'categoryId' => $categoryId];

      $this->jokeCategoriesTable->save($jokeCat);
    }
}