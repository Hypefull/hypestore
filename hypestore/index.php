<?php
    session_start();
    require_once('library/database.php');
    require_once('library/koneksi.php');
    $connection = new Database($host, $user, $pass, $database);
    $name = "";
    $auth = "";
    if(isset($_SESSION['name'])){
        $name = $_SESSION['name'];
        $auth = "Logout";
    } else{
        $auth = "Login";
    }

    if(isset($_POST['signout'])){
        unset($_SESSION['name']);
        unset($_SESSION['id']);
        session_destroy();
        header("location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HypeStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .hero{
            color:white;
            border-radius:20px;
            padding:60px;
            min-height: 450px;
        }
        .card-book:hover{
            transform: translateY(-6px);
            transform: scale(103%);
        }
        .card-book{
            height:300px;
            object-fit:cover;
        }
        .card-img-top{
            height:300px;
            object-fit:cover;
        }
        .category-card:hover{
            transform: scale(110%);
        }
        footer img:hover{
            transform: scale(110%);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow sticky-top">
        <div class="container-fluid">
            <a href="#" class="navbar-brand fw-bold">HypeStore</a>
            <button class="navbar-toggler"data-bs-toggle="collapse" data-bs-target="#navbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/books.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/orders.php">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/orderlist.php">Orders</a>
                    </li>
                </ul>
            </div>
            <span class="text-white me-3">
                <?php echo $name;?>
            </span>
            <form method="POST">
                <button type="submit" name="signout" id="signout" class="btn btn-light">
                    <?php echo $auth;?>
                </button>
            </form>
        </div>
    </nav>

    <div class="container py-5">
        <section class="hero bg-primary shadow mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold">Your Next</h1>
                    <h1 class="display-4 fw-bold">Chapter Awaits</h1>
                    <p class="lead mt-3 mb-4"> Great stories are waiting to be discovered. Your perfect book is just a click away.</p>
                        <a href="books.php" class="btn btn-light btn-lg me-2">Browse Books</a>
                </div>
                <div class="col-lg-6 text-center mt-5">
                    <img src="assets/heroimage2.png" class="img-fluid w-50">
                </div>
            </div>
        </section>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Popular Categories</h2>
        </div>
        <div class="row g-3 mb-5">
            <div class="col-lg-2">
                <a href="books.php?category=1" class="text-decoration-none text-dark">
                    <div class="card category-card text-center shadow-sm border-0 p-3">
                        <h1>💻</h1>
                        <h6>Informatics</h6>
                    </div>
                </a>
            </div>
            <div class="col-lg-2">
                <a href="books.php?category=4" class="text-decoration-none text-dark">
                    <div class="card category-card text-center shadow-sm border-0 p-3">
                        <h1>💵</h1>
                        <h6>Economics</h6>
                    </div>
                </a>
            </div>
            <div class="col-lg-2">
                <a href="books.php?category=7" class="text-decoration-none text-dark">
                    <div class="card category-card text-center shadow-sm border-0 p-3">
                        <h1>👤</h1>
                        <h6>Biography</h6>
                    </div>
                </a>
            </div>
            <div class="col-lg-2">
                <a href="books.php?category=8" class="text-decoration-none text-dark">
                    <div class="card category-card text-center shadow-sm border-0 p-3">
                        <h1>✨</h1>
                        <h6>Comics</h6>
                    </div>
                </a>
            </div>
            <div class="col-lg-2">
                <a href="books.php?category=9" class="text-decoration-none text-dark">
                    <div class="card category-card text-center shadow-sm border-0 p-3">
                        <h1>🧠</h1>
                        <h6>Self-Help</h6>
                    </div>
                </a>
            </div>
            <div class="col-lg-2">
                <a href="books.php?category=3" class="text-decoration-none text-dark">
                    <div class="card category-card text-center shadow-sm border-0 p-3">
                        <h1>📖</h1>
                        <h6>Novels</h6>
                    </div>
                </a>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Highest Rated Books</h2>
            <a href="books.php?sortby=highrating" class="text-decoration-none">View All</a>
        </div>
        <div class="row g-4">
            <?php 
                $highestquery = "SELECT books.*, categories.name AS category_name, categories.color AS category_color FROM books JOIN categories ON books.id_category = categories.id ORDER BY books.rating DESC LIMIT 4";
                $highestresult = $connection->conn->query($highestquery);
                while ($rowhighest = $highestresult->fetch_assoc()){
                    if($rowhighest['rating'] == NULL){
                        $ratinghighest = "No ratings";
                    }
                    else{
                        $ratinghighest = number_format($rowhighest['rating'],1);
                    }
                    echo '
                        <div class="col-lg-3">
                            <div class="card border-0 shadow-sm card-book h-100">
                                <img src="uploads/'.$rowhighest['cover'].'" class="card-img-top" style="height:300px; object-fit:contain;">
                                <div class="card-body">
                                    <span class="badge bg-'.$rowhighest['category_color'].' mb-2">
                                        '.$rowhighest['category_name'].'
                                    </span>
                                    <h5>'.$rowhighest['title'].'</h5>
                                    <p class="text-muted mb-1">
                                        '.$rowhighest['author'].'
                                    </p>
                                    <p class="text-warning mb-2">⭐'.$ratinghighest.' / 5</p>
                                    <h5 class="text-primary fw-bold mb-3">
                                        Rp'.number_format($rowhighest['price']).'
                                    </h5>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <a href="bookdetails.php?id='.$rowhighest['id'].'" class="btn btn-light w-100">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    ';
                }
            ?>
            
        </div>
        <br>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>New Arrivals</h2>
            <a href="books.php?sortby=newest" class="text-decoration-none">View All</a>
        </div>
        <div class="row g-4">
            <?php
                $newquery = "SELECT books.*, categories.name AS category_name, categories.color AS category_color FROM books JOIN categories ON books.id_category = categories.id ORDER BY books.id DESC LIMIT 4";
                $newresult = $connection->conn->query($newquery);
                while ($rownew = $newresult->fetch_assoc()){
                    if($rownew['rating'] == NULL){
                        $ratingnew = "No ratings";
                    }
                    else{
                        $ratingnew = number_format($rownew['rating'],1);
                    }
                    echo '
                        <div class="col-lg-3">
                            <div class="card border-0 shadow-sm card-book h-100">
                                <img src="uploads/'.$rownew['cover'].'" class="card-img-top" style="height:300px; object-fit:contain;">
                                <div class="card-body">
                                    <span class="badge bg-'.$rownew['category_color'].' mb-2">
                                        '.$rownew['category_name'].'
                                    </span>
                                    <h5>'.$rownew['title'].'</h5>
                                    <p class="text-muted mb-1">
                                        '.$rownew['author'].'
                                    </p>
                                    <p class="text-warning mb-2">⭐'.$ratingnew.' / 5</p>
                                    <h5 class="text-primary fw-bold mb-3">
                                        Rp'.number_format($rownew['price']).'
                                    </h5>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <a href="bookdetails.php?id='.$rownew['id'].'" class="btn btn-light w-100">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    ';
                }
            ?>
        </div>
        <br>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Featured Books</h2>
        </div>
        <div class="row g-4">
            <?php
                $featuredquery = "SELECT books.*, categories.name AS category_name, categories.color AS category_color FROM books JOIN categories ON books.id_category = categories.id ORDER BY RAND() LIMIT 4";
                $featuredresult = $connection->conn->query($featuredquery);
                while ($rowfeatured = $featuredresult->fetch_assoc()){
                    if($rowfeatured['rating'] == NULL){
                        $ratingfeatured = "No ratings";
                    }
                    else{
                        $ratingfeatured = number_format($rowfeatured['rating'],1);
                    }
                    echo '
                        <div class="col-lg-3">
                            <div class="card border-0 shadow-sm card-book h-100">
                                <img src="uploads/'.$rowfeatured['cover'].'" class="card-img-top" style="height:300px; object-fit:contain;">
                                <div class="card-body">
                                    <span class="badge bg-'.$rowfeatured['category_color'].' mb-2">
                                        '.$rowfeatured['category_name'].'
                                    </span>
                                    <h5>'.$rowfeatured['title'].'</h5>
                                    <p class="text-muted mb-1">
                                        '.$rowfeatured['author'].'
                                    </p>
                                    <p class="text-warning mb-2">⭐'.$ratingfeatured.' / 5</p>
                                    <h5 class="text-primary fw-bold mb-3">
                                        Rp'.number_format($rowfeatured['price']).'
                                    </h5>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <a href="bookdetails.php?id='.$rowfeatured['id'].'" class="btn btn-light w-100">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    ';
                }
            ?>
        </div>

        <div class="text-center my-5">
            <h2>ℹ️ About Us</h2>
            <p class="text-muted">Best service, best books, best prices.</p>
        </div>
        <section class="my-5">
            <div class="card hero bg-primary border-0 shadow mx-auto w-50">
                <div class="align-items-center">
                    <p class="text-white">
                       At HypeStore, we believe that every great journey begins with a great book. That's why we are dedicated to providing readers with a wide selection of books across various genres at affordable prices. Whether you're looking for bestselling novels, educational resources, timeless classics, or hidden literary gems, you'll find everything you need in one place.
                        We are committed to delivering the highest quality service and ensuring that every customer enjoys a seamless and satisfying shopping experience. Our goal is to make discovering and purchasing books simple, convenient, and enjoyable for readers of all ages. Whether you're building your personal library, searching for the perfect gift, or simply exploring new stories, HypeStore is here to help you find your next favorite book.
                        For the latest updates, promotions, and new arrivals, be sure to follow us on our social media platforms.
                    </p>
                </div>
            </div>
        </section>
</div>
    <footer class="bg-tertiary shadow-sm border-top mt-5 py-4">
    <div class="container text-center text-muted">
        © 2026 HypeStore. All rights reserved.
        <br>
        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="text-decoration-none text-muted"><img src="assets/youtube.png" width=30 height=30></a>
        <a href="https://www.instagram.com/charliekirk1776/?hl=en" class="text-decoration-none text-muted"><img src="assets/instagram.png" width=30 height=30></a>
        <a href="https://x.com/realDonaldTrump" class="text-decoration-none text-muted"><img src="assets/twitter.png" width=30 height=30></a>
    </div>
</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>