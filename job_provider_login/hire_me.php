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
        textarea,
        .form-container input[type="password"],
        .form-container input[type="date"],
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
        <style>
        .currency-input {
            position: relative;
            display: inline-block;
            width: fit-content;
        }
        .currency-input input {
            padding-right: 0px; /* Adjust based on the width of the "USD" text */
        }
        .currency-input .currency-text {
            position: absolute;
            right: 10px; /* Adjust to position the text correctly */
            top: 90%;
            transform: translateY(-0%);
            pointer-events: none; /* Make sure the span doesn't block the input field */
            color: #000; /* Adjust color to match the input field text */
        }
    </style>
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

<h2 style="text-align:center"></h2><br>
<div class="form-container">
    <form action="" method="post">

        <div style="display: flex; justify-content: center; width: 100%;">
            <img src="sample.png" alt="Avatar" style="width: 30%;">
        </div>

        <div>
            <label for="first_name">FIRST NAME:</label>
            <input type="text" name="first_name" value="<?php echo ($row['first_name']); ?>" required readonly>
        </div>
        <div>
            <label for="last_name">LAST NAME:</label>
            <input type="text" name="last_name" value="<?php echo ($row['last_name']); ?>" required readonly>
        </div>
        <div>
            <label for="date_of_birth">DATE OF BIRTH:</label>
            <input type="date" name="date_of_birth" value="<?php echo ($row['date_of_birth']); ?>" required readonly>
        </div>
        
        <div>
            <label for="province">PROVINCE:</label>
            <input type="text" id="province" name="province" value="<?php echo ($row['province']); ?>" required readonly>
        </div>
        <div>
            <label for="district">DISTRICT:</label>
            <input type="text" id="district" name="district" value="<?php echo ($row['district']); ?>" required readonly>
        </div>
        <div>
            <label for="sector">SECTOR:</label>
            <input type="text" id="sector" name="sector" value="<?php echo ($row['sector']); ?>" required readonly>
        </div>
        
        
        <div>
            <label for="cell">CELL:</label>
            <input type="text" id="cell" name="cell" value="<?php echo ($row['cell']); ?>" required readonly>
        </div>
        <div>
            <label for="gender">GENDER:</label>
            <input type="text" id="gender" name="gender" value="<?php echo ($row['gender']); ?>" required readonly>
        </div>
        
        <div>
            <label for="salary">SALARY:</label>
            <div class="currency-input">
                <input type="text" id="salary" name="salary" value="<?php echo ($salaryWithCurrency); ?>" required readonly>
            </div>
        </div>
        <div>
    <label for="bio">BIO:</label>
    <textarea id="bio" name="bio" required readonly><?php echo ($row['bio']); ?></textarea>
</div>

        <button style="display: inline-block; padding: 10px 20px; margin: 10px 0; font-size: 16px; cursor: pointer; text-align: center; text-decoration: none; outline: none; color: #fff; background-color: teal; border: none; border-radius: 5px;">hire me</button>
    </form>
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
        echo "This job seeker has already been hired by you.";
    } else {
        $sql = "INSERT INTO hired_seekers (job_seeker_id, job_provider_id) 
                VALUES (:job_seeker_id, :job_provider_id)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([
                ':job_seeker_id' => $job_seeker_id,
                ':job_provider_id' => $job_provider_id,
            ]);
            echo "Thank you for hiring our seeker, we shall communicate with you soon.<br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        }
    }
}
?>





