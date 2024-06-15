<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location: ../ind.php");
    exit();
}
$user_email = $_SESSION['user_email']; 
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
            max-width: 750px;
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

if (!isset($_SESSION['user_email'])) {
    header("location: ../index.php");
    exit();
}
$user_email = $_SESSION['user_email']; 
?>
<?php
include 'dashboard.php'; 
?>

<?php
include '../connection.php';  
$stmt = $pdo->prepare("SELECT * FROM job_seeker JOIN users ON job_seeker.users_id = users.users_id WHERE users.email = :user_email");
$stmt->bindParam(':user_email', $user_email);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="form-container">
   
   <main>
       <div class="table-data">
    <form action="" method="post">
    <input type="hidden" name="job_seeker_id" value="<?php echo $row['job_seeker_id']; ?>">
    <div class="form-row">
            <div>
                <label for="name">First name:</label>
                <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required readonly>
            </div>
            <div>
                <label for="name">Last name:</label>
                <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required readonly>
            </div>
        
        </div>
        <div class="form-row">
            <div>
            <label for="name">Father's name:</label>
            <input type="text" name="fathers_name" value="<?php echo $row['fathers_name']; ?>" required readonly>
        </div>
        <div>
            <label for="name">Mother's name:</label>
            <input type="text" name="mothers_name" value="<?php echo $row['mothers_name']; ?>" required readonly >
        </div>
        </div>
        <div class="form-row">
            <div>
                <label for="name">Date of birth:</label>
                <input type="date" name="date_of_birth" value="<?php echo $row['date_of_birth']; ?>" required readonly >
            </div>
            <div>
                <label for="province">Gender:</label>
                <input type="text" id="gender" name="gender" value="<?php echo $row['gender']; ?>" required readonly >
            </div>
        </div>
        <div class="form-row">
            <div>
                <label for="province">Province:</label>
                <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required readonly>
            </div>
            <div>
                <label for="district">District:</label>
                <input type="text" id="district" name="district" value="<?php echo $row['district']; ?>" required readonly>
            </div>
        </div>
        <div class="form-row">
            <div>
                <label for="sector">Sector:</label>
                <input type="text" id="sector" name="sector" value="<?php echo $row['sector']; ?>" required readonly>
            </div>
            <div>
                <label for="village">Village:</label>
                <input type="text" id="village" name="village" value="<?php echo $row['village']; ?>" required readonly>
            </div>
        </div>
        <div class="form-row">
            <div>
                <label for="cell">Cell:</label>
                <input type="text" id="cell" name="cell" value="<?php echo $row['cell']; ?>" required readonly>
            </div>
            
            <div>
                <label for="id">Telephone:</label>
                <input type="text" id="ID" name="telephone" value="<?php echo $row['telephone']; ?>" required readonly>
            </div>
        </div>
        
        <div class="form-row">
            <div>
                <label for="id">Salary:</label>
                <input type="text" id="salary" name="salary" value="<?php echo $row['salary']; ?>" required readonly>
            </div>
            <div>
                <label for="id">Bio:</label>
                <input type="text" id="bio" name="bio" value="<?php echo $row['bio']; ?>" required readonly>
            </div>
        </div>
        <div class="form-row">
        
        </div>
        <?php
                error_reporting(0);  
                include '../connection.php';
                $user_email = $_SESSION['user_email']; 
                try {
                    $stmt = $pdo->query("SELECT * FROM job_seeker JOIN users ON job_seeker.users_id = users.users_id WHERE users.email = '$user_email'");
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows as $row) {
                         $imagePath = str_replace('uploads/', 'uploads/', $row['ID']);
                         $imageMimeType = mime_content_type($imagePath);
                         ?>
                         <label for="gender">ID CARD:</label>
                         <div>
                            <a href="#" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
                                <h2 class="m-0 text-primary">
                                    <img src="<?php echo $imagePath; ?>" style="height: 200px; width: 300px;" class="img-fluid" <?php echo 'data-mime="' . $imageMimeType . '"'; ?>>
                                </h2>
                            </a>
                        </div>
                        <?php 
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>
    </form>
</div>
</main>
</div>

</body>
</html>
