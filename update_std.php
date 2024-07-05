<?php
include "dbconfig.php";
    if (isset($_POST['update'])) {
        $stu_id = $_POST['ID'];
        $name = $_POST['Name'];
        $age = $_POST['Age'];
        $email = $_POST['Email'];
        $sql = "UPDATE `studentInfo` SET `name`='$name',`age`='$age',`email`='$email' WHERE `id`='$stu_id'";
        $result = $conn->query($sql);
        if ($result == TRUE) {
            echo "Record updated successfully.";
            header('Location: view_std.php');
        }else{
            echo "Error:" . $sql . "<br>" . $conn->error;
        }

    }

if (isset($_GET['ID'])) {
    $stu_id = $_GET['ID'];
    $sql = "SELECT * FROM studentInfo WHERE id='$stu_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['ID'];
            $name = $row['Name'];
            $age = $row['Age'];
            $email = $row['Email'];
        }
    ?>

        <h2>Student details Update Form</h2>
        <form action="" method="post">
          <fieldset>
            <legend>Personal information:</legend>
            Name:<br>
            <input type="text" name="Name" value="<?php echo $name; ?>">
            <input type="hidden" name="ID" value="<?php echo $id; ?>">
            <br>
            Age:<br>
            <input type="text" name="Age" value="<?php echo $age; ?>">
            <br>
            Email:<br>
            <input type="email" name="Email" value="<?php echo $email; ?>">
            <br><br>
            <input type="submit" value="Update" name="update">
          </fieldset>
        </form>
        </body>
        </html>


    <?php
    } else{
        header('Location: view_std.php');
    }
}
?>
