<?php
include 'nav-bar.php';
include 'functions.php';
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
    <title>Profile</title>
</head>
<body>
<?php
    $userData =getUserData($db, $_SESSION["username"]);
?>
<main>
<h1>Here you can see and change your data, <?php echo $_SESSION["username"]?></h1>

    <div class="user-details">
        <h3><b>Current name: </b><?php echo $userData['Name'];?> <button type="submit" name="changeName">Change</h3>
        <h3><b>Current username: </b><?php echo $userData['Username'];?> <button type="submit" name="changeUsername">Change</h3></h3>
        <h3><b>Current email: </b><?php echo $userData['Email'];?> <button type="submit" name="changeEmail">Change</h3></h3>
        <h3><b>Current password: </b>******** <button type="submit" name="changePassword">Change</h3></h3>
        <h3><b>Current favorite center: </b><?php echo $_SESSION["CenterName"]?> <button type="submit" name="changeCenter">Change</h3></h3>
    </div>

    <?php
    function SendQuerry() {

    }
    ?>




<!--<form method="POST" class="registration" id="registration-form">-->
<!--    <div>-->
<!--        <label for="Name">Name</label>-->
<!--        <input type="text" name="Name" id="Name" required>-->
<!--    </div>-->
<!--    <div>-->
<!---->
<!--        <label for="UserName">Username</label>-->
<!--        <input type="text" name="UserName" id="UserName" required>-->
<!--    </div>-->
<!--    <div>-->
<!--        <label for="Email">Email</label>-->
<!--        <input type="text" name="Email" id="Email" required>-->
<!--    </div>-->
<!--    <div>-->
<!--        <label for="Password">Password</label>-->
<!--        <input type="password" name="Password" id="Password" required>-->
<!--    </div>-->
<!--    <div>-->
<!--        <label for="PasswordAgain">Repeat Password</label>-->
<!--        <input type="password" name="PasswordAgain" id="PasswordAgain" required>-->
<!--    </div>-->
<!--    <div>-->
<!--        <label for="Center">Favorite Center</label>-->
<!--        <select name="Center" id="Center" required>-->
<!--            <option value="Luxembourg-City">Luxembourg-City</option>-->
<!--            <option value="Luxembourg-Gare">Luxembourg-Gare</option>-->
<!--            <option value="Esch">Esch</option>-->
<!--        </select>-->
<!--    </div>-->
<!--    <div class="register-button">-->
<!--        <button type="submit" name="submit">Change-->
<!--    </div>-->
<!--    <p class="error-message" id="error-message"></p>-->
<!--</form>-->



<?php
$errors = array(); //Array to push and display errors to the user
if (isset($_POST["submit"])) {
    $Name = mysqli_real_escape_string($db, $_POST['Name']);
    $UserName = mysqli_real_escape_string($db, $_POST['UserName']);
    $Email = mysqli_real_escape_string($db, $_POST['Email']);
    $Password = mysqli_real_escape_string($db, $_POST['Password']);
    $PasswordAgain = mysqli_real_escape_string($db, $_POST['PasswordAgain']);
    $Center = mysqli_real_escape_string($db, $_POST['Center']);


    if (empty($Name) || empty($UserName) || empty($Password) || empty($Email) || empty($Center)) {
        array_push($errors, "Fill in all the fields.");
    } else {
        // Use reusable functions as this action is initiated multiple times on different pages
        $errors = validateInput($Name, $UserName, $Password, $Email);

        //Checking if the passwords entered in both fields are same or not
        if ($Password != $PasswordAgain) {
            array_push($errors, "Passwords do not match.");
        }
    }

    if (count($errors) == 0) {


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
</main>
</body>
</html>