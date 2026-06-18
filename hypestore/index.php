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
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Orders</a>
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
                        <button class="btn btn-light btn-lg me-2">
                            Browse Books
                        </button>
                </div>
                <div class="col-lg-6 text-center mt-5">
                    <img src="assets/heroimage2.png" class="img-fluid w-50">
                </div>
            </div>
        </section>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Popular Categories</h2>
            <a href="#" class="text-decoration-none">View All</a>
        </div>
        <div class="row g-3 mb-5">
            <div class="col-lg-2">
                <div class="card category-card text-center shadow-sm border-0 p-3">
                    <h1>💻</h1>
                    <h6>Informatics</h6>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="card category-card text-center shadow-sm border-0 p-3">
                    <h1>💵</h1>
                    <h6>Economics</h6>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="card category-card text-center shadow-sm border-0 p-3">
                    <h1>👤</h1>
                    <h6>Biography</h6>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="card category-card text-center shadow-sm border-0 p-3">
                    <h1>✨</h1>
                    <h6>Comics</h6>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="card category-card text-center shadow-sm border-0 p-3">
                    <h1>🧠</h1>
                    <h6>Self-Help</h6>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="card category-card text-center shadow-sm border-0 p-3">
                    <h1>📖</h1>
                    <h6>Novels</h6>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Highest Rated Books</h2>
            <a href="#" class="text-decoration-none">View All</a>
        </div>
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm card-book h-100">
                    <img src="assets/placeholder.jpg" width: 300 height: 400 class="card-img-top">
                    <div class="card-body">
                        <span class="badge bg-info mb-2">
                            Informatics
                        </span>
                        <h5>Clean Code</h5>
                        <p class="text-muted">
                            Robert C. Martin
                        </p>
                        <p class="text-warning">
                            ★★★★★
                        </p>
                        <h5 class="text-black">
                            Rp120.000
                        </h5>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <button class="btn btn-light w-100">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Featured Books</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm card-book h-100">
                    <img src="assets/placeholder.jpg" width: 300 height: 400 class="card-img-top">
                    <div class="card-body">
                        <span class="badge bg-info mb-2">
                            Informatics
                        </span>
                        <h5>Clean Code</h5>
                        <p class="text-muted">
                            Robert C. Martin
                        </p>
                        <p class="text-warning">
                            ★★★★★
                        </p>
                        <h5 class="text-black">
                            Rp120.000
                        </h5>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <button class="btn btn-light w-100">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>New Arrivals</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm card-book h-100">
                    <img src="assets/placeholder.jpg" width: 300 height: 400 class="card-img-top">
                    <div class="card-body">
                        <span class="badge bg-info mb-2">
                            Informatics
                        </span>
                        <h5>Clean Code</h5>
                        <p class="text-muted">
                            Robert C. Martin
                        </p>
                        <p class="text-warning">
                            ★★★★★
                        </p>
                        <h5 class="text-black">
                            Rp120.000
                        </h5>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <button class="btn btn-light w-100">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
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