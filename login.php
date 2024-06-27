
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
    if (isset($_POST['email']) && isset($_POST['psw'])) {
        $email = $_POST['email'];
        $password = $_POST['psw'];

        if (isset($_POST['admin_login'])) {
            if ($email === 'ht20021307@gmail.com' && $password === 'HT@th13v') {

                header("Location: loginAdmin.html");
                exit();
            }
        } else {

            $sql = "SELECT * FROM registerd WHERE email = ? AND psw = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ss", $email, $password);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    header("Location: search.html");
                    exit();
                } else {
                    echo '<script>
                            alert("Invalid email or password. Please try again.");
                            window.location.href = "index.html"; // Redirect to login page
                          </script>';
                }

                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        }
    } else {
        echo '<script>
                alert("Email or password not set.");
                window.location.href = "index.html"; // Redirect to login page
              </script>';
    }
}

$conn->close();
?>
