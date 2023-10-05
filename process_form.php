
<?php
session_start();
$usn="";
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    //Now you can access and display the username
    // $username = $_SESSION['uname'];
    $usn=strtoupper($_SESSION['username']);
   

}
$tname = "";
$totalPlayersRegistered = 0;
$isButtonDisabled = true;



// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle form submission and process other form fields

    // Get the selected auction start date from the form
    $tname = $_POST["tournamentName"];
    $selectedStartDate = $_POST["auctionDate"];
    $noteams=$_POST["numTeams"];
    $eventid=strtoupper($_POST["eventID"]);
    $eventdate=$_POST["auctionDate"];
    $status=false;
    $maxpoints=$_POST["maxPoints"];
    $maxplayers=$_POST["maxPlayers"];
    $basePrice=$_POST["basePrice"];
    

    // Convert the selected start date to a Unix timestamp
    $selectedTimestamp = strtotime($selectedStartDate);

    // Get the current timestamp
    $currentTimestamp = time();

    // Calculate the timestamp for 12 AM on the selected start date
    $startTimestamp = strtotime(date("Y-m-d", $selectedTimestamp) . " 00:00:00");

    // Check if the current timestamp is greater than or equal to the start timestamp
    if ($currentTimestamp >= $startTimestamp) {
        // The auction can start, enable the button
        $isButtonDisabled = false;
    }
    include "connect.php";
    
   
   if (!$conn) {
    die("Sorry, cannot connect right now");
   }else{
    $checkQuery = "SELECT * FROM `coordinators` WHERE `eventid` = '$eventid'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) === 0) {
            // echo '<div class="alert alert-success fixed-top w-100 text-center" style="display: block;background-color:#efe2e2;">Auction with same !<a href="/phplearn/php/login.php" class="alert-link">Try logging in.</a></div>';
            $sql = "INSERT INTO `coordinators`( `Eventname`, `NoOfTeams`,`usn`,`eventdate`,`eventid`,`status`,`maxpoints`,`maxplayers`,`baseprice`) VALUES ('$tname','$noteams','$usn','$eventdate','$eventid','$status','$maxpoints','$maxplayers','$basePrice')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                //echo "done"; 
                
               } else {
                echo '<div class="alert alert-danger" role="alert">Error: ' . mysqli_error($conn) . '</div>';
         }
        }
        else {
           echo  '<div class="alert alert-danger text-center" role="alert">
    <strong>Error:</strong> An auction with the same event ID is already pending!<br>
    Please complete or cancel the existing auction before creating a new one.
    <br><br>
    <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
</div>';

            exit;        }
         
      
   }
 $conn->close();
include "brdp.php";
if(!$conn){
    die("Sorry, Cannot connect right now");
   }
   else{$sql = "SELECT COUNT(*) as count FROM players";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row["count"];
        $totalPlayersRegistered=$count;
    } else {
        echo "No entries found in the table.";
    }

   }
}
    // This block is executed when the form is not submitted

    // Fetch $eventid from the database based on the user's session information
    

// Calculate the time left until the auction starts
$timeLeft = $startTimestamp - $currentTimestamp;

// Format the time left as hours, minutes, and seconds
$hoursLeft = floor($timeLeft / 3600);
$minutesLeft = floor(($timeLeft % 3600) / 60);
$secondsLeft = $timeLeft % 60;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Auction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        p {
            font-size: 18px;
            color: #555;
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
            color: #333;
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
            appearance: none;
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
    <h1><?php echo $tname; ?> Auction</h1>
    <section>
        <p>You can share this form among players to register for auction:</p>
        <a href="plform/playerform.php" target="_blank">Player Registration Form</a>

    </section>

    <p style="font-size: 24px; color: #007bff;">Total Players Registered for Auction: <?php echo $totalPlayersRegistered; ?></p>

    <!-- Display the time left until the auction starts -->
    <?php if ($isButtonDisabled) { ?>
        <p style="font-size: 18px; color: #555;">Time Left: <?php echo $hoursLeft; ?> hours <?php echo $minutesLeft; ?> minutes <?php echo $secondsLeft; ?> seconds</p>
    <?php } ?>

    <!-- Conditionally enable or disable the button based on the calculated value -->
    <form action="auctionportal.php" method="post">
        <?php if ($isButtonDisabled) { ?>
            <p style="font-size: 18px; color: #555;">The auction will start on <?php echo $selectedStartDate; ?> . Please wait until then.</p>
            <button type="button" disabled style="background-color: #ccc; color: #555; cursor: not-allowed;">Start Auction</button>
        <?php } else { ?>
            <p style="font-size: 18px; color: #555;">The auction is ready to start!</p>
            <button type="submit" name="startAuction" style="background-color: #007bff; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Start Auction</button>
        <?php } ?>
       
        <script>
    document.getElementById('startAuction').addEventListener('click', function() {
        // Pass the eventID as a query parameter
        window.location.href = 'auctionportal.php';
    });
</script>

        
    </form>
</body>

</html>
