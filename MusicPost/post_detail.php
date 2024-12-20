<?php
require_once('../functions.php');
require_once('../db.php');

$query=$db->prepare('SELECT * FROM posts natural join users WHERE post_ID=?');
$query->execute([$_GET['index']]);
$post=$query->fetch();

$userRoleQuery = $db->prepare('SELECT role FROM users WHERE user_ID = ?');
$userRoleQuery->execute([$_SESSION['user_id']]);
$userRole = $userRoleQuery->fetch();

$auth = new Auth($db);

$auth->redirectIfNotAuthenticated('../signin.php');

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?=$post['title'].' by '.$post['firstname'].' '.$post['lastname']?></title>
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

        <!-- Blog post content-->
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <!-- Blog post card-->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h1 class="card-title"><?=$post['title']?></h1>
                            <h5 class="card-subtitle text-muted"><?='by: '.$post['firstname'].' '.$post['lastname']?></h5>
                            <p class="small text-muted"><?='Posted on: '.$post['date']?></p>
                            <p class="card-text"><?=$post['content']?></p>
                            <button type="button" class="btn btn-secondary">
                                <a style="text-decoration: none; color: white;" href="index.php">Return To Home</a>
                            </button>
                            <?php if($_SESSION['user_id'] == $post['user_ID'] || $userRole == 2){?>
                                <button type="button" class="btn btn-secondary"><a style="text-decoration: none; color: white;" href="edit.php?index=<?=$post['post_ID']?>">Edit Post</a></button>
                                <button type="button" class="btn btn-secondary"><a style="text-decoration: none; color: white;" href="delete.php?index=<?=$post['post_ID']?>">Delete Post</a></button>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
