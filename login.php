<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="master.css" />
    <link rel="icon" type="image/png" href="photos/logo.png">
    <title>Login</title>
</head>
<body>
<?php
include 'nav-bar.php';
$errors_login = array();


if (isset($_SESSION["UserLoggedIn"])) {
//pass
} else {
	$_SESSION["UserLoggedIn"] = false;
}


if (!$_SESSION["UserLoggedIn"]) {
	?>
	<form method="POST" class="registration" id="registration-form">
		<label><?php echo callLocalisation($language, 11);?>
			<input type="text" name="username">
		</label><br>
		<label><?php echo callLocalisation($language, 12);?>
			<input type="password" name="password">
		</label><label></label><br>
			<button type="submit" value="Login" name="Login"><?php echo callLocalisation($language, 13);?></button>
	</form>
<?php
}
else if ($_SESSION["UserLoggedIn"] && $_SESSION["isAdmin"]) {
	header('location: admin.php?page=admin');
}
else {
	header('location: cart.php?page=cart');
}

if (isset($_POST["Login"])) {
		// Fetch and validate user inputs
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		$query = "SELECT * FROM users WHERE username = ?";
		$stmt = mysqli_prepare($db, $query);
		mysqli_stmt_bind_param($stmt, "s", $username);
		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);

		if ($user_data_row = mysqli_fetch_assoc($result)) {
				if (password_verify($password, $user_data_row['password_hash'])) {
						$_SESSION["UserLoggedIn"] = true;
						$_SESSION["username"] = $username;
						if ($user_data_row["isAdmin"]) {
							$_SESSION["isAdmin"] = true;
							header('location: admin.php?page=admin'); // Successful login as admin
						}
						else {
							$_SESSION["isAdmin"] = false;
							header('location: cart.php?page=cart'); // Successful login
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