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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
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
        .category-card:hover{
            transform: scale(110%);
        }
        footer img:hover{
            transform: scale(110%);
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
                        <a class="nav-link active" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/orders.php">Orders</a>
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
                    <h1 class="display-5 fw-bold">Your Shopping Cart</h1>
                    <p class="lead mt-3">Review your books before checking out.</p>
                </div>
                <div class="col-lg-5 text-center">
                    <img src="assets/shoppingcart.png" class="img-fluid w-50">
                </div>
            </div>
        </section>

        <div class="row">
            <div class="col-lg-8">
                <div class="card formcard shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h4>Shopping Cart</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Cover</th>
                                    <th>Book</th>
                                    <th>Price</th>
                                    <th width="140">Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img src="uploads/book1.jpg" class="img-thumbnail" width="60"></td>
                                    <td><b>Atomic Habits</b>
                                        <br>
                                        <small class="text-muted">James Clear</small>
                                    </td>
                                    <td>Rp95.000</td>
                                    <td>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary">-</button>
                                            <input class="form-control text-center" value="2">
                                            <button class="btn btn-outline-secondary">+</button>
                                        </div>
                                    </td>
                                    <td>Rp190.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card formcard shadow-sm">
                    <div class="card-header bg-white">
                        <h4>Order Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span>Subtotal</span>
                            <b>Rp565.000</b>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Shipping</span>
                            <b>FREE</b>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Tax</span>
                            <b>Rp56.500</b>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5>Total</h5>
                            <h5 class="text-primary">Rp621.500</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card formcard shadow-sm mt-5">
            <div class="card-header bg-white">
                <h4>Checkout</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="mb-3">Customer Information</h5>
                        <div class="mb-3">
                            <label>Name</label>
                            <input class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Phone Number</label>
                            <input class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Address</label>
                            <textarea class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="mb-3">Payment Details</h5>
                        <div class="mb-3">
                            <label>Card Holder</label>
                            <input class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Card Number</label>
                            <input class="form-control" placeholder="1234 5678 9012 3456">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Expiry</label>
                                    <input class="form-control" placeholder="MM/YY">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>CVV</label>
                                    <input class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info mt-4">
                            Make sure to double check your info before checking out.  
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-end">
                    <button class="btn btn-primary btn-lg">Checkout</button></div>
            </div>
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