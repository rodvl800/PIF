<?php
// Function to fetch a random center from the database
function getRandomCenter($db) {
    $sql = "SELECT * FROM RecyclingCenter ORDER BY RAND() LIMIT 1";
    $result = mysqli_query($db, $sql);
    $RandomArr = mysqli_fetch_assoc($result);
    return $RandomArr;
}

// Function to fetch user's favorite center from the database
function getUserFavoriteCenter($db, $Username) {
    $sql = "SELECT * FROM RecyclingCenter WHERE CenterCode = (SELECT RecCenterCode FROM Users WHERE Username ='$Username')";
    $result = mysqli_query($db, $sql);
    return mysqli_fetch_assoc($result);
}