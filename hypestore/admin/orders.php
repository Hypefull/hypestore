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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .card{
            border:none;
            border-radius:16px;
        }
        .statcard{
            color: white;
            border-radius: 16px;
            padding: 20px;
        }
        .btn{
            border-radius:10px;
        }
        .table td{
            vertical-align: middle;
        } 
        .table th {
            vertical-align: middle;
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
                        <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/admin/books.php" class="nav-link">Books</a>
                    </li>
                    <li class="nav-item">
                        <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/admin/categories.php" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/admin/orders.php">Orders</a>
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

    <div class="container py-4">
        <div class="row g-3 mb-4">
            <div class="col-lg-3">
                <div class="card statcard bg-primary">
                    <h5>Total Orders</h5>
                    <h2>1200</h2>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card statcard bg-warning text-dark">
                    <h5>Pending</h5>
                    <h2>45</h2>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card statcard bg-success">
                    <h5>Completed</h5>
                    <h2>1100</h2>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card statcard bg-danger">
                    <h5>Cancelled</h5>
                    <h2>55</h2>
                </div>
            </div>
        </div>

        <div class="card shadow-sm p-3 mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-lg-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="default" selected hidden>Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="shipped">Shipped</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="search" class="form-label">Search</label>
                    <input id="search" name="search" type="text" class="form-control" placeholder="Search by order ID or customer...">
                </div>
                <div class="col-lg-3">
                    <button class="btn btn-primary w-100">Apply</button>
                </div>
            </div>
        </div>

        <div class="card p-3">
            <h4 class="mb-3">Orders List</h4>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#1001</td>
                        <td>John Doe</td>
                        <td>2026-06-19</td>
                        <td>3</td>
                        <td>Rp 250.000</td>
                        <td><span class="status-pending">Pending</span></td>
                        <td><button class="btn btn-sm btn-primary">View</button></td>
                    </tr>
                </tbody>
            </table>
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