<h1>Add Blog Post:</h1>

<form action="<?php echo SITE_URL.'add' ?>" method="post" id="add-post">
  <label for="title">Title:</label>
  <input type="text" id="title" name="title" />

  <label for="tags">Tags: (comma separated)</label>
  <input type="text" id="tags" name="tags" />

  <label for="body">Body:</label>
  <textarea id="body" name="body"></textarea>

  <button>Go!</button>
</form>
