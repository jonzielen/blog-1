<h1>Login:</h1>
<?php if (@$_SESSION['logged_in'] != true): ?>
<form action="<?php echo SITE_URL.'login'; ?>" method="post">
  <label>Username:</label>
  <input type="text" name="username" id="username" />

  <label>Password:</label>
  <input type="password" name="password" id="password" />

  <button>Go!</button>
</form>
<?php endif ?>

<?php if (@$_SESSION['logged_in'] == true): ?>
  <h2>You are now logged in.</h2>
<?php endif ?>
