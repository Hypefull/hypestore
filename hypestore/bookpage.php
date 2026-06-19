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
        footer img:hover{
            transform: scale(110%);
        }
        .card{
            border:none;
            border-radius:20px;
        }
        .book-cover{
            width:100%;
            border-radius:15px;
            object-fit:cover;
        }
        .btn{
            border-radius:10px;
        }
        .badge{
            font-size:0.9rem;
            padding:8px 12px;
        }
        .star{
            font-size:40px;
            color:gold;
            cursor:pointer;
            transition:0.2s;
        }
        .star:hover{
            color:gold;
        }
        .related-book img{
            height:220px;
            object-fit:cover;
        }
        .card-book:hover{
            transform: translateY(-6px);
            transform: scale(103%);
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
                        <a class="nav-link" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Books</a>
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
        <a href="books.php" class="btn btn-outline-secondary mb-4">Back</a>
        <div class="card shadow-sm mb-5">
            <div class="card-body p-5">
                <div class="row">
                    <div class="col-lg-4">
                        <img src="uploads/theintelligentinvestor.jpg" class="book-cover">
                    </div>
                    <div class="col-lg-8">
                        <span class="badge bg-success mb-3">Economics</span>
                        <h1 class="fw-bold">The Intelligent Investor</h1>
                        <h5 class="text-muted mb-3">Benjamin Graham</h5>
                        <p class="fs-5 text-warning">⭐4.8/5</p>
                        <h2 class="text-primary fw-bold">Rp250.000</h2>
                        <p class="mt-3"><strong>Stock:</strong> 67 Books Available</p>
                        <hr>
                        <h5>Description</h5>
                        <p class="text-secondary">
                            The Intelligent Investor by Benjamin Graham, first published in 1949, is a widely acclaimed book on value investing. The book provides strategies on how to successfully use value investing in the stock market. Historically, the book has been one of the most popular books on investing and Graham's legacy remains.
                        </p>
                        <div class="row mt-4">
                            <div class="col-lg-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control" value="1" min="1">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-primary btn-lg me-2">🛒Add to Cart</button>
                            <button class="btn btn-outline-secondary btn-lg">Buy Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm mb-5">
            <div class="card-body text-center p-4">
                <h3>Rate this Book</h3>
                <p class="text-muted">Click a star to rate this book.</p>
                <div class="mb-4">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                </div>
                <button class="btn btn-primary">Submit Rating</button>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>More Programming Books</h3>
            <a href="#" class="text-decoration-none">View All</a>
        </div>
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm card-book h-100">
                    <img src="https://picsum.photos/300/400?1" class="card-img-top">
                    <div class="card-body">
                        <span class="badge bg-primary mb-2">
                            Informatics
                        </span>
                        <h5>Refactoring</h5>
                        <p class="text-muted mb-1">
                            Martin Fowler
                        </p>
                        <p class="text-warning mb-2">⭐ 4.7</p>
                        <h5 class="text-primary fw-bold mb-3">
                            Rp145.000
                        </h5>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <button class="btn btn-light w-100">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm card-book h-100">
                    <img src="https://picsum.photos/300/400?2" class="card-img-top">
                    <div class="card-body">
                        <span class="badge bg-primary mb-2">
                            Informatics
                        </span>
                        <h5>Design Patterns</h5>
                        <p class="text-muted mb-1">
                            GoF
                        </p>
                        <p class="text-warning mb-2">⭐ 4.9</p>
                        <h5 class="text-primary fw-bold mb-3">
                            Rp175.000
                        </h5>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <button class="btn btn-light w-100">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm card-book h-100">
                    <img src="https://picsum.photos/300/400?3" class="card-img-top">
                    <div class="card-body">
                        <span class="badge bg-primary mb-2">
                            Informatics
                        </span>
                        <h5>Algorithms</h5>
                        <p class="text-muted mb-1">
                            Robert Sedgewick
                        </p>
                        <p class="text-warning mb-2">⭐ 4.6</p>
                        <h5 class="text-primary fw-bold mb-3">
                            Rp130.000
                        </h5>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <button class="btn btn-light w-100">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm card-book h-100">
                    <img src="https://picsum.photos/300/400?4" class="card-img-top">
                    <div class="card-body">
                        <span class="badge bg-primary mb-2">
                            Informatics
                        </span>
                        <h5>The Pragmatic Programmer</h5>
                        <p class="text-muted mb-1">
                            Andrew Hunt
                        </p>
                        <p class="text-warning mb-2">⭐ 4.9</p>
                        <h5 class="text-primary fw-bold mb-3">
                            Rp165.000
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