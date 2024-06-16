<?php
include 'nav-bar.php';
active(4);
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
    $allCenters = getAllCenters($db);
?>
<main>
    <div class="form-container">
    <h1>Here you can see and change your data, <?php echo $_SESSION["username"]?></h1>
    <form method="post">
    <div class="form-group">
        <label for="name">Current name: <?php echo $userData['Name'];?></label>
        <input type="text" name="newName" placeholder="Change your name" >
        <input type="submit" value="Change" name="changeName">
    </div>
    <div class="form-group">
        <label for="username">Current username: <?php echo $userData['Username'];?></label>
        <input type="text" name="newUsername" placeholder="Change your username" >
        <input type="submit" value="Change" name="changeUsername">
    </div>
    <div class="form-group">
        <label for="email">Current email: <?php echo $userData['Email'];?></label>
        <input type="text" name="newEmail" placeholder="Change your email" >
        <input type="submit" value="Change" name="changeEmail">
    </div>
    <div class="form-group">
        <label for="password">Current password: ****</label>
        <input type="password" name="newPassword" placeholder="Change your password" >
        <input type="submit" value="Change" name="changePassword">
    </div>
    <div class="form-group">
        <label for="center">Current favorite center: <?php echo $_SESSION["CenterName"]?></label>

        <div>
            <select name="newCenter" id="Center" required>
                <?php foreach($allCenters as $center): ?>
                    <option placeholder="Change your center" value="<?php echo $center; ?>"><?php echo $center; ?></option>
                <?php endforeach; ?>
            </select>
	    </div>
        <input type="submit" value="Change" name="changeCenter" class="submit-button">
    </div>
    </form>
</div>



    
    <?php
    $errors = array(); //Array to push and display errors to the user
    
    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $Name = mysqli_real_escape_string($db, $_POST['newName']);
        $UserName = mysqli_real_escape_string($db, $_POST['newUsername']);
        $Email = mysqli_real_escape_string($db, $_POST['newEmail']);
        $Password = mysqli_real_escape_string($db, $_POST['newPassword']);
    
    
            // Use reusable functions as this action is initiated multiple times on different pages
            $errors = validateInput($Name, $UserName, $Password, $Email);
    
    
        if (count($errors) == 0) {
            if (isset($_POST['changeName'])) {
                $typeData = "Name";
                $typeInput = "newName";
                $newData = $_POST['newName'];
            }
            if (isset($_POST['changeUsername'])) {
                $typeData = "Username";
                $typeInput = "newUsername";
                $newData = $_POST['newUsername'];
            }
            if (isset($_POST['changeEmail'])) {
                $typeData = "Email";
                $typeInput = "newEmail";
                $newData = $_POST['newEmail'];
            }
            if (isset($_POST['changePassword'])) {
                $typeData = "PasswordHash";
                $typeInput = "newPassword";
                $newData = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
            }
            if (isset($_POST['changeCenter'])) {
                $typeData = "RecCenterCode";
                $typeInput = "newCenter";
                $newCenterName = $_POST['newCenter'];
                //This function is used to get the center code from the center name
                $centerEdit = getCenter($db, $newCenterName);
                $newData = $centerEdit['CenterCode'];
                $_SESSION["CenterName"] = $newCenterName;
            }
            SendQuery($db, $userData, $typeData, $newData);
            header("Refresh:0");
        }
    }

    function SendQuery($db, &$userData, $typeData, $newData){
        $sql = "UPDATE Users SET $typeData = '$newData' WHERE Username = '$_SESSION[username]'";
        if ($typeData == "Username"){
            $_SESSION["username"] = $newData;
            $userData =getUserData($db, $_SESSION["username"]);
        }
        echo "<br>";
        mysqli_query($db, $sql);

    }
    ?>



<?php
if (isset($_POST["submit"])) {

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