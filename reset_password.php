
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "users";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $new_password = generateRandomPassword(); 
    $sql = "UPDATE registerd SET psw = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $new_password, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            sendResetEmail($email, $new_password);
            echo '<script>alert("Password reset successful. Check your email for the new password."); window.location.href = "index.html";</script>';
            
        } else {
            echo '<script>alert("Email not found. Please enter a valid email address."); window.location.href = "index.html";</script>';
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
}

function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function sendResetEmail($email, $new_password) {
    $subject = 'Password Reset';
    $message = "Your new password is: $new_password";
    $headers = 'From: your_email@example.com' . "\r\n" .
               'Reply-To: your_email@example.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    mail($email, $subject, $message, $headers);
}
?>
