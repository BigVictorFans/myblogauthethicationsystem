<?php

if (!isUserLoggedIn()) {
  header("Location: /dashboard");
  exit;
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $title = trim($_POST["title"]);
  $content = trim($_POST["content"]);
  $userId = $_SESSION['user']['id'];

  if (empty($title) || empty($content)) {
    $error = "Please fill in all fields.";
  } else {
    $database = connectToDB();
    $sql = "INSERT INTO posts (title, content, status, user_id) VALUES (:title, :content, 'pending', :user_id)";
    $query = $database->prepare($sql);
    $result = $query->execute([
      'title' => $title,
      'content' => $content,
      'user_id' => $userId
    ]);

    if ($result) {
      header("Location: /manage-posts");
      exit;
    } else {
      $error = "Something went wrong. Please try again.";
    }
  }
}
?>


<?php require "parts/header.php"; ?>

<div class="container mx-auto my-5" style="max-width: 700px;">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <h1 class="h1">Add New Post</h1>
  </div>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php endif; ?>

  <div class="card mb-2 p-4">
    <form method="POST">
      <div class="mb-3">
        <label for="post-title" class="form-label">Title</label>
        <input type="text" class="form-control" id="post-title" name="title" />
      </div>
      <div class="mb-3">
        <label for="post-content" class="form-label">Content</label>
        <textarea
          class="form-control"
          id="post-content"
          name="content"
          rows="10"
        ></textarea>
      </div>
      <div class="text-end">
        <button type="submit" class="btn btn-primary">Add</button>
      </div>
    </form>
  </div>

  <div class="text-center">
    <a href="/manage-posts" class="btn btn-link btn-sm">
      <i class="bi bi-arrow-left"></i> Back to Posts
    </a>
  </div>
</div>

<?php require "parts/footer.php"; ?>