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

    if(!isset($_SESSION['id'])){
        header("location: login.php");
        exit();
    }
    $userid = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .hero{
            color:white;
            border-radius:20px;
            padding:50px;
        }
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
        footer img:hover{
            transform: scale(110%);
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
                        <a class="nav-link" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/books.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/orders.php">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/orderlist.php">Orders</a>
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
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold">My Orders</h1>
                    <p class="lead mt-3">Track all of your purchases and monitor their current status.</p>
                </div>
                <div class="col-lg-4 text-center">
                    <img src="assets/orderlist.png" class="img-fluid w-50">
                </div>
            </div>
        </section>
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h4 class="mb-0">Order History</h4>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th width="130">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $ordersql = "SELECT orders.*, COUNT(order_details.id) AS items FROM orders LEFT JOIN order_details ON orders.id = order_details.id_order WHERE orders.id_user = '$userid' GROUP BY orders.id ORDER BY orders.id DESC";
                        $result = $connection->conn->query($ordersql);
                        while ($row = $result->fetch_assoc()){
                            if($row['status'] == "Pending"){
                                $badge = "warning text-dark";
                            }
                            else if($row['status'] == "Completed"){
                                $badge = "success";
                            }
                            else{
                                $badge = "danger";
                            }
                            echo '
                                <tr>
                                    <td>#'.$row['id'].'</td>
                                    <td>'.date("d M Y", strtotime($row['created_at'])).'</td>
                                    <td>'.$row['items'].'</td>
                                    <td>Rp'.number_format($row['total']).'</td>
                                    <td><span class="badge bg-'.$badge.'">'.$row['status'].'</span></td>
                                    <td><a href="vieworder.php?id='.$row['id'].'" class="btn btn-primary btn-sm">See Details</a></td>
                                </tr>
                            ';
                        }
                    ?>
                </tbody>
            </table>
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