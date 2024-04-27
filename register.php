<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <link rel="stylesheet" href="styles.css"/> -->
    <link rel="icon" type="image/png" href="photos/logo.png">
    <title>Register</title>
</head>
<body>
<?php
include 'nav-bar.php';
if ($_SESSION["UserLoggedIn"]) {
    header('location: qr.php');
}
?>

<H1>Here you can Sign In</H1>
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
			<option value="Luxembourg-City">Luxembourg-City</option>
			<option value="Luxembourg-Gare">Luxembourg-Gare</option>
			<option value="Esch">Esch</option>
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
    //checking if the passwords entered in both fields are same or not
    if($Password != $PasswordAgain)
    {
        array_push($errors, "Passwords do not match.");
    }

	//checking if the username is already taken
	$user_check_query = "SELECT * FROM users WHERE Username='$UserName' LIMIT 1";
	$result = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($result);
		if ($user["Username"] === $UserName) {
			array_push($errors, "Username already exists.");
		}

    //register the user if there are no errors
    if (count($errors) == 0) {
        //encrypting the password
        $PasswordHashed = password_hash($Password, PASSWORD_DEFAULT);
        //Get center id by it's name selected by user.
        $centerCodeQuery = "SELECT CenterCode FROM RecyclingCenter WHERE CenterName='$Center' LIMIT 1";
        $resultCenter = mysqli_query($db, $centerCodeQuery);
        $FavouriteCenterArray = mysqli_fetch_assoc($resultCenter);
        $FavouriteCenter = $FavouriteCenterArray["CenterCode"];
        //finally registering the user
        $query = "INSERT INTO Users (Username, Name, PasswordHash, RecCenterCode) VALUES ('$UserName', '$Name', '$PasswordHashed', '$FavouriteCenter')";
        mysqli_query($db, $query);
        //checking if the user has been successfully registered by fetching in their details associated with the email
        $query = "SELECT * FROM Users WHERE Username = '$UserName'";
				$results = mysqli_query($db, $query);
                $UserData = mysqli_fetch_assoc($results);
            if ($results) {
                //Check maybe the user is Admin
                if ($UserData["IsAdmin"] == 1){
                    $_SESSION["IsAdmin"] = true;
                }
                //logging in and sending user to his qr page
                $_SESSION["UserLoggedIn"] = true;
                $_SESSION["username"] = $UserName;
                header('location: qr.php');
            }
            else{
                array_push($errors, "Problem with database.");
            }
    }
}
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