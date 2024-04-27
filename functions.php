<?php
// Function to fetch a random center from the database
function getRandomCenter($db) {
    $sql = "SELECT * FROM RecyclingCenter ORDER BY RAND() LIMIT 1";
    $result = mysqli_query($db, $sql);
    return mysqli_fetch_assoc($result);
}

// Function to fetch user's favorite center from the database
function getUserFavoriteCenter($db, $user_id) {
    $sql = "SELECT favorite_center FROM RecyclingCenter WHERE id = '$user_id'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['favorite_center'];
}