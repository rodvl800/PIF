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

// Function to fetch user's data
function getUserData($db, $username) {
    $sql = "SELECT * FROM Users WHERE Username = '$username'";
    $result = mysqli_query($db, $sql);
    return mysqli_fetch_assoc($result);
}

// FUNCTIONS TO CHECK INPUT DATA AS WE HAVE TO USE THEM TWICE

function validateInput($Name, $UserName, $Password, $Email) {
    $errors = [];
    var_dump($Name, $UserName, $Password, $Email);
    // Name can only contain letters.
    if (!preg_match("/^[A-Za-z]+$/", $Name)) {
        array_push($errors, "Name can only contain letters.");
    }
    // Username can only contain letters, numbers, and underscores
    if (!preg_match("/^[a-zA-Z0-9_]+$/", $UserName)) {
        array_push($errors, "Username can only contain letters, numbers, and underscores.");
    }

    // Validate email format using inbuilt function
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format.");
    }

    // Validate password strength (as for now, it has to be longer than 4 characters and contain at least 1 digit)
    if (strlen($Password) <= 4 || !preg_match("/[0-9]/", $Password)) {
        array_push($errors, "Password must be longer than 4 characters and contain at least 1 digit.");
    }

    return $errors;
}