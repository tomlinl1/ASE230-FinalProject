<?php
require_once('../functions.php');

$auth = new Auth;

$auth->redirectIfNotAuthenticated('../signin.php');

if(!isset($_GET['index'])){
    echo '<h2>How the hell did you get here? Get back to home you goober! <a href="index.php" >Home</a></h2>';
    die();
}
$i = $_GET['index'];
$string = file_get_contents('../posts.json');
$php_array = json_decode($string, true);
$blogs = $php_array;
if($blogs[$i]['user_id'] != $_SESSION['user_id']){
    echo '<h2>This is not your post. Click here to return to <a href="index.php" >Home</a></h2>';
    die();
}

if (isset($_POST['update'])) {
    // Update the blog post data
    $blogs[$i]['title'] = $_POST['title'];
    $blogs[$i]['summary'] = $_POST['summary'];
    $blogs[$i]['author'] = $_POST['author'];
    $blogs[$i]['date'] = $_POST['date'];
    $blogs[$i]['genre'] = $_POST['genre'];
    $blogs[$i]['image'] = $_POST['image'];
    $blogs[$i]['content'] = $_POST['content'];

    // Save the updated blogs array back to the JSON file
    file_put_contents('../posts.json', json_encode($blogs, JSON_PRETTY_PRINT));

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

            <?php if ($blogs) { ?>
                <form method="POST" class="mt-4">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= $blogs[$i]['title'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="summary" class="form-label">Summary</label>
                        <input type="text" class="form-control" id="summary" name="summary" value="<?= $blogs[$i]['summary'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" class="form-control" id="author" name="author" value="<?= $blogs[$i]['author'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?= $blogs[$i]['date'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="genre" class="form-label">Genre</label>
                        <input type="text" class="form-control" id="genre" name="genre" value="<?= $blogs[$i]['genre'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="text" class="form-control" id="image" name="image" value="<?= $blogs[$i]['image'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required><?= $blogs[$i]['content'] ?></textarea>
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
