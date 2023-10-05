<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Info</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #007bff;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
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

        .team-players {
            margin-top: 20px;
        }

        .team-name {
            font-size: 24px;
            color: #333;
            margin-top: 10px;
        }

        .player-list {
            list-style: none;
            padding: 0;
        }

        .player-list li {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Teams Information</h1>
        <?php
        // Database connection settings
        include "brdp.php";

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to retrieve team details from the database
        $sql = "SELECT * FROM teams";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display team details in a table
            echo '<table>';
            echo '<tr><th>TeamID</th><th>TeamName</th><th>PlayersBought</th><th>Points Remaining</th></tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['TeamID'] . '</td>';
                echo '<td>' . $row['TeamName'] . '</td>';
                echo '<td>' . $row['PlayersBought'] . '</td>';
                echo '<td>' . $row['PointsRemaining'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';

            // Now, display the names of players bought by each team
            echo '<div class="team-players">';

            // Query to fetch player names bought by each team
            $playersByTeamSQL = "SELECT t.TeamName, p.Name 
                                 FROM teams t
                                 JOIN sold_players s ON t.TeamID = s.sold_to_team
                                 JOIN players p ON s.usn = p.usn";

            $resultPlayersByTeam = $conn->query($playersByTeamSQL);

            if ($resultPlayersByTeam->num_rows > 0) {
                // Initialize variables to track the current team
                $currentTeam = '';
                $firstRow = true;

                while ($row = $resultPlayersByTeam->fetch_assoc()) {
                    if ($currentTeam != $row['TeamName']) {
                        // Display the team name as a heading
                        if (!$firstRow) {
                            echo '</ul>';
                        }
                        echo '<div class="team-name">' . $row['TeamName'] . '</div>';
                        echo '<ul class="player-list">';
                        $firstRow = false;
                        $currentTeam = $row['TeamName'];
                    }

                    // Display the player name for the current team
                    echo '<li>' . $row['Name'] . '</li>';
                }
                echo '</ul>';
            } else {
                echo 'No Players bought by teams yet.';
            }
            echo '</div>';
        } else {
            echo 'No Teams registered.';
        }

        // Close the database connection
        $conn->close();
        ?>

        <div class="buttons">
            <button class="btn" onclick="window.print()">Print</button>
            <a href="auctionportal.php" class="btn">Back</a>
        </div>
    </div>
</body>
</html>
