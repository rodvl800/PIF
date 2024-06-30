<?php
include 'nav-bar.php';
active(5);
if (!$_SESSION["UserLoggedIn"]) {
    header('location: login.php');
}


$sql = "SELECT id, measurement, value, timestamp FROM Measurement";
$sql = "SELECT * FROM RecyclingCenter WHERE CenterName = '$centerName'";
$result = mysqli_query($db, $sql);
$data = mysqli_fetch_assoc($result);
?>
<!-- 
<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>Measurement Data</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Measurement</th>
        <th>Value</th>
        <th>Timestamp</th>
        <th>Actions</th>
    </tr>

</table>

<a href="add.php">Add New Measurement</a>

</body>
</html> -->
