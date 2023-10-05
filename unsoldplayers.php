<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Players unsold</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .buttons {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Players Unsold</h1>
    <?php
    // Database connection settings
   include "brdp.php";

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to retrieve player details from the database
    $sql = "SELECT * FROM players where status=2";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display player details in a table
        echo '<table>';
        echo '<tr><th>Sl. No</th><th>USN</th><th>Name</th><th>Branch</th><th>Year</th><th>Role</th></tr>';
        
        $slNo = 1;
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $slNo . '</td>';
            echo '<td>' . $row['usn'] . '</td>';
            echo '<td>' . $row['Name'] . '</td>';
            echo '<td>' . $row['Branch'] . '</td>';
            echo '<td>' . $row['Year'] . '</td>';
            echo '<td>' . $row['role'] . '</td>';
            echo '</tr>';
            
            $slNo++;
        }
        echo '</table>';
    } else {
        echo '<h1>List Empty!</h1>';
    }

    // Close the database connection
    $conn->close();
    ?>

<div class="buttons">
    <button class="btn" onclick="window.print()">Print</button>
    <a href="auctionportal.php" class="btn">Back</a>
    <button class="btn" onclick="viewAuctionPlayers()">Auction Players again</button>
</div>
<script>
function viewAuctionPlayers() {
    // Perform the action to view auction players (you can replace this with your desired logic)
    window.location.href = 'unstat.php';
}
</script>

</body>
</html>
