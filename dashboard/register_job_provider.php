<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:../index.php");
    exit();
}
include('../connection.php');

// Retrieve the username from the session
$username = $_SESSION['username'];

// Retrieve the users_id from the database based on the username
$stmt = $pdo->prepare("SELECT users_id FROM users WHERE username = ?");
$stmt->execute([$username]); 
$user_id = $stmt->fetchColumn(); 
$stmt->closeCursor(); 

$pdo = null;
?>
<?php
include 'dashboard.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        .form-container input[type="date"],
        .form-container input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Ensure padding and border are included in width */
        }
        .form-container input[type="tel"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Ensure padding and border are included in width */
        }

        /* Submit button */
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
 
    <h2 style="text-align:center;margin-top:2rem">Register Job Provider</h2><br>
<div class="form-container">
    
        <form action="" method="post">
            <div>
                <label for="name">FIRSTNAME:</label>
                <input type="text"  name="firstname" required>
            </div>
            <div>
                <label for="physical_code">LASTNAME:</label>
                <input type="text"  name="lastname" required>
            </div>
            <div>
                <label for="phone">PROVINCE:</label>
                <input type="text"  name="province" required>
            </div>
            <div>
                <label for="phone">DISTRICT:</label>
                <input type="text"  name="district" required>
            </div>
            <div>
                <label for="phone">SECTOR:</label>
                <input type="text"  name="sector" required>
            </div>
            <div>
                <label for="phone">CELL:</label>
                <input type="text"  name="cell" required>
            </div>
            <div>
                <label for="phone">VILLAGE:</label>
                <input type="text"  name="village" required>
            </div>
            <div>
                <label for="phone">ID</label>
                <input type="text"  name="id" required>
            </div>
            
            <div>
                <input type="submit" name="register" value="Register" stayle="background-color:red">
            </div>
        </form>
    </div>
			
			
</body>
</html>

<?php
include '../connection.php';

if (isset($_POST["register"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $province = $_POST['province'];
    $district = $_POST['district'];
    $sector = $_POST['sector'];
    $cell = $_POST['cell'];
    $village = $_POST['village'];
    $id=$_POST['id'];
    $created_by = $_SESSION['username'];

    try {
        $sql = "INSERT INTO job_provider (users_id, firstname, lastname,  province, district, sector, cell, village, id, created_by) 
                VALUES (:users_id, :firstname, :lastname, :province, :district, :sector, :cell, :village, :id, :created_by)";
        $stmt = $pdo->prepare($sql);
    
        $stmt->bindParam(':users_id', $user_id); 
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':district', $district);
        $stmt->bindParam(':sector', $sector);
        $stmt->bindParam(':cell', $cell);
        $stmt->bindParam(':village', $village);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':created_by', $created_by);

        if ($stmt->execute()) {
            echo "<script>alert('New job provider has been added');</script>";
        } else {
            echo "<script>alert('Error: Unable to execute statement');</script>";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
