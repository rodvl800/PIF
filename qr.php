<?php
include 'nav-bar.php';
active(3);
require_once 'phpqrcode/qrlib.php';
if (!$_SESSION["UserLoggedIn"]){
    header('location: login.php');
}


// Generate a unique 8-digit number
function generateUniqueNumber() {
    return sprintf('%08d', mt_rand(0, 99999999));
}



// Generate a new QR code
function generateQRCode($Username, $uniqueNumber) {
    $codeContents = "UserID: " . $Username .  "\nUnique Number: $uniqueNumber";
    $tempDir = 'temp/';
    if (!file_exists($tempDir)) {
        mkdir($tempDir);
    }
    $fileName = 'user_'.$Username.'.png';
    $filePath = $tempDir . $fileName;
    QRcode::png($codeContents, $filePath, QR_ECLEVEL_L, 6);
    return $fileName;
}

// Save QR code to database
function saveQRCodeToDB($db, $Username, $fileName, $uniqueNumber) {
    $qr_code = $fileName;
    $stmt = $db->prepare("UPDATE Users SET Qr_code = ?, RandomCode = ? WHERE Username = ?");
    $stmt->bind_param("sss", $qr_code, $uniqueNumber, $Username);
    $stmt->execute();
    $stmt->close();
}

// Getting a username from the session
$Username = $_SESSION['username'];


// Call functions to generate and save the QR code
$uniqueNumber = generateUniqueNumber();
$fileName = generateQRCode($Username, $uniqueNumber);
saveQRCodeToDB($db, $Username, $fileName, $uniqueNumber);

$db->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>QR Code Generation</title>
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
</head>
<body>
<main>
    <h1>Scan this QR code to begin recycling</h1>
    <img src="temp/<?php echo $fileName; ?>" alt="QR Code">
    <form method="post" action="qr.php">
        <button type="submit">Regenerate QR Code</button>
    </form>
    
    <h1>Existing measurements:</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> Show 
  <select name="num_rows">
    <option value="10">10</option>
    <option value="20">20</option>
    <option value="100">100</option>
    </select>
    rows
  <button type="submit">Refresh</button>
</form>
    <?php include 'measurements.php';?>
    </main>    
</body>
</html>