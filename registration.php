<?php
session_start();
if(isset($_SESSION['loggedin'])){
    header('Location index.php');
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
    <h1> Registration Form </h1>

    <body class="bg-light">


        <?php
        $errors = [];
        if (isset($_POST["submit"])) {

            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $description = $_POST['description'];

            //Let's hash the password
            //$variable_name = password_hash($current_password), hashing algorithm.

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            //check for the errors in form filling

            $errors = array();

            if (empty($fullname) or empty($email) or empty($password) or empty($confirm_password)) {
                array_push($errors, "Please fill in all fields");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Please enter an email");
            }

            if (strlen($password) < 8) {
                array_push($errors, "Password should at least be 8 characters");
            }

            if ($password !== $confirm_password) {
                array_push($errors, "Passwords must match");
            }

            //Check if a user exists with the email provided

            require_once "database.php";

            $email_exists = "SELECT * FROM phplogindb WHERE email = '$email'";
            $result = mysqli_query($conn, $email_exists);
            $row_count = mysqli_num_rows($result);

            if($row_count > 0){
                array_push($errors, 'A user with that email already exists');
            }


            //Throw all the errors on the screen
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'> $error</div>";
                }
            } else {
                $sql = "INSERT INTO phplogindb(name, email, password, description)
                        VALUES(?,?,?,?)";

                //prepare the query
                $stmt = mysqli_stmt_init($conn);
                $prepare_stmt = mysqli_stmt_prepare($stmt, $sql);

                if ($prepare_stmt) {
                    mysqli_stmt_bind_param($stmt, "ssss", $fullname, $email, $password_hash, $description);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'> You have successfully registered </div>";
                    header('Location login.php');
                } else {
                    die("Something went wrong, try signing up again");
                }
            }
        }


        ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header text-center">
                            <h4>Register</h4>
                        </div>
                        <div class="card-body">
                            <form action="registration.php" method="post">
                                <div class="mb-3">
                                    <label for="fullname" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="fullname" />
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" name="email" />
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" />
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirm_password" />
                                </div>

                                <div class="mb-3">
                                    <label for="fullname" class="form-label"> Description </label>
                                    <input type="text" class="form-control" name="description" />
                                </div>

                                <button type="submit" class="btn btn-primary w-100" name="submit">Register</button>
                                <div class="mt-3 text-center">
                                    Already have an account? <a href="login.php">Login here</a>
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