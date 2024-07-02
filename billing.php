<?php
include 'dbconfig.php';
include 'nav-bar.php';
active(8);
if (!$_SESSION["UserLoggedIn"]){
    header('location: login.php');
}

?>


<!DOCTYPE html>
<html>
<head>
    <style>
        table {
        border-collapse: collapse;
        width: 100%;
        }

        th, td {
        text-align: left;
        padding: 8px;
        border: 1px solid #ddd;
        }

        tr:nth-child(even) {background-color: #f2f2f2;}
    </style>
    <title>Billing</title>    
</head>
<body>
<main>
    <h1>Here is Your unpaid invoice:</h1>

<?php

$username = $_SESSION['username']; // Get username from session
$invoice_number = rand(1000, 9999);

// Check connection
if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
}


// Fetch the last invoice number and increment it by one
$last_invoice_query = "SELECT MAX(InvoiceID) as last_id FROM Invoice";
$last_invoice_result = $db->query($last_invoice_query);
$last_invoice_row = $last_invoice_result->fetch_assoc();
$invoice_number = $last_invoice_row['last_id'] + 1;



// Define the SQL query to fetch user measurements
$sql = "SELECT Measurement.*, RecyclingCenter.CenterName, Waste.Price
                      FROM Measurement
                      INNER JOIN Station ON Measurement.StationID = Station.StationID
                      INNER JOIN RecyclingCenter ON Station.CenterCode = RecyclingCenter.CenterCode
                      INNER JOIN Waste ON Measurement.Type = Waste.Type
                      WHERE Measurement.username = $username";
$measurement_result = $db->query($sql);
$total_price = 0;

// var_dump($measurement_result);
// Check if user has measurements
if ($measurement_result->num_rows > 0) {
    $username = $_SESSION['username'];
    $row = $measurement_result->fetch_assoc();
    $center_name = $row['CenterName'];
    $date = date("d/m/Y", strtotime($row['Date']));



    echo "<table>";
    echo "<tr><td>Invoice No:</td><td>$invoice_number</td><td>Date:</td><td>$date</td></tr>";
    echo "<tr><td>User:</td><td>$username</td></tr>";
    echo "<tr><td>Recycling Centre:</td><td>$center_name</td></tr>";
    echo "<tr><td colspan='4'>Summary:</td></tr>";
    echo "<tr><td>Measure No</td><td>Weight(kg)</td><td>Type</td><td>Price</td></tr>";

       // Reset pointer and process rows
       $measurement_result->data_seek(0);
       while ($row = $measurement_result->fetch_assoc()) {
           $measure_no = $row['id'];
           $weight = $row['Weight(kg)'];
           $type = $row['Type'];
           $price_per_kg = $row['Price'];
           $price = $price_per_kg * $weight;
   
           // Calculate total price
           $total_price += $price;
   
           // Output each row
           echo "<tr><td>$measure_no</td><td>$weight</td><td>$type</td><td>$price_per_kg €</td></tr>";
       }

    echo "<tr><td colspan='3'>TOTAL:</td><td>$total_price €</td></tr>";
    echo "</table>";
    echo "<br>";
    
    echo "<form action='payment.php' method='get'>";
    echo "<button type='submit'>Pay</button>";
    echo "</form>";

    $insert_invoice_query = "INSERT INTO invoice (InvoiceID, InvoiceDate, InvoiceUsername, InvoiceCenterCode, Amount, isPaid)
    VALUES ($invoice_number, '$date', $username, '$center_code', $total_price, 0)";
$db->query($insert_invoice_query);

} else {
    echo "No measurements found for user.";
}

$db->close();
?>

    </main>    
</body>
</html>