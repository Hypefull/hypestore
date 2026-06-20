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

    $category = $_GET['category'] ?? '';
    $sortby = $_GET['sortby'] ?? '';
    $search = $_GET['search'] ?? '';
    $shownumber = $_GET['shownumber'] ?? 12;
    $stock = $_GET['stock'] ?? '';
    $page = $_GET['page'] ?? 1;
    $offset = ($page-1) * $shownumber;
    $prev = $page - 1;
    $next = $page + 1;

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .hero{
            color:white;
            border-radius:20px;
            padding:50px;
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
        footer img:hover{
            transform: scale(110%);
        }
        .filter-card{
            border-radius:18px;
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
        <section class="hero bg-primary shadow mb-5">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="display-5 fw-bold">Browse Books</h1>
                    <p class="lead mt-3">Discover hundreds of books across different genres.</p>
                </div>
                <div class="col-lg-5 text-center">
                    <img src="assets/bookshero.png" class="img-fluid w-50">
                </div>
            </div>
        </section>

        <div class="card filter-card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-4">
                            <input type="text" name="search" id="search" class="form-control" value="<?php echo htmlspecialchars($search);?>" placeholder="Search by title or author...">
                        </div>
                        <div class="col-lg-2">
                            <select name="category" id="category" class="form-select">
                                <option value="default" selected hidden>Select Category</option>
                                <?php 
                                    $sql = "SELECT * from categories";
                                    $result = $connection->conn->query($sql);
                                    while($row = $result->fetch_assoc()){
                                        $selectedcategory = "";
                                        if($category == $row['id']){
                                            $selectedcategory = "selected";
                                        }
                                        echo'<option value="'.$row['id'].'" '.$selectedcategory.'>'.$row['name'].'</option>';
                                        }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <select name="sortby" id="sortby" class="form-select">
                                <option value="default" selected hidden>Select Filter</option>
                                <option value="highrating" <?php if($sortby=="highrating") echo "selected";?>>Highest Rated</option>
                                <option value="lowrating" <?php if($sortby=="lowrating") echo "selected";?>>Lowest Rated</option>
                                <option value="newest" <?php if($sortby=="newest") echo "selected";?>>Newest</option>
                                <option value="oldest" <?php if($sortby=="oldest") echo "selected";?>>Oldest</option>
                                <option value="lowprice" <?php if($sortby=="lowprice") echo "selected";?>>Lowest Price</option>
                                <option value="highprice" <?php if($sortby=="highprice") echo "selected";?>>Highest Price</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <select name="shownumber" id="shownumber" class="form-select">
                                <option value="12" <?php if($shownumber==12) echo "selected";?>>12 / Page</option>
                                <option value="24" <?php if($shownumber==24) echo "selected";?>>24 / Page</option>
                                <option value="36" <?php if($shownumber==36) echo "selected";?>>36 / Page</option>
                            </select>
                        </div>
                        <div class="col-lg-1 d-grid">
                            <button class="btn btn-primary">Apply</button>
                        </div>
                    </div>
                    <div class="form-check mt-3">
                        <input name="stock" id="stock" class="form-check-input" type="checkbox" value="1" <?php if($stock=="1") echo "checked";?>>
                        <label class="form-check-label">In Stock Only</label>
                    </div>
                </form>
            </div>
        </div>
    <div class="d-flex justify-content-between mb-4">
        <?php
            $displaysql = "SELECT books.*, categories.name as category_name, categories.color as category_color from BOOKS LEFT JOIN categories ON books.id_category=categories.id where 1=1";
            if (!empty($search)) {
                $search = $connection->conn->real_escape_string($search);
                $displaysql .= " AND (books.title LIKE '%$search%' OR books.author LIKE '%$search%')";
            }
            if ($category != "" && $category !== 'default') {
                $displaysql .= " AND books.id_category = $category";
            }
            if($stock=="1"){
                $displaysql .= " AND books.stock > 0";
            }
            if($sortby=="highrating"){
                $displaysql .= " ORDER BY books.rating DESC";
            }
            else if($sortby=="lowrating"){
                $displaysql .= " ORDER BY books.rating ASC";
            }
            else if($sortby=="highprice"){
                $displaysql .= " ORDER BY books.price DESC";
            }
            else if($sortby=="lowprice"){
                $displaysql .= " ORDER BY books.price ASC";
            }
            else if($sortby=="newest"){
                $displaysql .= " ORDER BY books.id DESC";
            }
            else if($sortby=="oldest"){
                $displaysql .= " ORDER BY books.id ASC";
            }
            else{
                $displaysql .= " ORDER BY RAND()";
            }
            $countsql = str_replace("SELECT books.*, categories.name as category_name, categories.color as category_color", "SELECT COUNT(*) AS total", $displaysql);
            $countresult = $connection->conn->query($countsql);
            $totalbooks = $countresult->fetch_assoc()['total'];
            $totalpages = ceil($totalbooks/$shownumber);
            $displaysql .= " LIMIT $offset,$shownumber";
            $result = $connection->conn->query($displaysql);

            $start = $offset + 1;
            $end = $offset + $shownumber;
            if($end > $totalbooks){
                $end = $totalbooks;
            }
            ?>

        <h5>Showing <?php echo $start;?>-<?php echo $end;?> of <?php echo $totalbooks; ?> books</h5>
    </div>
    <div class="row g-4">
        <?php
            while($row = $result->fetch_assoc()){
                if($row['rating'] == NULL){
                    $rating = "No ratings";
                }
                else{
                    $rating = number_format($row['rating'],1);
                }
                echo '
                    <div class="col-lg-3">
                        <div class="card border-0 shadow-sm card-book h-100">
                            <img src="uploads/'.$row['cover'].'" class="card-img-top" style="height:300px; object-fit:contain;">
                            <div class="card-body">
                                <span class="badge bg-'.$row['category_color'].' mb-2">
                                    '.$row['category_name'].'
                                </span>
                                <h5>'.$row['title'].'</h5>
                                <p class="text-muted mb-1">
                                    '.$row['author'].'
                                </p>
                                <p class="text-warning mb-2">⭐'.$rating.' / 5</p>
                                <h5 class="text-primary fw-bold mb-3">
                                    Rp'.number_format($row['price']).'
                                </h5>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <a href="bookdetails.php?id='.$row['id'].'" class="btn btn-light w-100">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    ';
            }
        ?>
    </div>
    <nav class="mt-5">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php if($page==1) echo 'disabled';?>" >
                <a class="page-link" href="?page=<?php echo $prev; ?>&search=<?php echo $search; ?>&category=<?php echo $category; ?>&sortby=<?php echo $sortby; ?>&shownumber=<?php echo $shownumber; ?>&stock=<?php echo $stock; ?>">Previous</a>
            </li>
                <?php
                    for($i=1;$i<=$totalpages;$i++){
                        $active = "";
                        if ($page == $i){
                        $active = "active";
                        }

                    echo "
                    <li class='page-item $active'>
                    <a class='page-link' href='?page=$i&search=$search&category=$category&sortby=$sortby&shownumber=$shownumber&stock=$stock'>$i</a>
                    </li>
                    ";
                }
                ?>
            <li class="page-item <?php if($page==$totalpages) echo 'disabled';?>">
                <a class="page-link" href="?page=<?php echo $next; ?>&search=<?php echo $search; ?>&category=<?php echo $category; ?>&sortby=<?php echo $sortby; ?>&shownumber=<?php echo $shownumber; ?>&stock=<?php echo $stock; ?>">Next</a>
            </li>
        </ul>
    </nav>
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
