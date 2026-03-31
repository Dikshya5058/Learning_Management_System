<?php
require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email exists
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");

    if ($check->num_rows > 0) {
        // Redirect back with error
        header("Location: register.html?error=email");
        exit();
    } else {
        $insert = $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");

        if ($insert) {
            // Redirect to login
            header("Location: ../login/login.html");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>