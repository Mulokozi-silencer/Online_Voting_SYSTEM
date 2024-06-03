<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Retrieve and sanitize form inputs
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $message = htmlspecialchars(trim($_POST['message']));

        // Prepare the insert statement
        $stmt = prepareInsertStatement($mysqli, "messages", ["name", "email", "message"]);

        // Bind parameters
        $stmt->bind_param('sss', $name, $email, $message);

        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['message_status'] = "success";
        } else {
            $_SESSION['message_status'] = "error";
        }
    } catch (Exception $e) {
        $_SESSION['message_status'] = "error";
        $_SESSION['message_error'] = "Error: " . $e->getMessage();
    }
    echo "Your message has sent successfully!!";
    header("Location: aboutus.php");
    exit;
} else {
    $_SESSION['message_status'] = "invalid_request";
    echo "Your message had sent successfully! Thank You :)";
    header("Location: index1.php");
    exit;
}

// Function to prepare insert statement
function prepareInsertStatement($mysqli, $table, $columns) {
    $columnNames = implode(", ", $columns);
    $paramPlaceholders = implode(", ", array_fill(0, count($columns), "?"));
    $sql = "INSERT INTO $table ($columnNames) VALUES ($paramPlaceholders)";
    return $mysqli->prepare($sql);
}
?>
