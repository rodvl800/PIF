<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="logo.png">
    <!-- <link rel="stylesheet" href="styles.css"/> -->
    <title>Register</title>
</head>
<body>
<?php
include 'nav-bar.php';
active(7);
include 'functions.php';
if ($_SESSION["UserLoggedIn"]) {
    header('location: qr.php');
}
$allCenters = getAllCenters($db);
?>

<h1>Here you can Sign In</h1>
<form method="POST" class="registration" id="registration-form">
	<div>
		<label for="Name">Name</label>
		<input type="text" name="Name" id="Name" required>
	</div>
    <div>

		<label for="UserName">Username</label>
		<input type="text" name="UserName" id="UserName" required>
	</div>
    <div>
        <label for="Email">Email</label>
        <input type="text" name="Email" id="Email" required>
    </div>
	<div>
		<label for="Password">Password</label>
		<input type="password" name="Password" id="Password" required>
	</div>
	<div>
		<label for="PasswordAgain">Repeat Password</label>
		<input type="password" name="PasswordAgain" id="PasswordAgain" required>
	</div>
	<div>
		<label for="Center">Favorite Center</label>
		<select name="Center" id="Center" required>
            <?php foreach($allCenters as $center): ?>
                <option value="<?php echo $center; ?>"><?php echo $center; ?></option>
            <?php endforeach; ?>
        </select>
	</div>
	<div class="register-button">
		<button type="submit" name="submit">Register
	</div>
	<p class="error-message" id="error-message"></p>
</form>

<?php

$errors = array(); //Array to push and display errors to the user
if (isset($_POST["submit"])) {
    $Name = mysqli_real_escape_string($db, $_POST['Name']);
    $UserName = mysqli_real_escape_string($db, $_POST['UserName']);
    $Email = mysqli_real_escape_string($db, $_POST['Email']);
    $Password = mysqli_real_escape_string($db, $_POST['Password']);
    $PasswordAgain = mysqli_real_escape_string($db, $_POST['PasswordAgain']);
    $Center = mysqli_real_escape_string($db, $_POST['Center']);


    // Make sure required fields are filled in
    if (empty($Name) || empty($UserName) || empty($Password) || empty($Email) || empty($Center)) {
        array_push($errors, "Fill in all the fields.");
    }
    else {
        // Use reusable functions as this action is initiated multiple times on different pages
        $errors = validateInput($Name, $UserName, $Password, $Email);
    }

    //Checking if the passwords in both fields are same or not
    if($Password != $PasswordAgain)
    {
        array_push($errors, "Passwords do not match.");
    }

	//Checking if the username is already taken
	$user_check_query = "SELECT * FROM users WHERE Username='$UserName' LIMIT 1";
	$result = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($result);
    if ($user["Username"] === $UserName) {
        array_push($errors, "Username already exists.");
    }



    //Register the user if there are no errors
    if (count($errors) == 0) {
        //encrypting the password
        $PasswordHashed = password_hash($Password, PASSWORD_DEFAULT);
        //Get center id by its name selected by user.
        $centerCodeQuery = "SELECT CenterCode FROM RecyclingCenter WHERE CenterName='$Center' LIMIT 1";
        $resultCenter = mysqli_query($db, $centerCodeQuery);
        $FavoriteCenterArray = mysqli_fetch_assoc($resultCenter);
        $FavoriteCenter = $FavoriteCenterArray["CenterCode"];
        //Finally registering the user
        $query = "INSERT INTO Users (Username, Name, Email, PasswordHash, RecCenterCode) VALUES ('$UserName', '$Name', '$Email','$PasswordHashed', '$FavoriteCenter')";
        mysqli_query($db, $query);
        //Checking if the user has been successfully registered by fetching in their details associated with the email
        $query = "SELECT * FROM Users WHERE Username = '$UserName'";
				$results = mysqli_query($db, $query);
                $UserData = mysqli_fetch_assoc($results);
            if ($results) {
                //Check maybe the user is Admin
                if ($UserData["IsAdmin"] == 1){
                    $_SESSION["IsAdmin"] = true;
                }
                //Logging in and sending user to his qr page
                $_SESSION["UserLoggedIn"] = true;
                $_SESSION["username"] = $UserName;
                header('location: qr.php');
            }
            else {
                array_push($errors, "Problem with database.");
            }
    }
}

// Show errors
if (!empty($errors)): ?>

<h3 style="color: red;">
	<ul>
      <?php foreach ($errors as $error): ?>
				<li><?php echo $error; ?></li>
      <?php endforeach; ?>
	</ul>
</h3>
<?php endif; ?>

</body>
</html>