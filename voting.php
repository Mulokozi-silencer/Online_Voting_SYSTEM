<?php
session_start();
include "connect.php"; // Include your database connection script

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    $_SESSION['message'] = "You need to be logged in to vote.";
    header("Location: login.php");
    exit;
}

// Check if contestant_id is set in POST data
if (!isset($_POST['contestant_id'])) {
    $_SESSION['message'] = "Contestant ID not found in POST data.";
    header("Location: dashboard.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$contestant_id = $_POST['contestant_id'];

// Check if the user has already voted for this contestant
$voteCheckQuery = "SELECT 1 FROM votes WHERE user_id = ? AND contestant_id = ?";
$stmt = $mysqli->prepare($voteCheckQuery);
if (!$stmt) {
    $_SESSION['message'] = "Error in preparing vote check query: " . $mysqli->error;
    header("Location: dashboard.php");
    exit;
}
$stmt->bind_param("ii", $user_id, $contestant_id);
if (!$stmt->execute()) {
    $_SESSION['message'] = "Error in executing vote check query: " . $stmt->error;
    header("Location: dashboard.php");
    exit;
}
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User has already voted for this contestant
    $_SESSION['message'] = "You have already voted for this contestant.";
    header("Location: dashboard.php");
    exit;
}

// User has not voted for this contestant yet, proceed with the vote
$voteQuery = "INSERT INTO votes (user_id, contestant_id) VALUES (?, ?)";
$stmt = $mysqli->prepare($voteQuery);
if (!$stmt) {
    $_SESSION['message'] = "Error in preparing vote query: " . $mysqli->error;
    header("Location: dashboard.php");
    exit;
}
$stmt->bind_param("ii", $user_id, $contestant_id);
if (!$stmt->execute()) {
    $_SESSION['message'] = "Error in executing vote query: " . $stmt->error;
    header("Location: dashboard.php");
    exit;
}

// Increment vote count for the contestant in the contestants table
$updateContestantQuery = "UPDATE contestants SET votes = votes + 1 WHERE id = ?";
$stmt = $mysqli->prepare($updateContestantQuery);
if (!$stmt) {
    $_SESSION['message'] = "Error in preparing update contestant query: " . $mysqli->error;
    header("Location: dashboard.php");
    exit;
}
$stmt->bind_param("i", $contestant_id);
if (!$stmt->execute()) {
    $_SESSION['message'] = "Error in executing update contestant query: " . $stmt->error;
    header("Location: dashboard.php");
    exit;
}

// Set success message and redirect to dashboard
$_SESSION['message'] = "Your vote has been cast.";
header("Location: index1.php");
exit;
?>
