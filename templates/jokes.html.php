<div class="jokelist">

<ul class="categories">
  <?php foreach ($categories as $category): ?>
    <li><a href="/joke/list/<?=$category->id?>"><?=$category->name?></a><li>
  <?php endforeach; ?>
</ul>

<div class="jokes">
<p><?=$totalJokes?> jokes have been submitted to the Internet Joke Database.</p>

<?php foreach ($jokes as $joke): ?>
<blockquote>
<?=(new \Ninja\Markdown($joke->joketext))->toHtml()?></p>

    (by <a href="mailto:<?=htmlspecialchars($joke->getAuthor()->email, ENT_QUOTES,  'UTF-8'); ?>">
      <?=htmlspecialchars($joke->getAuthor()->name, ENT_QUOTES, 'UTF-8'); ?></a> on
<?php
$date = new DateTime($joke->jokedate);

echo $date->format('jS F Y');
?>)


<?php if ($user): ?>
  <?php if ($user->id == $joke->authorId || $user->hasPermission(\Ijdb\Entity\Author::EDIT_JOKES)): ?>
  <a href="/joke/edit/<?=$joke->id?>">Edit</a>
  <?php endif; ?>
  <?php if ($user->id == $joke->authorId || $user->hasPermission(\Ijdb\Entity\Author::DELETE_JOKES)): ?>
  <form action="/joke/delete" method="post">
    <input type="hidden" name="id" value="<?=$joke->id?>">
    <input type="submit" value="Delete">
  </form>
  <?php endif; ?>
<?php endif; ?>

</blockquote>
<?php endforeach; ?>


Select page:

<?php
// Calculate the number of pages
$numPages = ceil($totalJokes/10);

// Display a link for each page
for ($i = 1; $i <= $numPages; $i++):
?>
  <a href="/joke/list/all/<?=$i?>"><?=$i?></a>
<?php endfor; ?>

</div>


</div>

