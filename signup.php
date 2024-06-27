
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['m_id'], $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['psw'])) {
        $m_id = $_POST['m_id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $psw = $_POST['psw'];

        $sql = "INSERT INTO registerd (m_id, fname, lname, email, psw) VALUES ('$m_id', '$fname','$lname', '$email', '$psw')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully. You can return to the home page and Log in to search";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "One or more required fields are missing";
    }

    $conn->close();
}
?>
