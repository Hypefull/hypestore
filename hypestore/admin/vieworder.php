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
    if(!isset($_GET['id'])){
        header("location: orders.php");
        exit();
    }

    $id = $_GET['id'];
    if(isset($_POST['updatestatus'])){
        $status = $_POST['status'];
        $update = "UPDATE orders SET status='$status' WHERE id='$id'";
        $connection->conn->query($update);
        header("location: vieworder.php?id=".$id);
        exit();
    }
    $orderquery = "SELECT * FROM orders WHERE id='$id'";
    $order = $connection->conn->query($orderquery);
    $row = $order->fetch_assoc();

    if($row['status'] == "Pending"){
        $badge = "warning text-dark";
    }
    else if($row['status'] == "Completed"){
        $badge = "success";
    }
    else{
        $badge = "danger";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .card{
            border:none;
            border-radius:18px;
        }
        .btn{
            border-radius:10px;
        }
        .table td{
            vertical-align:middle;
        }
        .table th{
            vertical-align:middle;
        }
        .badge{
            font-size:14px;
            padding:8px 14px;
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
                        <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/admin"class="nav-link" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/admin/books.php">Books</a>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>Order #<?php echo $row['id'];?></h2>
                <h2 class="badge bg-<?php echo $badge;?>"><?php echo $row['status'];?></h2>
            </div>
            <a href="orders.php" class="btn btn-secondary">Back</a>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Order Details</h5>
                    </div>
                <div class="card-body">
                    <p><strong>Customer</strong><br><?php echo $row['name'];?></p>
                    <p><strong>Email</strong><br><?php echo $row['email'];?></p>
                    <p><strong>Phone</strong><br><?php echo $row['phone'];?></p>
                    <p><strong>Address</strong><br><?php echo $row['address'];?></p>
                    <hr>
                    <p><strong>Subtotal</strong><br>Rp<?php echo number_format($row['subtotal']);?></p>
                    <p><strong>Tax</strong><br>Rp<?php echo number_format($row['tax']);?></p>
                    <h4 class="text-primary">Total: Rp<?php echo number_format($row['total']);?></h4>
                    <hr>
                    <form method="POST">
                        <label class="form-label">Order Status</label>
                        <select name="status" id="status" class="form-select mb-3">
                            <option value="Pending" <?php if ($row['status'] == "Pending") echo "selected";?>>Pending</option>
                            <option value="Completed" <?php if ($row['status'] == "Completed") echo "selected";?>>Completed</option>
                            <option value="Cancelled" <?php if ($row['status'] == "Cancelled") echo "selected";?>>Cancelled</option>
                        </select>
                        <button name="updatestatus" id="updatestatus" class="btn btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Ordered Items</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Book</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $itemsquery = "SELECT order_details.*, books.title FROM order_details JOIN books ON order_details.id_book = books.id WHERE order_details.id_order='$id'";
                                $items = $connection->conn->query($itemsquery);
                                while ($row2 = $items->fetch_assoc()){
                                    echo '
                                        <tr>
                                            <td>'.$row2['title'].'</td>
                                            <td>Rp'.number_format($row2['price']).'</td>
                                            <td>'.$row2['quantity'].'</td>
                                            <td>Rp'.number_format($row2['subtotal']).'</td>
                                        </tr>
                                    ';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
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