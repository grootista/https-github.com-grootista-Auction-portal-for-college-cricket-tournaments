<?php
echo "     <h3>Please fill the details for the auction you want to conduct....!</h3>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea,
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        select {
            appearance: none; /* Remove default dropdown arrow in some browsers */
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Tournament Registration Form</h1>
    <form action="process_form.php" method="post">
        <label for="eventID">Event ID:</label>
        <input type="text" id="eventID" name="eventID" placeholder="Enter usn+year eg.1SI20IS0302023" required><br>

        <label for="tournamentName">Tournament Name:</label>
        <input type="text" id="tournamentName" name="tournamentName" required><br>

        <label for="numTeams">Number of Teams:</label>
        <select id="numTeams" name="numTeams">
            <option value="2">2</option>
            <option value="4">4</option>
            <option value="6">6</option>
            <option value="8">8</option>
            <option value="10">10</option>
        </select><br>

        <label for="maxPoints">Max Points per Team:</label>
        <input type="number" id="maxPoints" name="maxPoints" required><br>

        <label for="maxPlayers">Max Players per Team:</label>
        <input type="number" id="maxPlayers" name="maxPlayers" required><br>

        <label for="maxPoints">Base price for a player:</label>
        <input type="number" id="basePrice" name="basePrice" required><br>

        <label for="auctionDate">Auction Start Date:</label>
        <input type="date" id="auctionDate" name="auctionDate" required><br>

        <label for="additionalPoints">Additional Points to Consider:</label><br>
        <textarea id="additionalPoints" name="additionalPoints" rows="5" cols="50"></textarea><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
