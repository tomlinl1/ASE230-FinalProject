<?php
require_once('../functions.php');
require_once('../db.php');

$auth = new Auth;

$auth->redirectIfNotAuthenticated('../signin.php');

$genreQuery=$db->query(' SELECT * from genres '); // Set up query for form drop down menu.

if(count($_POST)>0){
	$query=$db->prepare('
	INSERT INTO posts(title,summary,content,image_link,user_ID,date) 
				VALUES(?,?,?,?,?,CURRENT_TIMESTAMP)');
	$query->execute([$_POST['title'],$_POST['summary'],$_POST['content'],$_POST['image'],$_SESSION['user_id']]); // Create post
    $currentPostID = $db->lastInsertID(); // Get the newly created post_ID
    $query=$db->prepare('
	INSERT INTO post_r_genres(post_ID,genre_ID) 
				VALUES(?,?)');
	$query->execute([$currentPostID,$_POST['genre']]); // Insert the genre_ID and post_ID in the post_r_genres table
    header("Location: index.php"); // return user back to index after completion
    exit(); // ensures the page doesn't reload.
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>GrooveNest - Music Content Blog</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">GrooveNest</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="../signout.php">Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page header with logo and tagline-->
        <header class="py-5 bg-light border-bottom mb-4">
            <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">Welcome to GrooveNest!</h1>
                    <p class="lead mb-0">Create your post here!</p>
                    <p>Today's Date: <?php echo date('m-d-Y'); ?></p>
                </div>
            </div>
        </header>
        <!-- Page content-->
        <div class="container">
            <div class="row justify-content-center">
                <!-- Blog entries-->
                <div class="col-lg-8">
                    <!-- Featured blog post-->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h2 class="card-title">Create Your Post</h2>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Post Title:</label>
                                    <input type="text" class="form-control" name="title" required><br />
                                    <label for="title" class="form-label">Summary:</label>
                                    <input type="text" class="form-control" name="summary" required><br />
                                    <label for="genre" class="form-label">Genre:</label>
                                    <select class="form-select" name="genre" required>
                                        <?php while($genreID=$genreQuery->fetch()){?>
                                        <option value="<?=$genreID['genre_ID']?>"><?=$genreID['genre']?></option>
                                        <?php }?>
                                        </select>
                                        <br />
                                    <label for="Image Upload" class="form-label">Image (URL):</label>
                                    <input type="text" class="form-control" name="image" required><br />
                                    <label for="content" class="form-label">Content:</label>
                                    <input type="text" class="form-control" name="content" required><br />
                                    <input type="submit" value="Submit">



                                </div>
                            </form>
                        </div>

                    </div>
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
