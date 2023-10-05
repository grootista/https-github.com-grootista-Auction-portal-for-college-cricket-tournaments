<?php
session_start();
   

//Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
   //Now you can access and display the username
   $usn = $_SESSION['username'];

   include "connect.php";
   if (!$conn) {
    die("Sorry, cannot connect right now");
   }else{
    
    $query = "SELECT * FROM `users` WHERE `usn` = '$usn'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            //$storedPassword = $row['password'];
            $name=$row['Name'];
            $ph=$row['phone'];
        }
        echo '<h1 ><p>      Name: <strong> </strong> '.$name .' </h1></p>';
        echo '<h1 ><p>      USN: <strong> </strong> '.$usn .' </h1></p>';
        echo '<h1 ><p>      Phone: <strong> </strong> '.$ph .' </h1></p>';
        
        // session_unset();
}
}

?>