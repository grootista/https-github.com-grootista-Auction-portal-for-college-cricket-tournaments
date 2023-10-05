<?php
// Check if the eventID query parameter is set
if (isset($_GET['eventID'])) {
    // Retrieve the eventID value from the query parameter
    $eventID = $_GET['eventID'];

    // Now, you can use the $eventID variable for further processing
   include "connect.php";
   if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    $updateTeamSQL = "UPDATE coordinators SET status=1 WHERE eventid = '$eventID'";
        
        if ($conn->query($updateTeamSQL) === TRUE) {
            //echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error_update_team'));
        }
}
} else {
    // Handle the case where eventID is not set
    echo "Event ID not found in the query parameter.";
}
?>

<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>End Auction</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="vh-100 d-flex justify-content-center align-items-center">
            <div>
                <div class="mb-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75"
                        fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                </div>
                <div class="text-center">
                    
                    <p>Auction conducted successfully!! </p>
                    <p>You can download the auction data by clicking the below button</P>
                    <button class="btn btn-primary" id="report">Genrate Report</button>
                    <button class="btn btn-primary" id="returnButton">CLOSE</button>

<script>
document.getElementById('returnButton').addEventListener('click', function() {
    // Redirect to playerform.php
    tab.close();
});
document.getElementById('report').addEventListener('click', function() {
    // Redirect to playerform.php
    window.location.href = 'report.php';
});
</script>


                </div>
            </div>
    </body>

</html>
