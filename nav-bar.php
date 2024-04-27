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
            <?php if(isset($_SESSION['username'])): ?>
            <li>Welcome, <?php echo $_SESSION['username']; ?>! <a href="logout.php">Logout</a></li>
             <?php else: ?>
                <li><a href="../login.php">Login</a></li> <li><a href="../register.php">Register</a></li>
            <?php endif; ?>
            <?php if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']): ?>
                <li><a href="admin.php">Admin</a></li>
            <?php endif; ?>
    </ul>
</header>