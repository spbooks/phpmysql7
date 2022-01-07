<?php
namespace Ijdb\Controllers;

class Category {
    public function __construct(private \Ninja\DatabaseTable $categoriesTable) {

    }

    public function edit(?string $id = null) {

      if (isset($id)) {
        $category = $this->categoriesTable->find('id', $id)[0];
      }

      return ['template' => 'editcategory.html.php',
        'title' =>  'Edit Category',
        'variables' => [
          'category' => $category ?? null
        ]
      ];
    }

    public function editSubmit() {
      $category = $_POST['category'];

      $this->categoriesTable->save($category);

      header('location: /category/list');
    }

    public function list() {
      return ['template' => 'categories.html.php',
        'title' => 'Joke Categories',
        'variables' => [
          'categories' => $this->categoriesTable->findAll()
        ]
      ];
    }
}