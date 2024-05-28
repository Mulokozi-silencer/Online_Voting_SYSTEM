<?php
session_start();
include "connect.php";

// Check if user is not logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    header("Location: login.php");
    exit;
}

// Fetch user data from the session
$userData = null;


$userQuery = "SELECT email FROM logindetails WHERE id = ?";
$stmt = $mysqli->prepare($userQuery);

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
    }
    $stmt->close();
} else {
    die("Prepare statement failed: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="container">
        <h1 align="center">Welcome to the Dashboard</h1>
        <?php if (isset($_SESSION['message'])): ?>
            <p><?= htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></p>
        <?php endif; ?>
        
        <h3 align="center">Vote for Candidates</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Position</th>
                <th>Name</th>
                <th>Photo</th>
                <th>Action</th>
            </tr>
            <?php
            // Fetch all contestants from the database
            $sql = "SELECT * FROM contestants";
            $result = $mysqli->query($sql);
            while ($contestant = $result->fetch_assoc()) {
            ?>
                <tr>
                    <td><?= htmlspecialchars($contestant['id']); ?></td>
                    <td><?= htmlspecialchars($contestant['position']); ?></td>
                    <td><?= htmlspecialchars($contestant['name']); ?></td>
                    <td><img src="uploads/<?= htmlspecialchars($contestant['photo']); ?>" alt="Contestant Photo" width="100"></td>
                    <td>
                        <?php if ($userData['voted']): ?>
                            Voted
                        <?php else: ?>
                            <form action="voting.php" method="post">
                                <input type="hidden" name="contestant_id" value="<?= htmlspecialchars($contestant['id']); ?>">
                                <button type="submit" name="vote">Vote</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
