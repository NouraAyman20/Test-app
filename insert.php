<?php  
if (isset($_POST['submit'])) {
  // Secure connection to the database
  $con = mysqli_connect('localhost', 'root', 'root1234', '123');
  
  // Check connection
  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Basic validation function
  function check($var) {
    $var = trim($var);
    $var = strip_tags($var);
    return $var;
  }

  // Validate user input
  $Name = check($_POST['name']);
  $Email =check($_POST['email']) ;
  $Number = preg_match('/^[0-9]{10,15}$/', $_POST['number']) ? check($_POST['number']) : null;
  $Password = check($_POST['password']);

  // Return error if email or number are invalid
  if (!$Email || !$Number) {
    echo "<script>alert('Invalid email or phone number'); window.location.href = 'register.php';</script>";
    exit();
  }

  // Password hashing for security
  /*$hashedPassword = password_hash($Password, PASSWORD_DEFAULT);*/

  // Vulnerable query for checking duplicates (no prepared statements)
  $query = "SELECT * FROM tbluser WHERE Email = '$Email' OR UserName = '$Name'";
  $result = mysqli_query($con, $query);

  if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('This email or username is already taken'); window.location.href = 'register.php';</script>";
  } else {
    // Vulnerable insert into the database (no prepared statements)
    $query = "INSERT INTO tbluser (UserName, Email, Number, Password) 
              VALUES ('$Name', '$Email', '$Number', '$Password')";
    $result = mysqli_query($con, $query);

    if ($result) {
      echo "<script>alert('Register successfully'); window.location.href = 'register.php';</script>";
    } else {
      echo "Error: " . mysqli_error($con);
    }
  }

  // Close the connection
  mysqli_close($con);
}
?>
