
<?php  
session_start();
if (!isset($_SESSION['username'])) {
 header("location:../index.php");
}
 ?>



<?php
include'dashboard.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <style>
        /* Form container */
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        /* Form fields */
        .form-container div {
            margin-bottom: 15px;
        }
        .form-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-container input[type="text"],
        .form-container input[type="password"],
        form select,
        .form-container input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; 
        }


        .form-container input[type="submit"] {
            width: 20%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: teal;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: teal;
        }
    </style>
    
</head>
<body>

<?php
$id = $_GET['job_seeker_id'];
include'../connection.php';
$stmt = $pdo->prepare("SELECT * FROM job_seeker WHERE job_seeker_id = :job_seeker_id");
$stmt->bindParam(':job_seeker_id', $id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<h2 style="text-align:center"></h2><br>
<div class="form-container">
    <form action="" method="post">
        <div>
            <label for="name">JOB SEEKER NAME:</label>
            <input type="text" name="name" value="<?php echo $row['firstname']; ?>" required>
        </div>
        <div>
            <label for="name">JOB SEEKER NAME:</label>
            <input type="text" name="name" value="<?php echo $row['lastname']; ?>" required>
        </div>
        
        <div>
            <label for="physical_code">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>" required>
        </div>
        
        <div>
            <input type="submit" name="update" value="Update" style="background-color: teal;">
        </div>
    </form>
</div>

</body>
</html>

<?php  

include '../connection.php';

if (isset($_POST['update'])) {
    $job_seeker_id = $_GET['job_seeker_id'];
    $name=$_POST['name'];
    $physical_code = $_POST['physical_code'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $updated_by = $_SESSION['username']; 
    $updated_on = date('Y-m-d H:i:s'); 

    try {
        // Fetch existing values
        $stmt_existing = $pdo->prepare("SELECT created_by FROM institution WHERE job_seeker_id = :job_seeker_id");
        $stmt_existing->bindParam(':job_seeker_id', $job_seeker_id);
        $stmt_existing->execute();
        $row_existing = $stmt_existing->fetch(PDO::FETCH_ASSOC);
        $created_by = $row_existing['created_by']; // Use existing created_by value

        // Prepare the SQL statement
        $sql = "UPDATE institution 
                SET physical_code = :physical_code, 
                    email = :email, 
                    name=   :name,
                    phone = :phone, 
                    created_by = :created_by, 
                    updated_by = :updated_by, 
                    updated_on = :updated_on 
                WHERE job_seeker_id = :job_seeker_id";

        // Prepare statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':physical_code', $physical_code);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':updated_by', $updated_by);
        $stmt->bindParam(':updated_on', $updated_on);
        $stmt->bindParam(':job_seeker_id', $job_seeker_id);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>window.location.href = 'view_institution.php';</script>";

            exit();
        } else {
            echo "<script>alert('Error updating record');</script>";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

