<!DOCTYPE html>
<html>
<title>Student</title>
<body>
<h2>Student Form</h2>
<form action="" method="POST">
  <fieldset>
    <legend>Student information:</legend>
    Name:<br>
    <input type="text" name="name"> <br>
    Age:<br>
    <input type="text" name="age"> <br>
    Email:<br>
    <input type="email" name="email"><br>
    <br><br>
    <input type="submit" name="submit" value="submit">
  </fieldset>
</form>
</body>
</html>

<?php
include "dbconfig.php";
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $sql = "INSERT INTO `studentInfo`(`name`, `age`, `email`) VALUES ('$name','$age','$email')";
    $result = $conn->query($sql);
    if ($result == TRUE) {
      echo "New record created successfully.";
      header('Location: view_std.php');
    }else{
      echo "Error:". $sql . "<br>". $conn->error;
    }
    $conn->close();
  }
?>
