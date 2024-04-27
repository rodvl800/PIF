<?php
// Include nav-bar connection and functions
include 'nav-bar.php';
include 'functions.php';


// Fetch random center details
$random_center = getRandomCenter($db);

// If user is logged in, fetch user's favorite center
$favorite_center = '';
if(isset($_SESSION['user_id'])) {
    $favorite_center = getUserFavoriteCenter($db, $_SESSION['user_id']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
<main>
    <h1>Welcome to LPEM Recycling Centers</h1>
    <div class="center-details">
        <h2>Random center Details:</h2>
        <p><?php echo $random_center['CenterCode']; ?></p>
        <p><?php echo $random_center['Address']; ?></p>
        <p><?php echo $random_center['Open']; ?></p>
        <p><?php echo $random_center['Close']; ?></p>
    </div>
    <?php if(isset($_SESSION['user_id'])): ?>
        <div class="favorite-center">
            <h2>Favorite Center</h2>
            <p><?php echo $favorite_center; ?></p>
        </div>
    <?php endif; ?>
</main>
</body>
</html>
