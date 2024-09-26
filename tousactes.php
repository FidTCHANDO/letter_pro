<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mypage";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data
$sql = "SELECT *, DATE(datecreation) AS datedecreation FROM titredeconge";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        array_push($data, $row);
    }
} else {
    echo json_encode([]);
}

$conn->close();

$response = array(
    "events" => $data
);

// Output the data as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
