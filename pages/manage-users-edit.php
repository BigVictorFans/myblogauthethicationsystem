<?php

  // check if the user is not an admin
  if ( !isAdmin() ) {
    header("Location: /dashboard");
    exit;
  }

  // connect to database
  $database = connectToDB();

  // get the id from the URL /manage-users-edit?id=1
  $id = $_GET["id"];

  // load the user data by id
  // SQL
  $sql = "SELECT * FROM users WHERE id = :id";
  // prepare
  $query = $database->prepare( $sql );
  // execute
  $query->execute([
    "id" => $id
  ]);
  // fetch
  $user = $query->fetch(); // get only the first row of the match data

  /*
    name -> $user["name"]
    email -> $user["email"]
    role -> $user["role"]
  */
?>
<?php require "parts/header.php"; ?>

<div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Edit User</h1>
      </div>
      <div class="card mb-2 p-4">
        <form method="POST" action="/user/update">
          <div class="mb-3">
            <div class="row">
              <div class="col">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $user["name"]; ?>" />
              </div>
              <div class="col">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" value="<?php echo $user["email"]; ?>" disabled />
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role">
              <option value="">Select an option</option>
              <option value="user" <?php echo ( $user["role"] === "user" ? "selected" : "" ); ?>>User</option>
              <option value="editor" <?php echo ( $user["role"] === "editor" ? "selected" : "" ); ?>>Editor</option>
              <option value="admin" <?php echo ( $user["role"] === "admin" ? "selected" : "" ); ?>>Admin</option>
            </select>
          </div>
          <div class="d-grid">
            <input type="hidden" name="user_id" value="user_id" />
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
      <div class="text-center">
        <a href="/manage-users" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back to Users</a
        >
      </div>
    </div>

<?php require "parts/footer.php"; ?>