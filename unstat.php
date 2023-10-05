<?php
// Establish a database connection (you may need to adjust the connection parameters)
include "brdp.php";

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the data from the POST request
//$usn = $_POST['usn'];


// Update the player's status to 1 in the players table
$updateStatusSQL = "UPDATE players SET status = 0 where status=2";

if ($conn->query($updateStatusSQL) ==TRUE) {
    // Insert the sold player's details into the soldplayers table
   header('location:auctionportal.php');
    
} else {
    echo "something went wrong";
}

// Close the database connection
$conn->close();
?>
