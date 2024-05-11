<?php
// Include nav-bar connection and functions
include 'nav-bar.php';
include 'functions.php';


// Fetch random center details
$random_center = getRandomCenter($db);
$_SESSION["CenterName"] = $random_center['CenterName'];

// If user is logged in, fetch user's favorite center
if(isset($_SESSION['username'])) {
    $favorite_center = getUserFavoriteCenter($db, $_SESSION['username']);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="logo.png">
    <title>Home</title>
</head>
<body>
<main>
    <h1>Welcome to LPEM Recycling Centers</h1>
    <?php if(!$_SESSION['UserLoggedIn']){ ?>
    <div class="center-details">
        <h2>Random center details:</h2>
        <h3><b>Name: </b><?php echo $random_center['CenterName']; ?></h3>
        <p><b>Code: </b><?php echo $random_center['CenterCode']; ?></p>
        <p><b>Address: </b><?php echo $random_center['Address']; ?></p>
        <p><b>Time opened: </b><?php echo $random_center['Open']; ?></p>
        <p><b>Time closed: </b><?php echo $random_center['Close']; ?></p>
        <h3>Login to see your favorite center</h3>
        <button onclick="window.location.reload();"><h3>Or display another center information</h3></button>
    </div>

    <?php } else { ?>
        <div class="favorite-center">
            <h2>Favorite Center</h2>
            <h3>Name: <?php echo $favorite_center['CenterName']; ?></h3>
            <p><b>Code: </b><?php echo $favorite_center['CenterCode']; ?></p>
            <p><b>Address: </b><?php echo $favorite_center['Address']; ?></p>
            <p><b>Time opened: </b><?php echo $favorite_center['Open']; ?></p>
            <p><b>Time closed: </b><?php echo $favorite_center['Close']; ?></p>
        </div>
    <?php } ?>
</main>
</body>
</html>
