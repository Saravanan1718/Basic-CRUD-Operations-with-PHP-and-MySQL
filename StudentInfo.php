<?php

include "dbconfig.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['operation'])) {
        $operation = $_POST['operation'];

        switch ($operation) {
            case 'insert':
                createRecord();
                break;
            case 'update':
                updateRecord();
                break;
            case 'delete':
                deleteRecord();
                break;
            default:
                inputForm();
                break;
        }
    }
} else {
    inputForm();
}

function createRecord()
{
    global $conn;

    if (isset($_POST['name']) && isset($_POST['age']) && isset($_POST['email'])) {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $email = $_POST['email'];

        $sql = "INSERT INTO `studentInfo`(`name`, `age`, `email`) VALUES ('$name','$age','$email')";
        $result = $conn->query($sql);

        if ($result === TRUE) {
            echo "New record created successfully.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

function updateRecord()
{
    global $conn;

    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['age']) && isset($_POST['email'])) {
        $stu_id = $_POST['id'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $email = $_POST['email'];

        $sql = "UPDATE `studentInfo` SET `name`='$name',`age`='$age',`email`='$email' WHERE `id`='$stu_id'";
        $result = $conn->query($sql);

        if ($result === TRUE) {
            echo "Record updated successfully.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

function deleteRecord()
{
    global $conn;

    if (isset($_POST['id'])) {
        $stu_id = $_POST['id'];

        $sql = "DELETE FROM studentInfo WHERE ID ='$stu_id'";
        $result = $conn->query($sql);

        if ($result === TRUE) {
            echo "Record deleted successfully.";

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

function inputForm()
{
    global $conn;
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Student Database</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <style>
            .container {
                border: 5px outset red;
                background-color: lightblue;
                text-align: center;
                margin-bottom: 40px;
                padding: 20px;
            }

            .button-container {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
                margin-top: 20px;
            }

            .button {
                border: 2px solid red;
                color: red;
                padding: 10px 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                cursor: pointer;
                background-color: white;
            }
            table {
                width: 100%;
            }
            th, td {
                padding: 10px;
                text-align: center;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <h2>Student Database</h2>
        <?php showForm(); ?>
        <div class="button-container">
            <button type="submit" form="student-form" name="operation" value="insert" class="button">Insert</button>
            <button type="submit" form="student-form" name="operation" value="update" class="button">Update</button>
        </div>
        <br><br><br>

        <h2>Student Details</h2>
        <?php showTable(); ?>
    </div>
    </body>
    </html>
    <?php
}
function showTable()
{
    global $conn;
    ?>
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
                    <td>
                        <form id="edit-form-<?php echo $row['ID']; ?>" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                            <button type="submit" formaction="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="operation" value="edit" class="button">Edit</button>
                        </form>
                        <form id="delete-form-<?php echo $row['ID']; ?>" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                            <button type="submit" name="operation" value="delete" class="button">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
    <?php
}

function showForm()
{
    global $conn;

    $id = "";
    $name = "";
    $age = "";
    $email = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['operation']) && $_POST['operation'] == "edit") {
        if (isset($_POST['id'])) {
            $stu_id = $_POST['id'];

            $sql = "SELECT `name`, `age`, `email` FROM `studentInfo` WHERE `id`='$stu_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id = $stu_id;
                $name = $row['name'];
                $age = $row['age'];
                $email = $row['email'];
            }
        }
    }

    ?>
    <div class="form-container">
        <form id="student-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" placeholder="Name"><br><br>
            <label for="age">Age:</label>
            <input type="text" id="age" name="age" value="<?php echo $age; ?>" placeholder="Age"><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" placeholder="Email"><br><br><br>
        </form>
    </div>
    <?php
}
?>
