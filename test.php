<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Player Fetch</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Style for the fixed-size container */
        #imageContainer {
            width: 200px; /* Set your desired width */
            height: 200px; /* Set your desired height */
            overflow: hidden; /* Hide any image overflow beyond the container */
        }

        /* Style for the player image */
        #playerImage {
            width: 100%; /* Ensure the image fits within the container */
        }
    </style>
</head>
<body>
    <h1>Test Player Fetch</h1>
    <!-- Fixed-size container for the player image -->
<div id="imageContainer">
    <img id="playerImage" src="" alt="Player Image">
    </div>
                <p><strong>Name:</strong> <span id="playerName"></span></p>
                            <p><strong>Branch:</strong> <span id="playerBranch"></span></p>
                <p><strong>Year:</strong> <span id="playerYear"></span></p>
                <p><strong>Role:</strong> <span id="playerRole"></span></p>
    </div>

    <script>
        // Function to fetch and display a random player
        function fetchRandomPlayer() {
            // Make an AJAX request to your PHP script
            fetch('fetchplayer.php')
                .then(response => response.json())
                .then(player => {
                    // Display the random player data in your player window
                    if (player) {
                        // Construct the full image URL
                        const imageUrl = player.image_url.toLowerCase();
                        //console.log('Image URL:', imageUrl);

                        // Set the src attribute of the image based on the file extension
                        if (imageUrl.endsWith('.jpg') || imageUrl.endsWith('.jpeg') || imageUrl.endsWith('.png')) {
                            document.getElementById('playerImage').src = imageUrl;
                        } else {
                            // Handle unsupported file types or other cases
                            console.error('Unsupported image format:', imageUrl);
                        }

                        document.getElementById('playerName').textContent = player.Name;
                        document.getElementById('playerBranch').textContent = player.Branch;
                        document.getElementById('playerYear').textContent = player.Year + ' Year';
                        document.getElementById('playerRole').textContent = player.role;
                    } else {
                        // Display a message if no more players are available
                        document.getElementById('playerImage').src = '';
                        document.getElementById('playerName').textContent = 'No more players available.';
                        document.getElementById('playerBranch').textContent = '';
                        document.getElementById('playerYear').textContent = '';
                        document.getElementById('playerRole').textContent = '';
                    }
                })
                .catch(error => console.error(error));
        }

        // Call the fetchRandomPlayer function to load a random player initially
        fetchRandomPlayer();
    </script>
</body>
</html>
