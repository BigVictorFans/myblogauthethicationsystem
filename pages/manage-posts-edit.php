<?php
if (!isUserLoggedIn()) {
  header("Location: /dashboard");
  exit;
}

$database = connectToDB();


if (!isset($_GET['id'])) {
  header("Location: /manage-posts");
  exit;
}

$postId = $_GET['id'];
$error = "";


$query = $database->prepare("SELECT * FROM posts WHERE id = :id LIMIT 1");
$query->execute([
  "id" => $postId
]);
$post = $query->fetch();


if (!$post) {
  header("Location: /manage-posts");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $title = trim($_POST['title']);
  $content = trim($_POST['content']);
  $status = trim($_POST['status']);

  if (empty($title) || empty($content) || empty($status)) {
    $error = "All fields are required.";
  } else {
    $updateQuery = $database->prepare("
      UPDATE posts 
      SET title = :title, content = :content, status = :status 
      WHERE id = :id
    ");

    $success = $updateQuery->execute([
      "title" => $title,
      "content" => $content,
      "status" => $status,
      "id" => $postId
    ]);

    if ($success) {
      header("Location: /manage-posts");
      exit;
    } else {
      $error = "Failed to update the post.";
    }
  }
}
?>

<?php require "parts/header.php"; ?>
<div class="container mx-auto my-5" style="max-width: 700px;">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <h1 class="h1">Edit Post</h1>
  </div>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <div class="card mb-2 p-4">
    <form method="POST">
      <div class="mb-3">
        <label for="post-title" class="form-label">Title</label>
        <input
          type="text"
          class="form-control"
          id="post-title"
          name="title"
          value="<?= htmlspecialchars($post['title']) ?>"
        />
      </div>
      <div class="mb-3">
        <label for="post-content" class="form-label">Content</label>
        <textarea
          class="form-control"
          id="post-content"
          name="content"
          rows="10"
        ><?= htmlspecialchars($post['content']) ?></textarea>
      </div>
      <div class="mb-3">
        <label for="post-status" class="form-label">Status</label>
        <select class="form-control" id="post-status" name="status">
          <option value="pending" <?= $post['status'] === 'pending' ? 'selected' : '' ?>>Pending for Review</option>
          <option value="publish" <?= $post['status'] === 'publish' ? 'selected' : '' ?>>Publish</option>
        </select>
      </div>
      <div class="text-end">
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>

  <div class="text-center">
    <a href="/manage-posts" class="btn btn-link btn-sm">
      <i class="bi bi-arrow-left"></i> Back to Posts
    </a>
  </div>
</div>
<?php require "parts/footer.php"; 
