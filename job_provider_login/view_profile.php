<?php
session_start();
if (!isset($_SESSION['provider_email'])) {
    header("location: ../index.php");
    exit();
}
$user_email = $_SESSION['provider_email']; 


?>

<?php
include'dashboard.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view my profile</title>
    <style>
        /* Form container */
        .form-container {
            max-width: 800px;
            margin: 0 auto;
           
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
        .form-container input[type="password"],
        .form-container input[type="email"],
        .form-container input[type="tel"],
        .form-container input[type="number"],

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: teal;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: darkslategray;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .form-row > div {
            flex: 1;
            min-width: 300px;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .form-row > div {
                min-width: 100%;
            }
        }
    </style>
    
</head>
<body>
<?php
include '../connection.php';  
$stmt = $pdo->prepare("SELECT * FROM job_provider JOIN users ON job_provider.users_id = users.users_id WHERE users.email = :user_email");
$stmt->bindParam(':user_email', $user_email);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="form-container">
        <main>
       <div class="table-data">
    <form action="" method="post">
    <input type="hidden" name="job_provider_id" value="<?php echo $row['job_provider_id']; ?>">
    <div class="form-row">
    <div>
            <label for="name">First Name:</label>
            <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required readonly >
        </div>
        <div>
            <label for="name">Last Name:</label>
            <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required readonly>
        </div>

    </div>
    <div class="form-row">
        <div>
            <label for="name">Date of birth:</label>
            <input type="date" name="date_of_birth" value="<?php echo $row['date_of_birth']; ?>" required readonly>
        </div>
        
        <div>
            <label for="province">Province:</label>
            <input type="text" id="province" name="province" value="<?php echo $row['province']; ?>" required readonly>
        </div>
    </div>

    <div class="form-row">
        <div>
            <label for="district">District:</label>
            <input type="text" id="district" name="district" value="<?php echo $row['district']; ?>" required readonly>
        </div>
        <div>
            <label for="sector">Sector:</label>
            <input type="text" id="sector" name="sector" value="<?php echo $row['sector']; ?>" required readonly>
        </div>
    </div>
    <div class="form-row">
        <div>
            <label for="village">Village:</label>
            <input type="text" id="village" name="village" value="<?php echo $row['village']; ?>" required readonly>
   
        </div>
        
        <div>
            <label for="village">Gender:</label>
            <input type="text" id="gender" name="gender" value="<?php echo $row['gender']; ?>" required readonly>
   
        </div>
        </div>
        <div class="form-row">
        <div>
            <label for="cell">Cell:</label>
            <input type="text" id="cell" name="cell" value="<?php echo $row['cell']; ?>" required readonly>
        </div>
        <div>
            <label for="id">Id Card</label>
            <input type="number" id="ID" name="ID" value="<?php echo $row['ID']; ?>" required readonly>
        </div>
    </div>
    <div class="form-row">

        <div>
            <label for="id">Telephone:</label>
            <input type="text" id="ID" name="telephone" value="<?php echo $row['telephone']; ?>" required readonly>
        </div>
        <div>
            <label for="id">Password:</label>
            <input type="text" id="ID" name="password" value="<?php echo $row['password']; ?>" required readonly>
        </div>
    </div>
        
    </form>
</div>
    </main>
    </div>
</body>
</html>



