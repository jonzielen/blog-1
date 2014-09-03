<h1>Edit Blog Post:</h1>
<form action="<?php echo SITE_URL.$_SERVER['REQUEST_URI']; ?>" method="post" id="edit-post">
  <label for="page_url">Page URL: <span>(ONLY LETTERS, NUMBERS, UNDERSCORES AND DASHES ACCEPTED)</span></label>
  <input type="text" id="page_url" name="page_url" value="{page_url}" />

  <label for="title">Title:</label>
  <input type="text" id="title" name="title" value="{post_title}" />

  <label for="tags">Tags: <span>(comma separated)</span></label>
  <input type="text" id="tags" name="tags" value="{tags}" />

  <label for="body">Body:</label>
  <textarea id="body" name="body">{post_body}</textarea>

  <input type="hidden" id="id" name="id" value="{id}">
  <input type="hidden" id="old_page_url" name="old_page_url" value="{page_url}">

  <button>Go!</button>
</form>

<!-- <div class="blog-post">
  <h1>{post_title}</h1>
  <h3>{unix_time}</h3>
  <div class="tag-list">{tags}</div>
  <div class="blog-post-body">{post_body}</div>
</div>
 -->
