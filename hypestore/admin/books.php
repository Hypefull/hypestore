<?php
    session_start();
    require_once('../library/database.php');
    require_once('../library/koneksi.php');
    $connection = new Database($host, $user, $pass, $database);

    if(!isset($_SESSION['admin'])){
        header("location: login.php");
    }
    
    if(isset($_POST['signout'])){
        unset($_SESSION['admin']);
        unset($_SESSION['id']);
        session_destroy();
        header("location: login.php");
    }
   
    if(isset($_POST['delete'])){
        $id = $_POST['id'];
        $delete = "DELETE FROM books WHERE id = '$id'";
        $connection->conn->query($delete);
    }

    $category = $_GET['category'] ?? '';
    $sortby = $_GET['sortby'] ?? '';
    $search = $_GET['search'] ?? '';

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
            padding:30px;
            min-height: 150px;
        }
        .card{
            border:none;
            border-radius:18px;
        }
        .btn{
            border-radius:10px;
        }
        .table{
            vertical-align:middle;
        }
        .badge{
            font-size:0.9rem;
            padding:8px 12px;
        }
        .book-cover{
            width:60px;
            height:90px;
            object-fit:cover;
            border-radius:8px;
        }
        .rating{
            color:yellow;
            font-weight:bold;
        }
        .form-control{
            border-radius:10px;
        }
        .form-select{
            border-radius:10px;
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
                        <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/admin" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/admin/books.php" class="nav-link active">Books</a>
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
                <?php echo $_SESSION['admin'];?>
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
                <div class="col-lg-7">
                    <h1 class="fw-bold">Manage Books</h1>
                    <p class="lead mt-2">Add, view, edit, or delete books.</p>
                </div>
                <div class="col-lg-5 text-center mt-1">
                    <img src="../assets/managebooks.png" class="img-fluid w-50">
                </div>
            </div>
        </section>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-3">
                            <label for="category" class="form-label">Category</label>
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
                            <label for="sortby" class="form-label">Sort By</label>
                            <select name="sortby" id="sortby" class="form-select">
                                <option value="default" selected hidden>Select Filter</option>
                                <option value="highrating" <?php if($sortby=='highrating') echo 'selected'; ?>>Highest Rating</option>
                                <option value="lowrating" <?php if($sortby=='lowrating') echo 'selected'; ?>>Lowest Rating</option>
                                <option value="highprice" <?php if($sortby=='highprice') echo 'selected'; ?>>Highest Price</option>
                                <option value="lowprice" <?php if($sortby=='lowprice') echo 'selected'; ?>>Lowest Price</option>
                            </select>
                        </div>
                        <div class="col-lg-5">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" name="search" id="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search for book or authors...">
                        </div>
                        <div class="col-lg-1">
                            <button class="btn btn-primary w-100">Apply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h4 class="mb-0">Book List</h4>
                <div>
                    <a href="index.php" class="btn btn-outline-secondary">Back</a>
                    <a href="addbook.php" class="btn btn-primary">Add Book</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Rating</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th width="170">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $displaysql = "SELECT books.*, categories.name as category_name, categories.color from BOOKS LEFT JOIN categories ON books.id_category=categories.id where 1=1";
                            if (!empty($search)) {
                                $search = $connection->conn->real_escape_string($search);
                                $displaysql .= " AND (books.title LIKE '%$search%' OR books.author LIKE '%$search%')";
                            }
                            if ($category != "" && $category !== 'default') {
                                $displaysql .= " AND books.id_category = $category";
                            }
                            if ($sortby == 'highrating') {
                                $displaysql .= " ORDER BY books.rating DESC";
                            }
                            else if ($sortby == 'lowrating') {
                                $displaysql .= " ORDER BY books.rating ASC";
                            }
                            else if ($sortby == 'highprice') {
                                $displaysql .= " ORDER BY books.price DESC";
                            }
                            else if ($sortby == 'lowprice') {
                                $displaysql .= " ORDER BY books.price ASC";
                            }
                            else {
                                $displaysql .= " ORDER BY books.title ASC";
                            }
                            $result = $connection->conn->query($displaysql);
                            while ($rowbook = $result->fetch_assoc()){
                                if($rowbook['rating'] == NULL){
                                    $rating = "No ratings";
                                }
                                else{
                                    $rating = "⭐".number_format($rowbook['rating'],1);
                                }
                                echo'
                                    <tr>
                                        <td><img src="../uploads/'.$rowbook['cover'].'" class="img-thumbnail" width="60"></td>
                                        <td>'.$rowbook['title'].'</td>
                                        <td>'.$rowbook['author'].'</td>
                                        <td><span class="badge bg-'.$rowbook['color'].'">'.$rowbook['category_name'].'</span></td>
                                        <td>'.$rating.'</td>
                                        <td>'.$rowbook['stock'].'</td>
                                        <td>Rp'.number_format($rowbook['price']).'</td>
                                        <td>
                                            <a href="editbooks.php?id='.$rowbook['id'].'" class="btn btn-warning btn-sm">Edit</a>
                                            <form method="POST" class="d-inline" onsubmit="return confirm(\'Are you sure you want to delete this book?\');">
                                                <input type="hidden" name="id" value="'.$rowbook['id'].'">
                                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>';
                            }
                        ?>
                    </tbody>
                </table>
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