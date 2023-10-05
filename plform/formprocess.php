
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection code here (replace with your database credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "browse";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $name = $_POST['name'];
    $branch = $_POST['branch'];
    $year = $_POST['year'];
    $usn = strtoupper($_POST['usn']);
    $speciality = $_POST['role'];
    $phone = $_POST['phone'];
    $status=false;
    
    // Handle image upload
    $image_name=$_FILES['image']['name'];
    $tempname=$_FILES['image']['tmp_name'];
    $folder="plimages/" .$image_name;
    move_uploaded_file($tempname,$folder);
        $checkQuery = "SELECT * FROM `players` WHERE `usn` = '$usn'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo '<div class="alert alert-failure fixed-top w-1000 text-center" style="display: block;background-color:#efe2e2;">User with same USN already exists! Contact Your Co-ordinator</div>';
        } else {
            // $sqlInsertPlayer = "INSERT INTO players (name, usn , branch, year, phone, role, image)
            // VALUES (?, ?, ?, ?, ?, ?, '$imageData')";
            // $stmt = $conn->prepare($sqlInsertPlayer);
            // $stmt->bind_param("ssssss", $name, $usn, $branch, $year, $phone, $speciality);
            $sqlInsertPlayer = "INSERT INTO players (name, usn , branch, year, phone, role, image,status)
            VALUES (?, ?, ?, ?, ?, ?, ?,?)";
            $stmt = $conn->prepare($sqlInsertPlayer);
            $stmt->bind_param("ssssssss", $name, $usn, $branch, $year, $phone, $speciality, $folder,$status);


            if ($stmt->execute()===TRUE) {
                // Redirect to confim.php with usn as a parameter
                header("location:thankyou.php");
                exit;
            } else {
                echo "Error inserting player details and image: " . $stmt->error;
            }
        }
    

    // Close the database connection
    $conn->close();
}
?>
