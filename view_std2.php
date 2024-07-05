<?php
include "dbconfig.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Database</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<body>

    <div class="container">
        <h2>Student Details</h2>
<table class="table">
    <thead>
        <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Age</th>
        <th>Email</th>
        <th>Action</th>

    </tr>
    </thead>
    <tbody>
        <?php
                $sql = "SELECT * FROM studentInfo";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
        ?>
                    <tr>
                    <td><?php echo $row['ID']; ?></td>
                    <td><?php echo $row['Name']; ?></td>
                    <td><?php echo $row['Age']; ?></td>
                    <td><?php echo $row['Email']; ?></td>
                    <td><a class="btn btn-info" href="update_std.php?id=<?php echo $row['ID']; ?>">Edit</a>
                     &nbsp;
                     <a class="btn btn-danger" href="delete_std.php?id=<?php echo $row['ID']; ?>">Delete</a>
                    </td>
                    </tr>
        <?php       }
            }
        ?>
    </tbody>
</table>
    </div>
</body>
</html>
