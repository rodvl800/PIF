<!doctype html>
    <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="master.css" />
    <link rel="icon" type="image/png" href="logo.png">
    <title>Login</title>
</head>
<body>
<?php
include 'nav-bar.php';
active(6);
$errors_login = array();

if (isset($_SESSION["UserLoggedIn"])) {
//pass
} else {
	$_SESSION["UserLoggedIn"] = false;
}

if (!$_SESSION["UserLoggedIn"]) {
	?>
    <h1>Here you can Log In</h1>
	<form method="POST" class="registration" id="registration-form">
        <div>
            <label for="UserName">Username</label>
            <input type="text" name="UserName" id="UserName" required>
        </div>
        <div>

            <label for="UserName">Password</label>
            <input type="text" name="Password" id="Password" required>
        </div>
        <div class="register-button">
			<button type="submit" value="Login" name="Login">Login</button>
        </div>
	</form>

<?php
}
else if ($_SESSION["UserLoggedIn"] && $_SESSION["isAdmin"]) {
	header('location: admin.php?page=admin');
}
else {
	header('location: qr.php?page=qr');
}

if (isset($_POST["Login"])) {
		// Fetch and validate user inputs
		$username = mysqli_real_escape_string($db, $_POST['UserName']);
		$password = mysqli_real_escape_string($db, $_POST['Password']);

		$query = "SELECT * FROM Users WHERE Username = ?";
		$stmt = mysqli_prepare($db, $query);
		mysqli_stmt_bind_param($stmt, "s", $username);
		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);

		if ($user_data_row = mysqli_fetch_assoc($result)) {
				if (password_verify($password, $user_data_row['PasswordHash'])) {
						$_SESSION["UserLoggedIn"] = true;
						$_SESSION["username"] = $username;
						if ($user_data_row["IsAdmin"] == 1) {
							$_SESSION["isAdmin"] = true;
							header('location: admin.php?page=admin'); // Successful login as admin
						}
						else {
							$_SESSION["isAdmin"] = false;
							header('location: qr.php?page=qr'); // Successful login
						}						
						exit();
				} else {
						array_push($errors_login, "Wrong password. Please try again.");
				}
		} else {
        array_push($errors_login, "Username not found. Do you want to <a href='register.php'>register</a>?");
		}

		mysqli_stmt_close($stmt);
}


if (!empty($errors_login)): ?>
<h3 style="color: red;">
	<ul>
      <?php foreach ($errors_login as $error): ?>
				<li><?php echo $error; ?></li>
      <?php endforeach; ?>
	</ul>
	  </h3>
<?php endif; ?>
</body>
</html>