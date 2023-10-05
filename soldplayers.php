<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction Portal</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        /* Your CSS styles here */
        .player-image {
            width: 100%;
            height: auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }

        .player-details {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }

        .player-details h5 {
            font-size: 24px;
            font-weight: bold;
        }

        .player-details p {
            font-size: 18px;
            margin: 5px 0;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
        }

        .team-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .team-btn {
            font-size: 20px;
            font-weight: bold;
        }

        .bid-info {
            font-size: 24px;
            font-weight: bold;
        }

        /* Style for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
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

        th {
            background-color: #f2f2f2;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Your navigation bar here -->
    <?php include "navbar.php"; ?>
    

    <!-- Table to display sold players -->
    <div class="container mt-4">
        <?php
        // Establish a database connection (you may need to adjust the connection parameters)
        include "brdp.php";

        // Check the database connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to retrieve sold player details from the sold_players table
        $selectSoldPlayersSQL = "SELECT p.usn, p.name, p.branch, p.year, p.phone, s.sold_to_team, s.bid_amount 
                                FROM players p
                                INNER JOIN sold_players s ON p.usn = s.usn";

        $result = $conn->query($selectSoldPlayersSQL);

        if ($result->num_rows > 0) {
            echo "<h1>Sold Players</h1>";
            echo "<table>";
            echo "<tr><th>USN</th><th>Name</th><th>Branch</th><th>Year</th><th>Phone</th><th>Team Name</th><th>Bid Amount</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["usn"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["branch"] . "</td>";
                echo "<td>" . $row["year"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td>" . $row["sold_to_team"] . "</td>";
                echo "<td>" . $row["bid_amount"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No sold players found.</p>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
    <div class="buttons">
        <button class="btn" onclick="window.print()">Print</button>
        <a href="auctionportal.php" class="btn">Back</a>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- ... (your existing script includes) ... -->
</body>
</html>
