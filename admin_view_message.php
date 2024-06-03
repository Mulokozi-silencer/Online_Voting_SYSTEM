<?php
session_start();
include "connect.php";

// Fetch all messages from the database
$sql = "SELECT * FROM messages";
$result = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View Messages</title>
    <link rel="stylesheet" href="css/r1.css">
    <link rel="stylesheet" href="css/home.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h1 {
            color: #333;
            text-align: center;
            padding: 20px 0;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: #fff;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        td {
            color: #333;
        }
    </style>
</head>
<body>
    <section class="menu">
        <div class="nav">
           <div class="logo"><h1>G4<b>Online Voting System</b></h1></div>
           <ul>
                 <li><a class="active" href="#home">Home</a></li>
                 <li><a href="register.php">Register</a></li>
                 <li><a href="aboutus.php">About Us</a></li>
           </ul> 
           <div>
            <a href="login.php"><input class="signin" type="submit" value="Sign In" name="signin"></a>            
           </div>
        </div>
    </section>
    <table class="table">
        <tr>
            <th>ID</th>
            <th>Sender</th>
            <th>Email</th>
            <th>Message</th>
            <th>Received at</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while($message = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($message['id']); ?></td>
                    <td><?php echo htmlspecialchars($message['name']); ?></td>
                    <td><?php echo htmlspecialchars($message['email']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($message['message'])); ?></td>
                    <td><?php echo htmlspecialchars($message['created_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No messages found</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
