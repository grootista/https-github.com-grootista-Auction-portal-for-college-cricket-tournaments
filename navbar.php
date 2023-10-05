<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Auction Portal</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="auctionportal.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="teams.php">Teams</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Players
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="allplayers.php">All</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="soldplayers.php">Sold</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="unsoldplayers.php">Unsold</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                    <div class="nav-item">
    <button class="btn btn-danger position-absolute top-0 end-10" style="right: 0;" onclick="endAuction()">End Auction</button>
</div>
                </ul>
                
                <!-- Larger Instruction Icon -->
                <a href="#" class="nav-link" id="instructionIcon" data-toggle="popover" title="Instructions" data-content="Here are some instructions for the Auction Portal." style="font-size: 24px;">🛈</a>
            </div>
        </div>
    </nav>