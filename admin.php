<?php
include 'nav-bar.php';
active(5);
if (!$_SESSION["UserLoggedIn"]){
    header('location: login.php');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="logo.png">
    <title>Admin</title>
</head>
<body>

<h1>This is Admin</h1>
</body>
</html>