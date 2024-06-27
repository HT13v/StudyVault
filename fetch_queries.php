
<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "users"; 
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT id, query, created_at FROM queries ORDER BY created_at DESC";
$result = $conn->query($sql);

$queries = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $queries[] = array(
            "id" => $row["id"],
            "query" => $row["query"],
            "created_at" => $row["created_at"]
        );
    }
}

$conn->close();


header('Content-Type: application/json');
echo json_encode($queries);
?>
