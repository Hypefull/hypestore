<?php
    session_start();
    require_once('library/database.php');
    require_once('library/koneksi.php');
    $connection = new Database($host, $user, $pass, $database);
    $notification = "";

    if(isset($_SESSION['id'])){
        header("location: index.php");
    }

    if(isset($_POST['submit'])){
        $name = mysqli_real_escape_string($connection->conn, $_POST['name']);
        $email = mysqli_real_escape_string($connection->conn, $_POST['email']);
        $password = hash('sha256',$_POST['password']);
        $cekquery = "SELECT email FROM users WHERE email='$email'";
        if(($connection->conn->query($cekquery)->num_rows) > 0){
            $notification = '<div class="alert alert-danger mb-3 text-center">⚠️That email has already been used, please use another email address! </div>';
        } else{
            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
            $connection->conn->query($sql);
            header("location: login.php");
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .register{
            border-radius:20px;
            overflow:hidden;
        }
        .leftside{
            padding:60px 40px;
            color:white;
        }
        .form-control{
            border-radius:10px;
        }
        .btn{
            border-radius:10px;
        }
    </style>
    <script>
        function showPassword(){
            let x = document.getElementById("password")
            if (x.type == "password"){
                x.type = "text";
            } 
            else {
                x.type = "password";
            }
        }
    </script>
</head>
<body>
    <div class="container py-5">
        <div class="card shadow-lg border-0 register">
            <div class="row g-0">

                <div class="col-lg-5 leftside bg-primary d-flex flex-column justify-content-center align-items-center text-center">
                    <img src="assets/heroimage2.png"class="img-fluid mb-4">
                    <h2 class="fw-bold">Register</h2>
                    <p class="mt-3">
                        Great stories are waiting to be discovered. Your perfect book is just a click away.
                    </p>
                </div>
                
                <div class="col-lg-7">
                    <div class="card-body p-5">
                        <h2 class="fw-bold mb-4">
                            Register Account
                        </h2>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autocomplete="off">
                            </div>

                            <div class="form-check mb-4">
                                <input type="checkbox" class="form-check-input" onclick="showPassword()">
                                <label for="showPassword" class="form-check-label">Show Password</label>
                            </div>

                            <?php echo $notification;?>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary w-100 mb-3">Register</button>

                            <p class="text-center text-muted">Already have an account? <a href="login.php" class="text-decoration-none">Login</a></p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>