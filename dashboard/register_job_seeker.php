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
 
    <h2 style="text-align:center;margin-top:2rem">Register Job Seeker</h2><br>
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
                <label for="email">FATHER'S NAME:</label>
                <input type="email"  name="fathers_name" required>
            </div>
            <div>
                <label for="phone">MOTHER'S NAME:</label>
                <input type="text"  name="mothers_name" required>
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
                <label for="phone">VILLAGE:</label>
                <input type="text"  name="village" required>
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
                <label for="phone">DATE OF BIRTH</label>
                <input type="text"  name="date_of_birth" required>
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
    $fathersname = $_POST['fathersname'];
    $mothersname = $_POST['mothersname'];
    $province = $_POST['province'];
    $district = $_POST['district'];
    $sector = $_POST['sector'];
    $cell = $_POST['cell'];
    $village = $_POST['village'];
    $physical_code = $_POST['physical_code'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $name = $firstname . ' ' . $lastname; // Assuming you want to combine first name and last name as the institution name
    
    // Assuming you have stored username in the session
    $created_by = $_SESSION['username'];

    // Hashing the password using MD5 (not recommended for security, consider using stronger hashing methods)
    $password = md5($_POST['password']);

    try {
        // Prepare the SQL statement with placeholders
        $sql = "INSERT INTO institution (name, fathersname, mothersname, province, district, sector, cell, village, physical_code, email, phone, created_by, password) VALUES (:name, :fathersname, :mothersname, :province, :district, :sector, :cell, :village, :physical_code, :email, :phone, :created_by, :password)";
        
        // Prepare statement
        $stmt = $pdo->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':fathersname', $fathersname);
        $stmt->bindParam(':mothersname', $mothersname);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':district', $district);
        $stmt->bindParam(':sector', $sector);
        $stmt->bindParam(':cell', $cell);
        $stmt->bindParam(':village', $village);
        $stmt->bindParam(':physical_code', $physical_code);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':created_by', $created_by); // Bind username from session
        $stmt->bindParam(':password', $password); // Bind hashed password
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('New Institution has been added');</script>";
        } else {
            echo "<script>alert('Error: Unable to execute statement');</script>";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
