<?php
session_start();
if(isset($_SESSION['user'])){
    header('Location: index.php');
    exit();
}


if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $passsword = $_POST['password'];

    require_once 'database.php';

    $errors = array();

    $login_query = "SELECT * FROM phplogindb WHERE email = '$email'";
    $result = mysqli_query($conn , $login_query);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if($user){
        if(password_verify($passsword, $user["password"])){

            //start the session here 
            session_start();
            $_SESSION['user'] = 'yes';
            header('Location: index.php');
            die();
        }
        else{
             echo "<div class='alert alert-danger'> Incorrect Password </div>";
        }
    }
    else{
        echo "<div class='alert alert-danger'> There is no user linked with this email </div>";
    }

    //check for the errors and throw them.
    if(count($errors) > 0){
        foreach($errors as $error){
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>

<body>
    <h1> Login Form </h1>

    <body class="bg-light">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header text-center">
                            <h4>Login</h4>
                        </div>
                        <div class="card-body">
                            <form action="login.php" method="post">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" name="email" />
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" />
                                </div>

                                <button type="submit" class="btn btn-primary w-100" name="submit">Login</button>
                                <div class="mt-3 text-center">
                                    Doesn't have an account? <a href="registration.php">Sign Up</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>






        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    </body>

</html>