<?php

  $id = $_GET['id'] ?? "";

  // 1. connect to database
  $database = connectToDB();
  // 2. get all the users
    // 2.1
  $sql = "SELECT * FROM posts WHERE id = :id";
  // 2.2
  $query = $database->prepare( $sql );
  // 3.3 cook it
  $query->execute([
    "id" => $id
]);
  // 2.4
  $posts = $query->fetch();
?>
<?php require "parts/header.php"; ?>
    <div class="container mx-auto my-5" style="max-width: 500px;">
      <h1 class="h1 mb-4 text-center"><?php echo $posts['title'] ?></h1>
      <p><?php echo $posts['content']  ?></p>
      <div class="text-center mt-3">
        <a href="/" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back</a
        >
      </div>
    </div>

    <?php require "parts/footer.php"; ?>
