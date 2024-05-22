<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Voting System</title>
    <link rel="stylesheet" href="css/r1.css" type="text/css">
</head>
<body>
    <div id="banner">
    <?php
    include("connect.php");

    $msg = ""; // Initialize message variable

    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($mysqli, $_POST['name']);
        $email = mysqli_real_escape_string($mysqli, $_POST['email']);
        $contact = mysqli_real_escape_string($mysqli, $_POST['contact']);
        $nationality = mysqli_real_escape_string($mysqli, $_POST['nationality']);
        $gender = mysqli_real_escape_string($mysqli, $_POST['gender']);
        $year = mysqli_real_escape_string($mysqli, $_POST['year']);
        $course = mysqli_real_escape_string($mysqli, $_POST['course']);
        $sid = mysqli_real_escape_string($mysqli, $_POST['sid']);
        $password = mysqli_real_escape_string($mysqli, $_POST['password']);
      
        // Check if the email already exists in the database
        $email_check_query = "SELECT * FROM logindetails WHERE email='$email' LIMIT 1";
        $result = $mysqli->query($email_check_query);
        $user = $result->fetch_assoc();

        if ($user) { // If email exists
            $msg = "Email already exists";
        } else { // If email is unique, proceed with insertion
            $sql = "INSERT INTO logindetails (name, email, contact, nationality, gender, year, course, sid, password) VALUES ('$name','$email','$contact','$nationality','$gender','$year','$course','$sid', '$password')";
            
            if ($mysqli->query($sql) === true) {
                $_SESSION['message'] = "Records inserted successfully.";
                header('location: login.php');
                exit;
            } else {
                $msg = "ERROR: Could not execute $sql. " . $mysqli->error;
            }
        }
    }
    ?>
        <span class="head">Voting Management System</span><br>
        <marquee behavior="alternate" direction="left" class="clg" scrollamount="3">"Join the Community: Shape the future with every Vote."
             "Modern Solutions for Modern Democracy: Vote with Ease." "Transparent democracy: Cast Your Ballot with Confidence."
        </marquee>
    </div>
    <br>
    <div align="center">
        <div id="wrapper">
            <br>
            <br>
            <span class="SubHead">Registration Form</span>
            <br>
            <br>
            <form method="post" action="">
                <table border="0" cellspacing="4" cellpadding="4" class="table">
                    <tr><td colspan="2" align="center" class="msg"><?php echo $msg;?></td></tr>
                    <tr><td class="labels">Name :</td><td><input type="text" name="name" class="fields" placeholder="Enter Full Name" required="required" size="25" /></td></tr>
                    <tr><td class="labels">Email ID :</td><td><input type="email" name="email" class="fields" placeholder="Enter Email ID" required="required" size="25" /></td></tr>
                    <tr><td class="labels">Contacts :</td><td><input type="num" name="contact" class="fields" placeholder="Enter Contact" required="required" size="25" /></td></tr>
                    <tr><td class="labels">Nationality :</td><td><input type="radio" name="nationality" value="mainlands" checked>Mainlands <input type="radio" name="nationality" value="zanzibar">Zanzibar</td></tr>
                    <tr><td class="labels">Gender :</td><td><input type="radio" name="gender" value="male" checked>Male <input type="radio" name="gender" value="female">Female</td></tr>
                    <tr><td class="labels">Year of Study :</td>
                        <td>
                            <select name="year" class="fields" required>
                                <option value="" disabled="disabled" selected="selected">- - Select Year - -</option>
                                <option value="1">First Year</option>
                                <option value="2">Second Year</option>
                                <option value="3">Third Year</option>
                                <option value="4">Fourth Year</option>
                                <!-- Add other semesters as needed -->
                            </select>
                        </td>
                    </tr>
                    <tr><td class="labels">Course :</td>
                        <td>
                            <select name="course" class="fields" required>
                                <option value="" disabled="disabled" selected="selected">- - Select Branch - -</option>
                                <option value="Computer Engineering">Computer Engineering</option>
                                <option value="Computer Science">Computer Science</option>
                                <option value="Data Science">Data Science</option>
                                <option value="Information & Communication Technology">Information & Communication Technology</option>
                                <option value="Food Science">Food Science</option>
                                <option value="Laboratory Science">Laboratory Science</option>
                                <option value="Civil Engineering">Civil Engineering</option>
                                <option value="Mechanical Engineering">Mechanical Engineering</option>
                                <option value="Electrical & Electronics Engineering">Electrical & Electronics Engineering</option>
                                <option value="Technical Education in Electrical & Electronics Engineering">Technical Education in Electrical & Electronics Engineering</option>
                                <!-- Add other branches as needed -->
                            </select>
                        </td>
                    </tr>
                    <tr><td class="labels">Student ID :</td><td><input type="text" name="sid" class="fields" placeholder="Enter Student ID" required="required" size="25" /></td></tr>
                    <tr><td class="labels">Password :</td><td><input type="password" name="password" class="fields" placeholder="Enter Password" required="required" size="25" /></td></tr>
                    <tr><td colspan="2" align="center"><input type="submit" name="submit" value="Register" class="fields" /></td></tr>
                </table>
                <div class="link">
                    Already have an account? <a href="login.php">Sign In</a>
                </div>
            </form>
            <br>
            <br>
            <a href="index1.php" class="link">Go Back</a>
            <br>
            <br>
        </div>
    </div>
</body>
</html>
