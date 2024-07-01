<?php
@session_start();
require_once 'dbconfig.php'; // Database connection used everywhere after
$_SESSION["UserLoggedIn"] = $_SESSION["UserLoggedIn"] ?? false;
$_SESSION["isAdmin"] = $_SESSION["isAdmin"] ?? false;
$_SESSION["username"] = $_SESSION["username"] ?? "";
$_SESSION["CenterName"] = $_SESSION["CenterName"] ?? "";

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

function active($activePage) 
    {
?>


   <link rel="stylesheet" href="styles.css"/>
<header>
    <ul class="nav-links">

            <li><a class="<?php if ($activePage == 1) print ("active");
        else print("inactive"); ?>" href="index.php">Home</a></li>
            <li><a class="<?php if ($activePage == 2) print ("active");
        else print("inactive"); ?>" href="about.php">About</a></li>

            <?php
            if ($_SESSION["UserLoggedIn"]) {?>
                <li><a class="<?php if ($activePage == 3) print ("active");
        else print("inactive"); ?>" href="qr.php?page=qr">Qr</a></li>
                <li><a class="<?php if ($activePage == 4) print ("active");
        else print("inactive"); ?>" href="profile.php">Profile</a></li>
                <li><a class="<?php if ($activePage == 8) print ("active");
        else print("inactive"); ?>" href="billing.php?page=billing">Billing</a></li>
                <?php if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']){ ?>
                    <li><a class="<?php if ($activePage == 5) print ("active");
        else print("inactive"); ?>" href="admin.php">Admin</a></li>
                <?php } ?>

                <li>Welcome, <b><?php echo $_SESSION["username"]?></b></li>
                <form method="POST" >
                <li><input type="submit" name="Logout" value="Logout"></li>
                </form>
            <?php }
                else { ?>
                <li><a class="<?php if ($activePage == 6) print ("active");
        else print("inactive"); ?> "href="login.php">Login</a></li> 
                <li><a class="<?php if ($activePage == 7) print ("active");
        else print("inactive"); ?>" href="register.php">Register</a></li>
            <?php } ?>
    </ul>
</header>
<?php
}
?>