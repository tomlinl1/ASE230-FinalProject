<?php

require_once('../functions.php');
require_once('../db.php');

$auth = new Auth;
$auth->redirectIfNotAuthenticated('../signin.php');

$userProfile = $db->prepare('SELECT role FROM users WHERE user_ID=?');
$userProfile->execute([$_SESSION['user_id']]);
$user = $userProfile->fetch();


$query = $db->prepare('SELECT * FROM posts NATURAL JOIN (post_r_genres NATURAL JOIN genres) ORDER BY date DESC');
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

    <h2>Click here to create a new post:</h2>
        <button type="button" class="btn btn-secondary"><a style="text-decoration: none; color: white;" href="create.php">Make a Post</a></button>

    <hr>
    


    <h2>All Posts</h2>
    <div class="container">
            <div class="row justify-content-center">
                <!-- Blog entries-->
                <div class="col-lg-8">
                    <!-- Featured blog post-->
                    <?php while($post=$query->fetch()){?>
                            <div class="card mb-4">
                                <img class="card-img-top" src="<?=$post['image_link']?>" alt="..." width="200" height="500"/>
                                <div class="card-body">
                                    <div class="small text-muted"><?=$post['date']?></div>
                                    <h2 class="card-title h4"><?=$post['title']?></h2>
                                    <h4 class="card-title h4">Genre: <?=$post['genre']?></h4>
                                    <p class="card-text"><?=$post['summary']?></p>
                                    <a class="btn btn-primary" href="post_detail.php?index=<?=$post['post_ID']?>">Read more →</a>
                                    <button type="button" class="btn btn-secondary"><a style="text-decoration: none; color: white;" href="edit.php?index=<?=$post['post_ID']?>">Edit Post</a></button>
                                    <button type="button" class="btn btn-secondary"><a style="text-decoration: none; color: white;" href="delete.php?index=<?=$post['post_ID']?>">Delete Post</a></button>
                                </div>
                            </div>
                            <?php } ?>
                    <!-- Nested row for non-featured blog posts
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            Blog post
                            <div class="card mb-4">
                                <a href="#!"><img class="card-img-top" src="https://dummyimage.com/700x350/dee2e6/6c757d.jpg" alt="..." /></a>
                                <div class="card-body">
                                    <div class="small text-muted">January 1, 2023</div>
                                    <h2 class="card-title h4">Post Title</h2>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla.</p>
                                    <a class="btn btn-primary" href="#!">Read more →</a>
                                </div>
                            </div>
                            Blog post
                            <div class="card mb-4">
                                <a href="#!"><img class="card-img-top" src="https://dummyimage.com/700x350/dee2e6/6c757d.jpg" alt="..." /></a>
                                <div class="card-body">
                                    <div class="small text-muted">January 1, 2023</div>
                                    <h2 class="card-title h4">Post Title</h2>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla.</p>
                                    <a class="btn btn-primary" href="#!">Read more →</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            Blog post
                            <div class="card mb-4">
                                <a href="#!"><img class="card-img-top" src="https://dummyimage.com/700x350/dee2e6/6c757d.jpg" alt="..." /></a>
                                <div class="card-body">
                                    <div class="small text-muted">January 1, 2023</div>
                                    <h2 class="card-title h4">Post Title</h2>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla.</p>
                                    <a class="btn btn-primary" href="#!">Read more →</a>
                                </div>
                            </div>
                            Blog post
                            <div class="card mb-4">
                                <a href="#!"><img class="card-img-top" src="https://dummyimage.com/700x350/dee2e6/6c757d.jpg" alt="..." /></a>
                                <div class="card-body">
                                    <div class="small text-muted">January 1, 2023</div>
                                    <h2 class="card-title h4">Post Title</h2>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam.</p>
                                    <a class="btn btn-primary" href="#!">Read more →</a>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <!-- Pagination--
                    <nav aria-label="Pagination" class="d-flex justify-content-center">
                        <hr class="my-0" />
                        <ul class="pagination justify-content-center my-4">
                            <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Newer</a></li>
                            <li class="page-item active" aria-current="page"><a class="page-link" href="#!">1</a></li>
                            <li class="page-item"><a class="page-link" href="#!">2</a></li>
                            <li class="page-item"><a class="page-link" href="#!">3</a></li>
                            <li class="page-item disabled"><a class="page-link" href="#!">...</a></li>
                            <li class="page-item"><a class="page-link" href="#!">15</a></li>
                            <li class="page-item"><a class="page-link" href="#!">Older</a></li>
                        </ul>
                    </nav>-->
                </div>
                <!-- Side widgets
                <div class="col-lg-4">-->
                    <!-- Categories widget
                    <div class="card mb-4">
                        <div class="card-header">Categories</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <li><a href="#!">Web Design</a></li>
                                        <li><a href="#!">HTML</a></li>
                                        <li><a href="#!">Freebies</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <li><a href="#!">JavaScript</a></li>
                                        <li><a href="#!">CSS</a></li>
                                        <li><a href="#!">Tutorials</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <!-- Side widget
                    <div class="card mb-4">
                        <div class="card-header">Side Widget</div>
                        <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
                    </div>
                </div>-->
            </div>
        </div>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; GrooveNest 2024</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
</body>
</html>


