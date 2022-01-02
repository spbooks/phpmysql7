<?php
if (isset($errorMessage)):
    echo '<div class="errors">Sorry, your username and password could not be found.</div>';
endif;
?>
<form method="post" action="">
  <label for="email">Your email address</label>
  <input type="text" id="email" name="email">

  <label for="password">Your password</label>
  <input type="password" id="password" name="password">

  <input type="submit" name="login" value="Log in">
</form>

<p>Don't have an account? <a href="/author/registrationForm">Click here to register</a></p>