<?php
include 'dbconfig.php';
// Check connection
if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
}



$num_rows = isset($_POST['num_rows']) ? $_POST['num_rows'] : 10; // Default to 10 if not submitted

// Define the SQL query to fetch all measurements
$sql = "SELECT Measurement.*, RecyclingCenter.CenterName
        FROM Measurement
        INNER JOIN Station ON Measurement.StationID = Station.StationID
        INNER JOIN RecyclingCenter ON Station.CenterCode = RecyclingCenter.CenterCode
        ORDER BY Measurement.Date DESC 
        LIMIT " . $num_rows;

$result = $db->query($sql);

// Check if query execution was successful
if ($result->num_rows > 0) {
  echo "<table>";
  echo "<tr>";
  echo "<th>ID</th>";
  echo "<th>Recycling Center</th>"; // Replace Station ID with Center Name
  echo "<th>Date</th>";
  echo "<th>Type</th>";
  echo "<th>Weight(kg)</th>";
  // Add more table headers here if needed for additional columns
  echo "</tr>";

  // Loop through each measurement and display data in table rows
  while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["id"] . "</td>";
    echo "<td>" . $row["CenterName"] . "</td>"; // Display CenterName from joined table
    echo "<td>" . $row["Date"] . "</td>";
    echo "<td>" . $row["Type"] . "</td>";
    echo "<td>" . $row["Weight(kg)"] . "</td>";
    // Add more table data cells here for additional columns
    echo "</tr>";
  }

  echo "</table>";
} else {
  echo "No measurements found";
}

$db->close();
?>
