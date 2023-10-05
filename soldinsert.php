<?php
// Establish a database connection (you may need to adjust the connection parameters)
include "brdp.php";

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the data from the POST request
$usn = $_POST['usn'];
$soldToTeam = $_POST['soldToTeam'];
$bidAmount = $_POST['bidAmount'];

// Update the player's status to 1 in the players table
$updateStatusSQL = "UPDATE players SET status = 1 WHERE usn = '$usn'";

if ($conn->query($updateStatusSQL) == TRUE) {
    // Insert the sold player's details into the sold_players table
    $insertSoldPlayerSQL = "INSERT INTO sold_players (usn, sold_to_team, bid_amount) VALUES ('$usn', '$soldToTeam', $bidAmount)";

    if ($conn->query($insertSoldPlayerSQL) === TRUE) {
        // Update the team's PointsRemaining and PlayersBought in the teams table
        $updateTeamSQL = "UPDATE teams SET PointsRemaining = PointsRemaining - $bidAmount, PlayersBought = PlayersBought + 1 WHERE TeamID = '$soldToTeam'";
        
        if ($conn->query($updateTeamSQL) === TRUE) {
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error_update_team'));
        }
    } else {
        echo json_encode(array('status' => 'error_insert'));
    }
} else {
    echo json_encode(array('status' => 'error_update'));
}

// Close the database connection
$conn->close();
?>
