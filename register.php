<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Registration</title>
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">
</head>
<body class="vh-100" style="background-color: #2f2f2f;">
    <!-- Your registration form -->
    <section >
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>
                                    <!-- Update form action to confirm.php -->
                                    <form class="mx-1 mx-md-4" action="/phplearn/php/register.php" method="post">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" id="name" class="form-control" name="name" required>
                                                <label class="form-label" for="name">Name</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" id="usn" class="form-control" name="usn" required>
                                                <label class="form-label" for="usn">USN</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="tel" id="phone" class="form-control" name="phone" required>
                                                <label class="form-label" for="phone">Phone number</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" id="pass" class="form-control" name="pass" required>
                                                <label class="form-label" for="pass">Password</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" id="repeat_pass" class="form-control" name="repeat_pass" required>
                                                <label class="form-label" for="repeat_pass">Repeat your password</label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" class="btn btn-primary btn-lg">Register</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                    <img src="../images/register.jpg" class="img-fluid" alt="Sample image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $usn = strtoupper($_POST['usn']);
    $phone = $_POST['phone'];
    $password = $_POST['pass'];
    $repeatPassword=$_POST['repeat_pass'];

    // Validate and sanitize user input if needed
    if ($password !== $repeatPassword) {
        echo '<div class="alert alert-success fixed-top w-100 text-center" style="display: block;background-color:#efe2e2;">Passwords do not match! Please enter matching passwords. </div>';
        exit; // Stop processing further if passwords don't match
    }

    $servername = "localhost";
    $username = "root";
    $pass = "";
    $database = "auctionuserregistration";
    $conn = mysqli_connect($servername, $username, $pass, $database);

    if (!$conn) {
        die("Sorry, cannot connect right now");
    } else {
        // Hash the password
       // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $checkQuery = "SELECT * FROM `users` WHERE `usn` = '$usn'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo '<div class="alert alert-success fixed-top w-100 text-center" style="display: block;background-color:#efe2e2;">User with same usn already exists!<a href="/phplearn/php/login.php" class="alert-link">Try logging in.</a></div>';
        }else{
            $sql = "INSERT INTO `users`(`usn`, `Name`, `phone`, `password`) VALUES ('$usn','$name','$phone','$password')";
            $result = mysqli_query($conn, $sql);
    
             if ($result) {
                echo '<div class="alert alert-success fixed-top w-100 text-center" style="display: block;">Registration successful!
                <a href="/phplearn/php/login.php" class="alert-link">Click here to log in.</a></div>';
             } else {
                echo '<div class="alert alert-danger" role="alert">Error: ' . mysqli_error($conn) . '</div>';
         }

        }

       
    }
}
?>
