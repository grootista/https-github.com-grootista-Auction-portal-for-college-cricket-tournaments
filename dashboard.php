<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        /* Add custom styles */
        body {
            padding-top: 100px; /* Adjust the top padding for the fixed navbar */
        }

        /* Style the button */
        .button {
            background-color: #8bc34a; /* Light green color */
            color: #ffffff; /* White text color */
            padding: 15px 30px; /* Adjust padding as needed */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        /* Add hover effect */
        .button:hover {
            background-color: #689f38; /* Darker green color on hover */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top"> <!-- Add fixed-top class for a fixed navbar -->
    <div class="container">
        <a class="navbar-brand" href="profile.php">Profile</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="penauctions.php">My Auctions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class="container mt-5">
    <?php
    session_start();

    // Check if the user is logged in
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        // Now you can access and display the username
        $usn = strtoupper($_SESSION['username']);

        // Display the username within a <strong> tag
        echo '<h1 class="mb-3">Welcome, <strong>' . $usn . '</strong>!</h1>';
        //echo '<div><h3>Please fill in the details of your tournament.</h3></div>';

        // Database connection
        include "connect.php";

        if (!$conn) {
            die("Sorry, cannot connect right now");
        } else {
            // Query to count pending auctions for the current user
            $sql = "SELECT * FROM coordinators WHERE usn = '$usn' AND status = 0";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo '<h2>Pending Auctions</h2>';
                $pendingCount = 0;
                echo '<ul>';

                while ($row = mysqli_fetch_assoc($result)) {
                    $eventid = $row['eventid'];
                    $eventName = $row['eventname'];

                    // Generate a link to view the details of the pending auction
                    echo '<h3><li><a href="pending.php?eventid=' . $eventid . '">' . $eventName . '</a></li></h3>';
                    $pendingCount++;
                }

                echo '</ul>';
               // echo '<p>Pending Count: ' . $pendingCount . '</p>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error: ' . mysqli_error($conn) . '</div>';
            }

            // Close the database connection
            mysqli_close($conn);
        }
    }
    ?>

    <br>
    <br>
    <br>
    <a href="actform.php" class="button mb-3">Add New Auction</a>
</div>

   
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
