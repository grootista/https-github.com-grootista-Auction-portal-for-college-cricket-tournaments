<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login page</title>
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<section class="vh-100" style="background-color: #1f1f1f;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card" style="border-radius: 1rem;">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-5 d-none d-md-block">
                            <img src="../images/loginpage.jpg" alt="login form" class="img-fluid"
                                 style="border-radius: 1rem 0 0 1rem; height: 500px; width: 389px;"/>
                        </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5 text-black">
                                <form  method="POST">
                                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your
                                        account</h5>

                                    <div class="form-outline mb-4">
                                        <input type="text" id="form2Example17" class="form-control form-control-lg"
                                               name="usn" required>
                                        <label class="form-label" for="form2Example17">USN</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" id="form2Example27" class="form-control form-control-lg"
                                               name="password" required>
                                        <label class="form-label" for="form2Example27">Password</label>
                                    </div>

                                    <div class="pt-1 mb-4">
                                        <button class="btn btn-dark btn-lg btn-block" type="submit" name="login">Login</button>
                                    </div>

                                    <p class="mb-5 pb-lg-2" style="color: #393f81;">New here? <a
                                            href="/phplearn/php/register.php" style="color: #393f81;">Register
                                            now</a></p>
                                </form>
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
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['login'])) {
    $usn = strtoupper($_POST['usn']); // Convert USN to uppercase for consistency
    $password = $_POST['password'];

    $servername = "localhost";
    $username = "root";
    $pass = "";
    $database = "auctionuserregistration";
    $conn = mysqli_connect($servername, $username, $pass, $database);

    if (!$conn) {
        die("Sorry, cannot connect right now");
    } else {
        // Query to check if a user with the provided USN exists
        $query = "SELECT * FROM `users` WHERE `usn` = '$usn'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $storedPassword = $row['password'];
            $name=$row['Name'];
            $usn=$row['usn'];
            // echo "Password from form: " . $password . "<br>";
            // echo "Stored hashed password: " . $storedPassword . "<br>";

            // Verify the entered password against the stored hashed password
            if ($password== $storedPassword) {
                // Password is correct, perform the redirection
                //echo '<script>window.location.href = "/phplearn/php/coord.php";</script>';
                
                session_start();
                $_SESSION['loggedin']=true;
                $_SESSION['username']=$usn;
               // $_SESSION['usn']=$usn;
                header("location:dashboard.php");
                exit();
            }
             else {
                // Incorrect password message
                echo '<div class="alert alert-danger fixed-top w-100 text-center" style="background-color: #efe2e2;">Incorrect password. Please try again.</div>';
            }
        } else {
            // User does not exist message
            echo '<div class="alert alert-danger fixed-top w-100 text-center" style="background-color: #efe2e2;">User with this USN does not exist.</div>';
        }
    }
}
?>
