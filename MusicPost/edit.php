<?php
require_once('../functions.php');
require_once('../db.php');

$auth = new Auth($db);

$auth->redirectIfNotAuthenticated('../signin.php');

if(!isset($_GET['index'])){
    echo '<h2>How did you get here? Get back to home! <a href="index.php" >Home</a></h2>';
    die();
}
$query = $db->prepare('SELECT * FROM posts NATURAL JOIN users WHERE post_ID=?');
$query->execute([$_GET['index']]);
$post=$query->fetch();
$genreQuery=$db->query(' SELECT * from genres ');

$userRoleQuery = $db->prepare('SELECT role FROM users WHERE user_ID = ?');
$userRoleQuery->execute([$_SESSION['user_id']]);
$userRole = $userRoleQuery->fetch();



if(!$userRole || $post['user_ID'] != $_SESSION['user_id'] && $userRole['role'] != 2){
    echo '<h2>This is not your post. Click here to return to <a href="index.php" >Home</a></h2>';
    die();

}

if (isset($_POST['update'])) {
    // Update the blog post data
    $update = $db -> prepare('UPDATE posts SET title=?, summary=?, date=CURRENT_TIMESTAMP, image_link=?, content=? WHERE post_ID=?');
    $update->execute([$_POST['title'],$_POST['summary'],$_POST['image'],$_POST['content'], $_GET['index']]);
    $genreUpdate = $db -> prepare('UPDATE post_r_genres SET genre_ID=?');
    $genreUpdate->execute([$_POST['genre']]);
    // Redirect or show a success message
    header("Location: index.php?message=Post Updated");
    exit();
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Post</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">GrooveNest</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="../signout.php">Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Edit post form -->
        <div class="container mt-5">
            <h1>Edit Post</h1>

            <?php if ($post) { ?>
                <form method="POST" class="mt-4">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= $post['title'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="summary" class="form-label">Summary</label>
                        <input type="text" class="form-control" id="summary" name="summary" value="<?= $post['summary'] ?>" required>
                    </div>
                    
                    <div class="mb-3">
                    <label for="genre" class="form-label">Genre:</label>
                        <select class="form-select" name="genre" required>
                            <?php while($genreID=$genreQuery->fetch()){?>
                                <option value="<?=$genreID['genre_ID']?>"><?=$genreID['genre']?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="text" class="form-control" id="image" name="image" value="<?= $post['image_link'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required><?= $post['content'] ?></textarea>
                    </div>
                    <button type="submit" name="update" class="btn btn-primary">Update Post</button>
                    <button type="button" class="btn btn-secondary">
                        <a style="text-decoration: none; color: white;" href="index.php">Return To Home</a>
                    </button>
                </form>
            <?php } else { ?>
                <div class="alert alert-danger">No post found to edit.</div>
            <?php } ?>
        </div>
        <br />
        <br />
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
