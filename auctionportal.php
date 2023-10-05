<?php
$eventID = $_POST['eventID'];
?>
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
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


</head>
<body>
    <!-- Your navigation bar here -->
    <?php include "navbar.php"; ?>
   
    <div class="container mt-4">
        <!-- Player Window for Bidding -->
        <div class="card">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img id="playerImage" src="" class="card-img player-image" alt="Player Image">
                </div>
                <div class="col-md-8">
                    <div class="card-body player-details">
                        <h5 id="playerName" class="card-title"></h5>
                        <p class="card-text">Branch: <span id="playerBranch"></span></p>
                        <p class="card-text">Year: <span id="playerYear"></span></p>
                        <p class="card-text">Role: <span id="playerRole"></span></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Base Price: 2 points</li>
                        <li class="list-group-item">Current Bid: <span id="currentBid">0</span></li>
                        <li class="list-group-item increase-bid-container">
                            <span class="increase-bid-label">Increase Bid:</span>
                            <button class="btn btn-sm btn-secondary increase-bid-btn" onclick="decreaseBidAmount()">-</button>
                            <span id="increaseBidAmount">1</span>
                            <button class="btn btn-sm btn-secondary increase-bid-btn" onclick="increaseBiddAmount()">+</button>
                        </li>
                    </ul>
                    <div class="card-body button-group">
                        <button id="closeBidBtn" class="btn btn-danger">Close Bid</button>
                        <button onclick="loadNextPlayer()" class="btn btn-primary">Next Player</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Buttons -->
        <div class="card mt-4">
            <div class="card-body team-buttons">
                <div>
                    <button class="btn btn-primary team-btn" onclick="updateBid(1)">Team 1</button>
                    <button class="btn btn-primary team-btn" onclick="updateBid(2)">Team 2</button>
                    <button class="btn btn-primary team-btn" onclick="updateBid(3)">Team 3</button>
                    <button class="btn btn-primary team-btn" onclick="updateBid(4)">Team 4</button>
                </div>
                <p id="teamBid" class="bid-info"></p>
            </div>
        </div>
    </div>
    <div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel">Auction Result</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="resultMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="proceedBtn">Proceed</button>
            </div>
        </div>
    </div>
</div>
<!-- End Auction button -->




<!-- JavaScript for handling the End Auction button -->
<script>
    function endAuction() {
    // Pass the eventID as a query parameter to coordinator.php
    window.location.href = 'coordinator.php?eventID=<?php echo $eventID; ?>';
}

</script>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- JavaScript for Player Bidding -->
    <script>
        let baseprice = 2;
        let currentBid = 0;
        let increaseBidAmount = 1;
        let lastBidTeam = null;
        let lastBidAmount = 0;
        let playerName = null;
        let usn = null;
        
        document.getElementById('closeBidBtn').disabled = true;

        function updateBid(team) {
            if (currentBid == 0) {
                document.getElementById('closeBidBtn').disabled = false;
                currentBid = baseprice;
                document.getElementById('currentBid').textContent = currentBid;
                document.getElementById('teamBid').textContent = `Current bid by Team ${team}: for ${currentBid} points`;
                lastBidTeam = team;
                lastBidAmount = currentBid;
            } else {
                currentBid += increaseBidAmount;
                document.getElementById('currentBid').textContent = currentBid;
                document.getElementById('teamBid').textContent = `Current bid by Team ${team}: for ${currentBid} points`;
                lastBidTeam = team;
                lastBidAmount = currentBid;
            }
        }

        function showResultModal(message) {
            document.getElementById('resultMessage').textContent = message;
            $('#resultModal').modal('show');
          
        }

        function closeResultModal() {
            $('#resultModal').modal('hide');
        }

        function closeBid() {
    if (lastBidAmount == 0) {
        showResultModal("Player went unsold.");
    } else {
        const data = new FormData();
        data.append('usn', usn);
        data.append('soldToTeam', lastBidTeam);
        data.append('bidAmount', lastBidAmount);

        axios.post('soldinsert.php', data)
            .then(function (response) {
                if (response.data.status === 'success') {
                    showResultModal(`${playerName} sold to Team ${lastBidTeam} for ${lastBidAmount} points.`);
                } else if (response.data.status === 'error_update') {
                    showResultModal('Error updating player status.');
                } else if (response.data.status === 'error_insert') {
                    showResultModal('Error inserting sold player data.');
                } else {
                    showResultModal('Unknown error.');
                }
            })
            .catch(function (error) {
                console.error(error);
                showResultModal('An error occurred while processing the request.');
            });
    }
   // fetchRandomPlayer();

    // Reset variables
    // currentBid = 0;
    // lastBidTeam = null;
    // lastBidAmount = 0;
    // playerName = null;
    // usn = null;
    document.getElementById('closeBidBtn').disabled = true;
}


        // Handle the Proceed button click
        document.getElementById('proceedBtn').addEventListener('click', function() {
    closeResultModal();

    // Refresh the page after a brief delay (e.g., 3 seconds)
    setTimeout(function() {
        window.location.reload();
    }, 1000); // 3000 milliseconds (3 seconds)
});


        function decreaseBidAmount() {
            if (increaseBidAmount > 0) {
                increaseBidAmount -= 1;
                document.getElementById('increaseBidAmount').textContent = increaseBidAmount;
            }
        }

        function increaseBiddAmount() {
            if (increaseBidAmount < 50) {
                increaseBidAmount += 1;
                document.getElementById('increaseBidAmount').textContent = increaseBidAmount;
            }
        }

        function fetchRandomPlayer() {
            document.getElementById('currentBid').textContent = '';
            document.getElementById('teamBid').textContent = '';
          
            fetch('fetchplayer.php')
                .then(response => response.json())
                .then(player => {
                    if (player) {
                        const imageUrl = player.image_url.toLowerCase();
                        if (imageUrl.endsWith('.jpg') || imageUrl.endsWith('.jpeg') || imageUrl.endsWith('.png')) {
                            document.getElementById('playerImage').src = imageUrl;
                        } else {
                            console.error('Unsupported image format:', imageUrl);
                        }

                        document.getElementById('playerName').textContent = player.Name;
                        playerName = player.Name;
                        document.getElementById('playerBranch').textContent = player.Branch;
                        document.getElementById('playerYear').textContent = player.Year;
                        document.getElementById('playerRole').textContent = player.role;
                        usn = player.usn;
                    } else {
                        document.getElementById('playerImage').src = '';
                        document.getElementById('playerName').textContent = 'No more players available. You can check for unsold players and bid them again.';
                        document.getElementById('playerBranch').textContent = '';
                        document.getElementById('playerYear').textContent = '';
                        document.getElementById('playerRole').textContent = '';
                    }
                })
                .catch(error => console.error(error));
        }

        function loadNextPlayer() {
            if (lastBidAmount == 0) {
                showResultModal("Player went unsold.");
                
            
                const data = new FormData();
                 data.append('usn', usn);
       // data.append('soldToTeam', lastBidTeam);
       // data.append('bidAmount', lastBidAmount);

            axios.post('unsoldinsert.php', data)
            .then(function (response) {
                if (response.data.status === 'success') {
                    console.log("player inserted");
                } else if (response.data.status === 'error_update') {
                    showResultModal('Error updating player status.');
                }  else {
                    showResultModal('Unknown error.');
                }
            })
            .catch(function (error) {
                console.error(error);
                showResultModal('An error occurred while processing the request.');
            });
            
    
            }
        }

            
        

        document.getElementById('closeBidBtn').addEventListener('click', closeBid);

        fetchRandomPlayer(); // Load a random player initially
    </script>
</body>
</html>
