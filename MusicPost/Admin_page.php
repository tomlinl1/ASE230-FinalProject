<?php

require_once('../functions.php');
require_once('../db.php');

$auth = new Auth;
$auth->redirectIfNotAuthenticated('../signin.php');

$userProfile = $db->prepare('SELECT role FROM users WHERE user_ID=?');
$userProfile->execute([$_SESSION['user_id']]);
$user = $userProfile->fetch();

if (isset($_GET['delete_id'])) {
    $deleteQuery = $db->prepare('DELETE FROM posts WHERE post_ID = ?');
    $deleteQuery->execute([$_GET['delete_id']]);
    header('Location: admin_area.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $summary = $_POST['summary'];
    $image_link = $_POST['image_link'];
    $genre = $_POST['genre'];

    $createQuery = $db->prepare('INSERT INTO posts (title, summary, image_link, genre) VALUES (?, ?, ?, ?)');
    $createQuery->execute([$title, $summary, $image_link, $genre]);
    header('Location: admin_area.php');
    exit();
}

$query = $db->prepare('SELECT * FROM posts ORDER BY date DESC');
$query->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>GrooveNest - Admin Area</title>
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <link href="../css/styles.css" rel="stylesheet" />
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">GrooveNest</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="../signout.php">Sign Out</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h1 class="my-5 text-center">Admin Dashboard</h1>

    <h2>Create New Post</h2>
        <button type="button" class="btn btn-secondary"><a style="text-decoration: none; color: white;" href="create.php?index=<?=$post['post_ID']?>">Create Post</a></button>
    </form>

    <hr>

    <h2>All Posts</h2>
    <?php while ($post = $query->fetch()) { ?>
        <div class="card mb-4">
            <img class="card-img-top" src="<?=$post['image_link']?>" alt="..." width="200" height="500"/>
            <div class="card-body">
                <div class="small text-muted"><?= $post['date'] ?></div>
                <h2 class="card-title h4"><?= $post['title'] ?></h2>
                <p class="card-text"><?= $post['summary'] ?></p>
                <a class="btn btn-primary" href="post_detail.php?index=<?= $post['post_ID'] ?>">Read more →</a>
                <button type="button" class="btn btn-secondary"><a style="text-decoration: none; color: white;" href="edit.php?index=<?=$post['post_ID']?>">Edit Post</a></button>
                <button type="button" class="btn btn-secondary"><a style="text-decoration: none; color: white;" href="delete.php?index=<?=$post['post_ID']?>">Delete Post</a></button>
            </div>
        </div>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


