<?php

require "../../includes/functions.php";

// make sure the user is logged in
if (!isUserLoggedIn()) {
    header("Location: /login");
    exit;
}

// get data from POST
$id = $_POST["id"];
$title = $_POST["title"];
$content = $_POST["content"];
$status = $_POST["status"];

// validation
if (empty($title) || empty($content) || empty($status)) {
    $_SESSION["error"] = "All fields are required";
    header("Location: /manage-posts-edit?id=" . $id);
    exit;
}

// connect to DB
$database = connectToDB();

// get the post data
$sql = "SELECT * FROM posts WHERE id = :id";
$query = $database->prepare($sql);
$query->execute([
    'id' => $id
]);
$post = $query->fetch();

// make sure post exists
if (!$post) {
    $_SESSION["error"] = "Post not found";
    header("Location: /manage-posts");
    exit;
}

// make sure the post belongs to the current user or user is admin
if ($post["user_id"] !== $_SESSION["user"]["id"] && !isAdmin()) {
    $_SESSION["error"] = "Access denied";
    header("Location: /manage-posts");
    exit;
}

// update the post
$sql = "UPDATE posts SET title = :title, content = :content, status = :status WHERE id = :id";
$query = $database->prepare($sql);
$query->execute([
    'title' => $title,
    'content' => $content,
    'status' => $status,
    'id' => $id
]);

// set success message
$_SESSION["success"] = "Post has been updated";

// redirect back to manage posts page
header("Location: /manage-posts");
exit;
