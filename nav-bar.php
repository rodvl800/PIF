<?php
session_start();
require_once 'dbconfig.php'; // Database connection used everywhere after
$_SESSION["UserLoggedIn"] = $_SESSION["UserLoggedIn"] ?? false;
var_dump($_SESSION);

if (isset($_POST["Logout"])) {
    $_SESSION["UserLoggedIn"] = false;
    $_SESSION["username"] = "";
    $_SESSION["password"] = "";
    $_SESSION["isAdmin"] = false;
    session_unset();
    session_destroy();
    header("Refresh:0, url=index.php");
    die();
}

?>
   <link rel="stylesheet" href="styles.css"/>
<header>
    <ul class="nav-links">

            <li><a href="index.php">Home</a></li>
            <li><a href="recycling-centers.php">Centers</a></li>
            <li><a href="about.php">About</a></li>
            <?php
            if ($_SESSION["UserLoggedIn"]) {?>
                <li><a class="<?php echo $pageQr;?>" href="qr.php?page=qr">Qr</a></li>
                <p>You are logged in as <b><?php echo $_SESSION["username"]?></b></p>
                <form method="POST" >
                <li><input type="submit" name="Logout" value="Logout"></li>
                </form>
            <?php }
                else { ?>
                <li><a href="login.php">Login</a></li> <li><a href="register.php">Register</a></li>
            <?php } ?>
            <?php if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']){ ?>
                <li><a href="admin.php">Admin</a></li>
            <?php } ?>
    </ul>
</header>