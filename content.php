<?php
$Name = $_POST['name']; // No trimming or sanitization
$Password = $_POST['password']; // No trimming or sanitization
$con = mysqli_connect('localhost', 'root', 'root1234', '123');

// Vulnerable query to fetch user details
$result = mysqli_query($con, "SELECT * FROM `tbluser` WHERE (UserName = '$Name') AND Password = '$Password'");

if (mysqli_num_rows($result) > 0) {
    // Fetch user details from the result
    $user = mysqli_fetch_assoc($result);
    $userID = $user['ID']; // Assuming the user table has an ID field

    // Redirect to index.php with the user ID in the URL
    echo "<script>
        alert('Successfully logged in');
        window.location.href = 'index.php?user_id=" . $userID . "';
    </script>";
} else {
    echo "<script>
        alert('Incorrect name or password');
        window.location.href = 'login.php';
    </script>";
}

// Close the connection
mysqli_close($con);
?>
