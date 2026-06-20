<?php
    session_start();
    require_once('library/database.php');
    require_once('library/koneksi.php');
    $connection = new Database($host, $user, $pass, $database);
    $name = "";
    $auth = "";
    if(isset($_SESSION['name'])){
        $accountname = $_SESSION['name'];
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
    $sql = "SELECT cart.*, books.title, books.author, books.cover, books.price, books.stock FROM cart JOIN books ON cart.id_book = books.id WHERE cart.id_user='$userid'";
    $result = $connection->conn->query($sql);

    if(isset($_POST['updatecart'])){
        $cartid = $_POST['cartid'];
        $quantity = max(1, $_POST['quantity']);
        $stockquery = "SELECT books.stock FROM cart JOIN books ON cart.id_book = books.id WHERE cart.id = $cartid";
        $stockresult = $connection->conn->query($stockquery);
        $stock = $stockresult->fetch_assoc()['stock'];
        if($quantity > $stock){
            $quantity = $stock;
        }
        $update = "UPDATE cart SET quantity = $quantity WHERE id = $cartid AND id_user = $userid";
        $connection->conn->query($update);
        header("location: orders.php");
        exit();
    }
    if(isset($_POST['checkout'])){

        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $cartquery = "SELECT cart.*, books.price FROM cart JOIN books ON cart.id_book = books.id WHERE cart.id_user='$userid'";
        $cart = $connection->conn->query($cartquery);
        $subtotal = 0;
        while($item = $cart->fetch_assoc()){
            $subtotal += $item['price'] * $item['quantity'];
        }
        $tax = $subtotal * 0.10;
        $total = $subtotal + $tax;
        $insertquery = "INSERT INTO orders (id_user,name,email,phone,address,subtotal,tax,total) VALUES ('$userid','$name','$email','$phone','$address','$subtotal','$tax','$total')";
        $connection->conn->query($insertquery);
        $orderid = $connection->conn->insert_id;
        $cartquery = "SELECT cart.*, books.price FROM cart JOIN books ON cart.id_book = books.id WHERE cart.id_user='$userid'";
        $cart = $connection->conn->query($cartquery);
        while($item = $cart->fetch_assoc()){
            $booksubtotal = $item['price'] * $item['quantity'];
            $insertquery2 = "INSERT INTO order_details (id_order,id_book,price,quantity,subtotal) VALUES ('$orderid','".$item['id_book']."','".$item['price']."','".$item['quantity']."','$booksubtotal')";
            $updatestockquery = "UPDATE books SET stock = stock - '".$item['quantity']."' WHERE id = '".$item['id_book']."'";
            $connection->conn->query($insertquery2);
            $connection->conn->query($updatestockquery);
        }
        $emptycartquery = "DELETE FROM cart WHERE id_user='$userid'";
        $connection->conn->query($emptycartquery);
        header("location: orders.php");
        exit();
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
                        <a class="nav-link active" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/orders.php">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/hypestore/orderlist.php">Orders</a>
                    </li>
                </ul>
            </div>
            <span class="text-white me-3">
                <?php echo $accountname;?>
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
                                    <th width="100">Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $subtotal = 0;
                                    while ($row = $result->fetch_assoc()){
                                        $total = $row['price'] * $row['quantity'];
                                        $subtotal += $total;
                                        echo '
                                            <tr>
                                                <td><img src="uploads/'.$row['cover'].'" class="img-thumbnail" width="60"></td>
                                                <td><b>'.$row['title'].'</b>
                                                    <br>
                                                    <small class="text-muted">'.$row['author'].'</small>
                                                </td>
                                                <td>Rp'.number_format($row['price']).'</td>
                                                <td>
                                                    <form method="POST">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <input type="hidden" name="cartid" value="'.$row['id'].'">
                                                            <input type="number" class="form-control-sm text-center" style="width:70px; flex:none;" id="quantity" name="quantity" value="'.$row['quantity'].'"  min="1" max="'.$row['stock'].'">
                                                            <button class="btn btn-primary btn-sm" name="updatecart">Save</button>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td>Rp'.number_format($total).'</td>
                                            </tr>
                                        ';
                                    }
                                    $tax = $subtotal * 0.10;
                                    $grandtotal = $subtotal + $tax;
                                ?>
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
                            <b>Rp<?php echo number_format($subtotal);?></b>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Shipping</span>
                            <b>FREE</b>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Tax</span>
                            <b>Rp<?php echo number_format($tax);?></b>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5>Total</h5>
                            <h5 class="text-primary">Rp<?php echo number_format($grandtotal);?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card formcard shadow-sm mt-5">
            <div class="card-header bg-white">
                <h4>Checkout</h4>
            </div>
            <form method="POST">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="mb-3">Customer Information</h5>
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone">Phone Number</label>
                                <input type="tel" name="phone" id="phone" class="form-control" placeholder="Phone Number" required>
                            </div>
                            <div class="mb-3">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="form-control" rows="4" placeholder="Enter your address..." required></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="mb-3">Payment Details</h5>
                            <div class="mb-3">
                                <label for="cardholder">Card Holder</label>
                                <input name="cardholder" id="cardholder" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="cardnumber">Card Number</label>
                                <input name="cardnumber" id="cardnumber" class="form-control" placeholder="1234 5678 9012 3456">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="expiry">Expiry</label>
                                        <input name="expiry" id="expiry" class="form-control" placeholder="MM/YY">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="cvv">CVV</label>
                                        <input name="cvv" id="cvv" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-info mt-4">
                                <strong>IMPORTANT:</strong> Please double check your delivery address and contact details before making your payment! 
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-end">
                        <button name="checkout" id="checkout" class="btn btn-primary btn-lg">Checkout</button></div>
                </div>
            </form>
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