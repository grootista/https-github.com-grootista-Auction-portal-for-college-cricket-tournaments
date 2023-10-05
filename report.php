<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Players Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .team-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #007bff;
        }

        .print-button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .print-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php
include "brdp.php";

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve team details from the database
$sql = "SELECT * FROM teams";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Display team details in a table
        echo '<div class="team-header">' . $row['TeamName'] . '</div>';
        echo '<table>';
        echo '<tr><th>Sl No.</th><th>Name</th><th>USN</th><th>Branch</th><th>Year</th><th>Role</th><th>Bid Amount</th><th>Contact no.</th></tr>';

        // Query to fetch player details for the current team and sort by bid amount
        $teamID = $row['TeamID'];
        $playersByTeamSQL = "SELECT  p.Name, p.usn, p.Branch, p.Year, p.Role, s.bid_amount,p.phone
                             FROM players p
                             INNER JOIN sold_players s ON p.usn = s.usn
                             WHERE s.sold_to_team = '$teamID'
                             ORDER BY s.bid_amount DESC";

        $resultPlayersByTeam = $conn->query($playersByTeamSQL);

        if ($resultPlayersByTeam->num_rows > 0) {
            $slNo = 1;
            while ($playerRow = $resultPlayersByTeam->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $slNo . '</td>';
                echo '<td>' . $playerRow['Name'] . '</td>';
                echo '<td>' . $playerRow['usn'] . '</td>';
                echo '<td>' . $playerRow['Branch'] . '</td>';
                echo '<td>' . $playerRow['Year'] . '</td>';
                echo '<td>' . $playerRow['Role'] . '</td>';
                echo '<td>' . $playerRow['bid_amount'] . '</td>';
                echo '<td>' . $playerRow['phone'] . '</td>';

                echo '</tr>';
                $slNo++;
            }
        } else {
            echo '<tr><td colspan="7">No Players bought by this team yet.</td></tr>';
        }

        echo '</table>';
    }
} else {
    echo 'No Teams registered.';
}

// Close the database connection
$conn->close();
?>

<button class="print-button" onclick="window.print()">Print Report</button>
<button class="print-button" id="returnButton">CLOSE</button>
<script>
    document.getElementById('returnButton').addEventListener('click', function() {
    // Redirect to playerform.php
    window.close();
});
</script>

</body>
</html>
