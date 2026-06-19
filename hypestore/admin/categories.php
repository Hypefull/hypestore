<?php
    session_start();
    require_once('../library/database.php');
    require_once('../library/koneksi.php');
    $connection = new Database($host, $user, $pass, $database);

    if(!isset($_SESSION['admin'])){
        header("location: login.php");
    }
    
    if(isset($_POST['delete'])){
        $id = $_POST['id'];
        $checkdelete = "SELECT COUNT(*) AS total FROM books WHERE id_category = '$id'";
        $result = $connection->conn->query($checkdelete);
        $row = $result->fetch_assoc();
        if($row['total'] > 0){
            echo "<script>
                    alert('Cannot delete this category because it is still being used by one or more books.');
                    window.location='categories.php';
                </script>";
            exit();
        } 
        else {
            $delete = "DELETE FROM categories WHERE id = '$id'";
            $connection->conn->query($delete);
        }
    }
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
    <title>Categories</title>
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
                    <h1 class="fw-bold">Manage Categories</h1>
                    <p class="lead mt-2">Add, view, edit, or delete categories.</p>
                </div>
                <div class="col-lg-5 text-center mt-3">
                    <img src="../assets/managecategories.png" class="img-fluid w-50">
                </div>
            </div>
        </section>

        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h4 class="mb-0">Category List</h4>
                <div>
                    <a href="index.php" class="btn btn-outline-secondary">Back</a>
                    <a href="addcategories.php" class="btn btn-primary">Add Category</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="8%">No</th>
                            <th>Name</th>
                            <th width="40%">Description</th>
                            <th width="15%">Color</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $displayquery = "SELECT * from categories";
                            $displayresult = $connection->conn->query($displayquery);
                            $number = 1;

                            while($displaycategories = $displayresult->fetch_assoc()){
                                echo '<tr>
                                    <td>'.$number.'</td>
                                    <td>'.$displaycategories['name'].'</td>
                                    <td>'.$displaycategories['description'].'</td>
                                    <td>
                                        <span class="badge bg-'.$displaycategories['color'].'">'.ucfirst($displaycategories['color']).'</span>
                                    </td>
                                    <td>
                                        <a href="editcategories.php?id='.$displaycategories['id'].'" class="btn btn-warning btn-sm">Edit</a>
                                        <form method="POST" class="d-inline" onsubmit="return confirm(\'Are you sure you want to delete this category?\');">
                                            <input type="hidden" name="id" value="'.$displaycategories['id'].'">
                                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>';
                                $number = $number + 1;
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