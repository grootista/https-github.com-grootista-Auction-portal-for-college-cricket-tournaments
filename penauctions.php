<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Add your CSS styles here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
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

        h2 {
            color: #333;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
        }

        a {
            text-decoration: none;
            color: #9197b9;
        }

        a:hover {
            text-decoration: underline;
        }

        .pending {
            background-color: #ebd571;
            padding: 10px;
            border-radius: 5px;
        }

        .completed {
            background-color: #28a745;
            padding: 10px;
            border-radius: 5px;
        }

        .error {
            background-color: #dc3545;
            color: #fff;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
        }

        .welcome {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <?php
    session_start();

    // Check if the user is logged in
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        // Now you can access and display the username
        $usn = strtoupper($_SESSION['username']);

        // Display the username within a <strong> tag
        echo '<h1>Welcome, <strong>' . $usn . '</strong>!</h1>';
        // Database connection
        include "connect.php";

        if (!$conn) {
            die("Sorry, cannot connect right now");
        } else {
            // Query to count pending auctions for the current user
            $sqlPending = "SELECT * FROM coordinators WHERE usn = '$usn' AND status = 0";
            $resultPending = mysqli_query($conn, $sqlPending);

            // Query to retrieve completed auctions for the current user
            $sqlCompleted = "SELECT * FROM coordinators WHERE usn = '$usn' AND status = 1";
            $resultCompleted = mysqli_query($conn, $sqlCompleted);

            if ($resultPending || $resultCompleted) {
                echo '<div class="welcome"><h2>Your Auctions:</h2></div>';
                $pendingCount = 0;
                
                if (mysqli_num_rows($resultPending) > 0) {
                    echo '<h2 class="pending">Pending Auctions:</h2>';
                    
                    echo '<ul>';

                    while ($row = mysqli_fetch_assoc($resultPending)) {
                        $eventid = $row['eventid'];
                        $eventName = $row['eventname'];

                        // Generate a link to view the details of the pending auction
                        echo '<li><a class="pending" href="pending.php?eventid=' . $eventid . '">' . $eventName . '</a></li>';
                        $pendingCount++;
                    }
                    echo '<p>Total Pending auctions: ' . $pendingCount . '</p>';

                    echo '</ul>';
                } else {
                    echo '<p>No pending auctions.</p>';
                }
                echo '<h2 class="completed">Completed Auctions:</h2>';
                if (mysqli_num_rows($resultCompleted) > 0) {
                   
                    echo '<ul>';

                    while ($row = mysqli_fetch_assoc($resultCompleted)) {
                        $eventName = $row['eventname'];

                        // Display the names of completed auctions
                        echo '<li><span class="completed">' . $eventName . '</span></li>';
                    }

                    echo '</ul>';
                } else {
                    echo '<p>No completed auctions.</p>';
                }

               
            } else {
                echo '<div class="error">Error: ' . mysqli_error($conn) . '</div>';
            }

            // Close the database connection
            mysqli_close($conn);
        }
    } else {
        // Redirect to the login page if not logged in
        header("Location: login.php");
    }
    ?>
</div>
</body>
</html>
