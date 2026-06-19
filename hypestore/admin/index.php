<?php
    session_start();
    require_once('../library/database.php');
    require_once('../library/koneksi.php');
    $connection = new Database($host, $user, $pass, $database);

    if(!isset($_SESSION['admin'])){
        header("location: login.php");
    }
    $totalbooksquery = "SELECT COUNT(*) AS total_books FROM books";
    $resultbooks = $connection->conn->query($totalbooksquery);
    $rowbooks = $resultbooks->fetch_assoc();

    $totalcategoriesquery = "SELECT COUNT(*) AS total_categories FROM categories";
    $resultcategories = $connection->conn->query($totalcategoriesquery);
    $rowcategories = $resultcategories->fetch_assoc();

    if(isset($_POST['signout'])){
        unset($_SESSION['admin']);
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
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .hero{
            color:white;
            border-radius:20px;
            padding:60px;
            min-height: 450px;
        }
        .card{
            border:none;
            border-radius:18px;
        }
        .btn{
            border-radius:10px;
        }
        .card:hover{
            transform: translateY(-6px);
            transform: scale(103%);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow sticky-top">
        <div class="container-fluid">
            <a href="#" class="navbar-brand fw-bold">HypeStore Admin</a>
            <button class="navbar-toggler"data-bs-toggle="collapse" data-bs-target="#navbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/admin"class="nav-link active" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/admin/books.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/admin/categories.php" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/admin/orders.php">Orders</a>
                    </li>
                </ul>
            </div>
            <span class="text-white me-3">
                <?php echo $_SESSION['admin']?>
            </span>
            <form method="POST">
                <button type="submit" name="signout" id="signout" class="btn btn-light">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container py-5">
        <section class="hero bg-primary shadow mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold">Admin Dashboard</h1>
                    <p class="lead mt-3 mb-4">Manage books, categories, and orders from one place.</p>
                        <a href="books.php" class="btn btn-light btn-lg me-2">View Books</a>
                </div>
                <div class="col-lg-6 text-center mt-5">
                    <img src="../assets/adminhero.png" class="img-fluid w-50">
                </div>
            </div>
        </section>
    
    <h2 class="mb-4">Dashboard Overview</h2>
    <div class="row g-4 mb-5">
        <div class="col-lg-4">
            <div class="card shadow-sm text-center p-4">
                <h1>📘</h1>
                <h5>Total Books</h5>
                <h2 class="fw-bold"><?php echo $rowbooks['total_books'];?></h2>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm text-center p-4">
                <h1>📁</h1>
                <h5>Total Categories</h5>
                <h2 class="fw-bold"><?php echo $rowcategories['total_categories'];?></h2>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm text-center p-4">
                <h1>📦</h1>
                <h5>Total Orders</h5>
                <h2 class="fw-bold">21</h2>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Quick Actions</h2>
    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card shadow-sm text-center p-5">
                <h1>📕</h1>
                <h4 class="mt-2">Add New Book</h4>
                <p class="text-muted">
                    Add a new book listing.
                </p>
                <a href="addbook.php" class="btn btn-primary">
                    Add Book
                </a>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm text-center p-5">
                <h1>📝</h1>
                <h4 class="mt-2">Add New Category</h4>
                <p class="text-muted">
                    Add a new book category.
                </p>
                <a href="addcategories.php" class="btn btn-primary">
                    Add Category
                </a>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Management</h2>
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm text-center p-4">
                <h1>📚</h1>
                <h4 class="mt-2">Manage Books</h4>
                <p class="text-muted">
                    View, edit, or delete books.
                </p>
                <a href="books.php" class="btn btn-outline-primary">Manage Books</a>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm text-center p-4">
                <h1>🗃️</h1>
                <h4 class="mt-2">Manage Categories</h4>
                <p class="text-muted">
                    View, edit, or delete categories.
                </p>
                <a href="categories.php" class="btn btn-outline-primary">Manage Categories</a>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm text-center p-4">
                <h1>🛒</h1>
                <h4 class="mt-2">Manage Orders</h4>
                <p class="text-muted">
                    View customer transactions.
                </p>
                <a href="orders.php" class="btn btn-outline-primary">View Orders</a>
            </div>
        </div>
    </div>
</div>
    <footer class="bg-tertiary shadow-sm border-top mt-5 py-4">
        <div class="container text-center text-muted">
            © 2026 HypeStore Admin. All rights reserved.
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>