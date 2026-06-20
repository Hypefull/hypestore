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

    $id = $_GET['id'];
    $selectedquery = "SELECT books.*, categories.name AS category_name, categories.color AS category_color FROM books JOIN categories ON books.id_category = categories.id WHERE books.id = '$id'";
    $result = $connection->conn->query($selectedquery);
    $row = $result->fetch_assoc();
    if($row['rating'] == NULL){
        $ratingbook = "No ratings";
    }
    else{
        $ratingbook = number_format($row['rating'],1);
    }

    $relatedquery = "SELECT * FROM books WHERE id_category = '".$row['id_category']."' AND id != '$id' LIMIT 4";
    $relatedresult = $connection->conn->query($relatedquery);

    $myrating = 0;

    if(isset($_SESSION['id'])){
        $userid = $_SESSION['id'];
        $ratingquery = "SELECT rating FROM ratings WHERE id_user='$userid' AND id_book='$id'";
        $ratingresult = $connection->conn->query($ratingquery);
        if($ratingresult->num_rows > 0){
            $myrating = $ratingresult->fetch_assoc()['rating'];
        }
    }

    if(!isset($_GET['id'])){
        header("location: books.php");
        exit();
    }

    if($result->num_rows == 0){
        header("location: books.php");
        exit();
    }

    if(isset($_POST['submitrating'])){
        if(!isset($_SESSION['id'])){
            echo "<script>
                alert('Please login first.');
                window.location='login.php';
            </script>";
            exit();
        }   
        $userid = $_SESSION['id'];
        $bookid = $_GET['id'];
        $rating = $_POST['rating'];
        $check = "SELECT * FROM ratings WHERE id_user='$userid' AND id_book='$bookid'";
        $resultcheck = $connection->conn->query($check);
        if($resultcheck->num_rows > 0){
            $update = "UPDATE ratings SET rating='$rating' WHERE id_user='$userid' AND id_book='$bookid'";
            $connection->conn->query($update);
        }
        else{
            $insert = "INSERT INTO ratings (id_user, id_book, rating) VALUES('$userid','$bookid','$rating')";
            $connection->conn->query($insert);
        }
        $average = "SELECT AVG(rating) AS avg_rating FROM ratings WHERE id_book='$bookid'";
        $resultavg = $connection->conn->query($average);
        $rowavg = $resultavg->fetch_assoc();
        $updatebook = "UPDATE books SET rating='".$rowavg['avg_rating']."' WHERE id='$bookid'";
        $connection->conn->query($updatebook);
        header("Location: bookdetails.php?id=".$bookid);
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['title'];?></title>
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
        .rating{
            display:inline-flex;
            flex-direction:row-reverse;
        }
        .rating input{
            display:none;
        }
        .rating label{
            font-size:45px;
            color:#ddd;
            cursor:pointer;
            transition:.2s;
            margin:0 2px;
        }
        .rating label:hover, .rating label:hover ~ label{
            color:gold;
            transform:scale(1.1);
        }
        .rating input:checked ~ label{
            color:gold;
        }
        .star:hover{
            color:gold;
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
                        <a class="nav-link active" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/books.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/orders.php">Orders</a>
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
                        <img src="uploads/<?php echo $row['cover'];?>" class="book-cover">
                    </div>
                    <div class="col-lg-8">
                        <span class="badge bg-<?php echo $row['category_color']; ?> mb-3"><?php echo $row['category_name']; ?></span>
                        <h1 class="fw-bold"><?php echo $row['title']; ?></h1>
                        <h5 class="text-muted mb-3"><?php echo $row['author']; ?></h5>
                        <p class="fs-5 text-warning">⭐<?php echo $ratingbook; ?> / 5</p>
                        <h2 class="text-primary fw-bold">Rp<?php echo number_format($row['price']); ?></h2>
                        <p class="mt-3"><strong>Stock: </strong><?php echo $row['stock']; ?> Books Available</p>
                        <hr>
                        <h5>Description</h5>
                        <p class="text-secondary">
                            <?php echo nl2br($row['description']); ?>
                        </p>
                        <div class="row mt-4">
                            <div class="col-lg-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control" value="1" min="1">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-primary btn-lg me-2">🛒Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm mb-5">
            <div class="card-body text-center p-4">
                <h3>Rate this Book</h3>
                <p class="text-muted">Click a star to rate this book.</p>
                <form method="POST">
                    <div class="mb-4">
                        <div class="rating">
                            <?php
                            for($i = 5; $i >= 1; $i--){
                                if($myrating == $i){
                                    $checked = "checked";
                                }
                                else{
                                    $checked = "";
                                }
                                echo '
                                    <input type="radio" id="star'.$i.'" name="rating" value="'.$i.'" '.$checked.'>
                                    <label for="star'.$i.'">★</label>
                                ';
                            }
                            ?>
                        </div>
                    </div>
                    <button class="btn btn-primary" name="submitrating">Submit Rating</button>
                </form>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>More <?php echo $row['category_name'];?> Books</h3>
            <a href="#" class="text-decoration-none">View All</a>
        </div>
        <div class="row g-4">
            <?php 
                while ($row2 = $relatedresult->fetch_assoc()){
                   if($row2['rating'] == NULL){
                        $rating = "No ratings";
                    }
                    else{
                        $rating = number_format($row2['rating'],1);
                    }
                    echo '
                        <div class="col-lg-3">
                            <div class="card border-0 shadow-sm card-book h-100">
                                <img src="uploads/'.$row2['cover'].'" class="card-img-top" style="height:300px; object-fit:contain;">
                                <div class="card-body">
                                    <span class="badge bg-'.$row['category_color'].' mb-2">
                                        '.$row['category_name'].'
                                    </span>
                                    <h5>'.$row2['title'].'</h5>
                                    <p class="text-muted mb-1">
                                        '.$row2['author'].'
                                    </p>
                                    <p class="text-warning mb-2">⭐'.$rating.' / 5</p>
                                    <h5 class="text-primary fw-bold mb-3">
                                        Rp'.number_format($row2['price']).'
                                    </h5>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <a href="bookdetails.php?id='.$row2['id'].'" class="btn btn-light w-100">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    ';
                }
            ?>
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