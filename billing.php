<?php
include 'nav-bar.php';
active(8);
if (!$_SESSION["UserLoggedIn"]){
    header('location: login.php');
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Billing</title>
</head>
<body>
<main>
    <h1>Here is Your full billing history:</h1>
    <?php 
    include 'measurements.php';
    ?>
    </main>    
</body>
</html>