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
    if(isset($_POST['submit'])){
        $title = mysqli_real_escape_string($connection->conn, $_POST['title']);
        $author = mysqli_real_escape_string($connection->conn, $_POST['author']);
        $category = $_POST['category'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $cover = $_FILES['cover']['name'];
        $tmp = $_FILES['cover']['tmp_name'];
        $target = '../uploads/'.$cover;
        move_uploaded_file($tmp, $target);
        $description = mysqli_real_escape_string($connection->conn, $_POST['description']);
        $insert = "INSERT into books (title, author, price, stock, cover, description, id_category) values ('$title','$author','$price','$stock','$cover','$description','$category')";
        $connection->conn->query($insert);
        header("location: books.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
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
        .formcard{
            border:none;
            border-radius:20px;
        }
        .form-control{
            border-radius:10px;
        }
        .form-select{
            border-radius:10px;
        }
        textarea{
            resize:none;
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
                        <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/admin" class="nav-link" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/admin/books.php">Books</a>
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
                    <h1 class="fw-bold">Add Book</h1>
                    <p class="lead mt-2">Fill in the information below to add a new book.</p>
                </div>
                <div class="col-lg-5 text-center mt-3">
                    <img src="../assets/heroimage.png" class="img-fluid w-50">
                </div>
            </div>
        </section>

        <div class="card formcard shadow-sm">
            <div class="card-body p-5">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" class="form-control" id="author" name="author" placeholder="Author" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" class="form-select">
                                <?php 
                                    $sql = "SELECT * from categories";
                                    $result = $connection->conn->query($sql);
                                    while($row = $result->fetch_assoc()){
                                        echo'<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                        }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="Price" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock" required>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <label for="cover" class="form-label">Cover</label>
                            <input type="file" class="form-control" id="cover" name="cover" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea rows="5" name="description" id="description" class="form-control" placeholder="Write a description..."></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <a href="books.php" class="btn btn-outline-secondary" id="cancel" name="cancel">Cancel</a>
                        <button type="submit" id="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
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