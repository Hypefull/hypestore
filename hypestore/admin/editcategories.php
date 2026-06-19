<?php
    session_start();
    require_once('../library/database.php');
    require_once('../library/koneksi.php');
    $connection = new Database($host, $user, $pass, $database);
    $displayedit = "SELECT * from categories where id=".$_GET['id'];
    $resultedit = $connection->conn->query($displayedit);
    $rowedit = $resultedit->fetch_assoc();

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
        $name = mysqli_real_escape_string($connection->conn, $_POST['name']);
        $description = mysqli_real_escape_string($connection->conn, $_POST['description']);
        $color = $_POST['color'];
        $edit = "UPDATE categories set name='$name', description='$description', color='$color' where id=".$_GET['id'];
        $connection->conn->query($edit);
        header("location: categories.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
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
                        <a class="nav-link" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/admin/books.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/admin/categories.php" class="nav-link active">Categories</a>
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
                    <h1 class="fw-bold">Edit Category</h1>
                    <p class="lead mt-2">Change any information about any category.</p>
                </div>
                <div class="col-lg-5 text-center mt-3">
                    <img src="../assets/addcategory.png" class="img-fluid w-50">
                </div>
            </div>
        </section>

        <div class="card formcard shadow-sm">
            <div class="card-body p-5">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="<?php echo $rowedit['name'];?>" class="form-control" id="name" name="name" placeholder="Name" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea rows="5" name="description" id="description" class="form-control" placeholder="Write a description..."><?php echo $rowedit['description'];?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="color" class="form-label">Color</label>
                        <select name="color" id="color" class="form-select">
                            <option <?php if($rowedit['color'] == "primary") echo "selected"; ?> value="primary">🔵Blue</option>
                            <option <?php if($rowedit['color'] == "secondary") echo "selected"; ?> value="secondary">⚪Gray</option>
                            <option <?php if($rowedit['color'] == "success") echo "selected"; ?> value="success">🟢Green</option>
                            <option <?php if($rowedit['color'] == "danger") echo "selected"; ?> value="danger">🔴Red</option>
                            <option <?php if($rowedit['color'] == "warning") echo "selected"; ?> value="warning">🟡Yellow</option>
                            <option <?php if($rowedit['color'] == "info") echo "selected"; ?> value="info">🔵Light Blue</option>
                            <option <?php if($rowedit['color'] == "dark") echo "selected"; ?> value="dark">⚫Black</option>
                        </select>
            </div>
                    <div class="d-flex justify-content-end gap-3">
                        <a href="categories.php" class="btn btn-outline-secondary" id="cancel" name="cancel">Cancel</a>
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