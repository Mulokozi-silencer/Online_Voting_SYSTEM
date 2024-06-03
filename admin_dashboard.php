<?php
session_start();

// Check if admin is logged in, if not redirect to login page
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}


// Include database connection
include "connect.php";

// Retrieve admin's name based on admin_id
$adminId = $_SESSION['admin'];
$adminQuery = "SELECT name FROM admins WHERE id = $adminId";
$adminResult = $mysqli->query($adminQuery);
if ($adminResult && $adminResult->num_rows > 0) {
    $admin = $adminResult->fetch_assoc();
    $adminName = $admin['name'];
} else {
    $adminName = "Admin";
}
// Fetch all contestants from the database
$sql = "SELECT * FROM contestants";
$result = mysqli_query($mysqli, $sql);

// Array to store all contestants
$contestants = [];
while ($row = mysqli_fetch_assoc($result)) {
    $contestants[] = $row;
}

// Function to add a contestant
if (isset($_POST['add_contestant'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $photo = $_FILES['photo']['name'];
    $position = $_POST['position'];

    // Upload photo to server
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

    // Insert contestant into the database
    $insert_sql = "INSERT INTO contestants (name, email, photo, position, votes) VALUES ('$name', '$email', '$photo', '$position', 0)";
    mysqli_query($mysqli, $insert_sql);

    // Redirect to refresh the page
    header("Location:admin_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="container">
        <h2>Welcome <?php echo $adminName;?>!</h2>
        <div class="message"><a href="admin_view_message.php">Messages</a></div>
        <div class="logout"><a href="logout.php">Logout</a></div>
        <div class="home"><a href="index1.php">Home</a></div>
        <h3>Add Contestant</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="photo">Photo:</label>
            <input type="file" id="photo" name="photo" required><br><br>

            <label for="position">Position:</label>
            <input type="text" id="position" name="position" required><br><br>

            <input type="submit" name="add_contestant" value="Add Contestant">
        </form>

        <h3>Contestants List</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Photo</th>
                <th>Position</th>
                <th>Votes</th>
                <th>Action</th>
            </tr>
            <?php foreach ($contestants as $contestant): ?>
            <tr>
                <td><?php echo $contestant['id'];?></td>
                <td><?php echo $contestant['name']; ?></td>
                <td><?php echo $contestant['email']; ?></td>
                <td><img src="uploads/<?php echo $contestant['photo']; ?>" alt="Contestant Photo" width="100"></td>
                <td><?php echo $contestant['position']; ?></td>
                <td><?php echo $contestant['votes']; ?></td>
                <td>
                    <form action="delete.php" method="post">
                        <input type="hidden" name="contestant_id" value="<?php echo $contestant['id']; ?>">
                        <button type="submit" class="btn btn-danger" name="delete_contestant">Delete</button>
                    </form>
                    <form action="update.php" method="post">
                        <input type="hidden" name="contestant_id" value="<?php echo $contestant['id']; ?>">
                        <button type="submit" class="btn btn-light" name="update_contestant">Update</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
