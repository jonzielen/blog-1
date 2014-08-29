<?php if (@$_SESSION['logged_in'] == true): ?>
  <h2>Admin Nav:</h2>
  <ul>
    <li><a href="/add">add blog post</a></li>
    <li><a href="/logout">logout</a></li>
  </ul>
<?php endif ?>
