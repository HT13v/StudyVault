
<?php

$servername = "localhost"; 
$username = "root"; 
$password = "";
$dbname = "users"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$query = $_POST['query']; 
$sql = "INSERT INTO queries (query, created_at) VALUES ('$query', NOW())";

if ($conn->query($sql) === TRUE) {
    $response = array("success" => true);
} else {
    $response = array("success" => false, "error" => $conn->error);
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>