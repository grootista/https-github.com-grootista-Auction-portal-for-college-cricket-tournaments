<?php
// Database connection code here
include "brdp.php";
if (!$conn) {
    die("Sorry, cannot connect right now");
} else {
    // Query to fetch a random player
    $query = "SELECT * FROM players WHERE status=0  ORDER BY RAND()  LIMIT 1";

    // Execute the query and fetch the player data
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $player = mysqli_fetch_assoc($result);
        $player['image_url'] = 'plform/' . $player['image']; // Construct the image URL
        // Convert the player data to JSON format
        
        echo json_encode($player);
    } else {
        // No more players available, return an empty response
        echo json_encode(null);
    }
}

// Close the database connection
mysqli_close($conn);
?>