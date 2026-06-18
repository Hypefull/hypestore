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
        $email = $_POST['email'];
        $password = hash('sha256',$_POST['password']);
        $sql = "SELECT * from users where email='$email' and password ='$password'";
        $result = $connection->conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $_SESSION['name'] = $row['name'];
            $_SESSION['id'] = $row['id'];
            header("location: index.php");
        }
        else {
            $notification = '<div class="alert alert-danger mb-3 text-center">⚠️Wrong email or password, please try again! </div>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .login{
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
        <div class="card shadow-lg border-0 login">
            <div class="row g-0">

                <div class="col-lg-5 leftside bg-primary d-flex flex-column justify-content-center align-items-center text-center">
                    <img src="assets/heroimage2.png"class="img-fluid mb-4">
                    <h2 class="fw-bold">Login</h2>
                    <p class="mt-3">
                        Great stories are waiting to be discovered. Your perfect book is just a click away.
                    </p>
                </div>
                
                <div class="col-lg-7">
                    <div class="card-body p-5">
                        <h2 class="fw-bold mb-4">
                            Sign In
                        </h2>
                        <form method="POST">
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
                            <button type="submit" name="submit" id="submit" class="btn btn-primary w-100 mb-3">Login</button>

                            <p class="text-center text-muted">Don't have an account? <a href="register.php" class="text-decoration-none">Register</a></p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>