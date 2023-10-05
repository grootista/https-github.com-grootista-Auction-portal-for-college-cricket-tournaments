<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other page you prefer
    header("location: login.php"); // Redirect to your login page
    exit();
} else {
    // If the user is not logged in, you can handle this case accordingly
    // Redirect them to the login page or show an error message
    header("location: login.php"); // Redirect to your login page
    exit();
}
?>
