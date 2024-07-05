​<?php
include "dbconfig.php";
if (isset($_GET['ID'])) {
    $stu_id = $_GET['ID'];
    $sql = "DELETE FROM studentInfo WHERE id ='$stu_id'";
     $result = $conn->query($sql);
     if ($result == TRUE) {
        echo "Record deleted successfully.";
        header('Location: view_std.php');
    }else{
        echo "Error:" . $sql . "<br>" . $conn->error;
    }
}
?>
