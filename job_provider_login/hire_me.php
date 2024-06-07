<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location: ../index.php");
    exit();
}
$user_email = $_SESSION['user_email']; 

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
   
        textarea,

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button{
            width: 40%;
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
$job_seeker_id = $_GET['job_seeker_id'];

error_reporting(0);


include '../connection.php';
$stmt = $pdo->prepare("SELECT * FROM job_seeker JOIN users ON job_seeker.users_id = users.users_id WHERE job_seeker_id=:job_seeker_id");
$stmt->bindParam(':job_seeker_id', $job_seeker_id); 
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Concatenate " USD" to the salary value
$salaryWithCurrency = $row['salary'] . ' RWF';
?>

<div class="form-container">
        <main>
       <div class="table-data">
    <form action="" method="post">

        <div style="display: flex; justify-content: center; width: 100%;">
            <img src="sample.png" alt="Avatar" style="width: 30%;">
        </div>
        <div class="form-row">
            <div>
            <label for="first_name">First name:</label>
            <input type="text" name="first_name" value="<?php echo ($row['first_name']); ?>" required readonly>
        </div>
        <div>
            <label for="last_name">Last name:</label>
            <input type="text" name="last_name" value="<?php echo ($row['last_name']); ?>" required readonly>
        </div>
    </div>
    <div class="form-row">
        <div>
            <label for="date_of_birth">Date of birth:</label>
            <input type="date" name="date_of_birth" value="<?php echo ($row['date_of_birth']); ?>" required readonly>
        </div>
        
        <div>
            <label for="province">Province:</label>
            <input type="text" id="province" name="province" value="<?php echo ($row['province']); ?>" required readonly>
        </div>

    </div>
    <div class="form-row">
        <div>
            <label for="district">District:</label>
            <input type="text" id="district" name="district" value="<?php echo ($row['district']); ?>" required readonly>
        </div>
        <div>
            <label for="sector">Sector:</label>
            <input type="text" id="sector" name="sector" value="<?php echo ($row['sector']); ?>" required readonly>
        </div>
    </div>
        
    <div class="form-row">
        <div>
            <label for="cell">Cell:</label>
            <input type="text" id="cell" name="cell" value="<?php echo ($row['cell']); ?>" required readonly>
        </div>
        <div>
            <label for="gender">Gender:</label>
            <input type="text" id="gender" name="gender" value="<?php echo ($row['gender']); ?>" required readonly>
        </div>
    </div>
    <div class="form-row">
        <div>
            <label for="salary">Salary:</label>
            <div class="currency-input">
                <input type="text" id="salary" name="salary" value="<?php echo ($salaryWithCurrency); ?>" required readonly>
            </div>
        </div>
        <div>
            <label for="bio">Bio:</label>
            <input type="text" id="id" name="id" value="<?php echo ($id); ?>" required readonly>
        </div>
    </div>
    <div>
        <label for="bio">Bio:</label>
        <textarea style="height:133px;" id="bio" name="bio" required readonly><?php echo ($row['bio']); ?></textarea>
    </div>

        <button style="display: inline-block; padding: 10px 20px; margin: 10px 0; font-size: 16px; cursor: pointer; text-align: center; text-decoration: none; outline: none; color: #fff; background-color: teal; border: none; border-radius: 5px;">hire me</button>
    </form>
</div>
    </main>
    </div>

</body>
</html>


<?php
include '../connection.php';
$stmt = $pdo->prepare("SELECT job_provider_id FROM job_provider INNER JOIN users ON users.users_id = job_provider.users_id WHERE users.email = :user_email");
$stmt->bindParam(':user_email', $user_email); 
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row) {
    $job_provider_id = $row['job_provider_id'];
} else {
    echo "No job provider found for this email.";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $job_seeker_id = filter_var($_GET['job_seeker_id'], FILTER_SANITIZE_NUMBER_INT);
    $stmt = $pdo->prepare("SELECT * FROM hired_seekers WHERE job_seeker_id = :job_seeker_id AND job_provider_id = :job_provider_id");
    $stmt->execute([
        ':job_seeker_id' => $job_seeker_id,
        ':job_provider_id' => $job_provider_id
    ]);
    $existing_entry = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($existing_entry) {
      
        echo "<script>alert('This job seeker has already been hired by you..');</script>";
        
    } else {
        $sql = "INSERT INTO hired_seekers (job_seeker_id, job_provider_id) 
                VALUES (:job_seeker_id, :job_provider_id)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([
                ':job_seeker_id' => $job_seeker_id,
                ':job_provider_id' => $job_provider_id,
            ]);
            echo "<script>alert('Thank you for hiring our seeker, we shall communicate with you soon.');</script>";
           
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        }
    }
}
?>





