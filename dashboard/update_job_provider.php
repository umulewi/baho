<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location:login.php");
    exit();
}
include('../connection.php');

$job_provider_id = $_GET['job_provider_id'];
$stmt = $pdo->prepare("SELECT users_id FROM job_provider WHERE job_provider_id = ?");
$stmt->execute([$job_provider_id]); 
$user_id = $stmt->fetchColumn(); 
$stmt->closeCursor(); 
// echo "User ID: " . $user_id;
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
    <title>Update Job Provider</title>
    <style>
        .form-container {
            max-width: 900px;
            margin: 0 auto;
           
        }

        /* Form fields */
        .form-container div {
            margin-bottom: 5px;
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
$id = $_GET['job_provider_id'];
include '../connection.php';

// Retrieve job provider details
$stmt = $pdo->prepare("SELECT * FROM users JOIN job_provider ON users.users_id = job_provider.users_id WHERE job_provider.job_provider_id = :job_provider_id");
$stmt->bindParam(':job_provider_id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<h2 style="text-align:center"></h2><br>
<div class="form-container">
		
		<main>
            <div class="table-data">
    <form action="" method="post">
        <div class="form-row">

        <div>
            <label for="name">Provider First Name:</label>
            <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required>
        </div>
        <div>
            <label for="name">Provider Last Name:</label>
            <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required>
        </div>
    </div>
    <div class="form-row">
    <div>
            <label for="gender">Gender:</label>
            <select name="gender">
                <option value="male" <?php echo ($row['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo ($row['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
            </select>
        </div>
        <div>
            <label for="province">Province:</label>
            <input type="text" id="province" name="province" value="<?php echo $row['province']; ?>" required>
        </div>
    </div>
    <div class="form-row">
        <div>
            <label for="district">District:</label>
            <input type="text" id="district" name="district" value="<?php echo $row['district']; ?>" required>
        </div>
        <div>
            <label for="sector">Sector:</label>
            <input type="text" id="sector" name="sector" value="<?php echo $row['sector']; ?>" required>
        </div>
    </div>
    <div class="form-row">
        <div>
            <label for="dob">Date of  birth:</label>
            <input type="date" id="dob" name="date_of_birth" value="<?php echo htmlspecialchars($row['date_of_birth']); ?>" required>
        </div>
        <div>
            <label for="village">VIllage:</label>
            <input type="text" id="village" name="village" value="<?php echo $row['village']; ?>" required>
        </div>
    </div>
    <div class="form-row">
        <div>
            <label for="cell">Cell:</label>
            <input type="text" id="cell" name="cell" value="<?php echo $row['cell']; ?>" required>
        </div>
        <div>
            <label for="ID">ID Cards:</label>
            <input type="number"  value="<?php echo htmlspecialchars($row['ID']);?>" id="id" name="id" maxlength="16" pattern="[0-9]{16}"  title="Please enter a 16-digit ID number." >
            
        </div>
    </div>
        <div>
            <input type="submit" name="update" value="Update" style="background-color: teal;">
        </div>
    </form>
    </div>
    </main>
    <div>
</div>

</body>
</html>

<?php
include '../connection.php';
if (isset($_POST['update'])) {
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $full_name = $first_name . ' ' . $last_name; 
    $gender = $_POST['gender'];

    $province = htmlspecialchars($_POST['province']);
    $district = htmlspecialchars($_POST['district']);
    $sector = htmlspecialchars($_POST['sector']);
    $village = htmlspecialchars($_POST['village']);
    $cell = htmlspecialchars($_POST['cell']);
    $date_of_birth = htmlspecialchars($_POST['date_of_birth']);

    
    try {
        // Debug: Print out the variables before executing the query
        
        
        // Update job_provider table
        $sql = "UPDATE job_provider
                SET 
                    province = :province,
                    district = :district,
                    sector = :sector,
                    cell = :cell,
                    village = :village,
                    date_of_birth = :date_of_birth,
                    ID = :ID
                WHERE job_provider_id = :job_provider_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':district', $district);
        $stmt->bindParam(':sector', $sector);
        $stmt->bindParam(':cell', $cell);
        $stmt->bindParam(':village', $village);
        $stmt->bindParam(':date_of_birth', $date_of_birth);
        $stmt->bindParam(':ID', $ID);
        $stmt->bindParam(':job_provider_id', $job_provider_id);
        $stmt->execute();

        // Update users table
        $sql2 = "UPDATE users
                 SET first_name = :first_name,
                     last_name = :last_name,
                     full_name = :full_name,
                     gender = :gender
                 WHERE users_id = :user_id";

        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(':first_name', $first_name);
        $stmt2->bindParam(':last_name', $last_name);
        $stmt2->bindParam(':full_name', $full_name);
        $stmt2->bindParam(':gender', $gender);
        $stmt2->bindParam(':user_id', $user_id);
        $stmt2->execute();

        if ($stmt->rowCount() > 0 || $stmt2->rowCount() > 0) {
            echo "<script>alert('well updated.');</script>";
        } else {
            echo "<script>alert('No records updated.');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<script>
const idInput = document.getElementById("id");
idInput.addEventListener("input", function() {
  const value = idInput.value;
  if (value.length > 16) {
    idInput.value = value.slice(0, 16); 
  }
  
});
</script>