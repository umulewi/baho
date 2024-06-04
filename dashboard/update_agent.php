<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location:../index.php");
    exit();
}
include('../connection.php');

$agent_id = $_GET['agent_id'];
$stmt = $pdo->prepare("SELECT users_id FROM agent WHERE agent_id = ?");
$stmt->execute([$agent_id]); 
$user_id = $stmt->fetchColumn(); 
$stmt->closeCursor(); 
echo "User ID: " . $user_id;
$pdo = null;
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
$id = $_GET['agent_id'];
include '../connection.php';
$stmt = $pdo->prepare("SELECT * FROM users JOIN agent ON users.users_id = agent.users_id WHERE agent.agent_id = :agent_id");
$stmt->bindParam(':agent_id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="form-container">

		<main>
            <div class="table-data">
    <form action="" method="post">
        <div class="form-row">
            <div>
                <label for="name">Agent's first name:</label>
                <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required>
            </div>
            <div>
                <label for="name">Agent's last name:</label>
                <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required>
            </div>
        </div>
        <div class="form-row">
        <div>
            <label for="gender">Gender:</label>
            <input type="text" id="gender" name="gender" value="<?php echo $row['gender']; ?>" required>
        </div>
        <div>
            <label for="dob">Date of birth:</label>
            <input type="date" id="dob" name="date_of_birth" value="<?php echo htmlspecialchars($row['date_of_birth']); ?>" required>
        </div>
    </div>
    <div class="form-row">
        <div>
            <label for="province">Province:</label>
            <input type="text" id="province" name="province" value="<?php echo $row['province']; ?>" required>
        </div>
        <div>
            <label for="district">District:</label>
            <input type="text" id="district" name="district" value="<?php echo $row['district']; ?>" required>
        </div>
    </div>

    <div class="form-row">
        <div>
            <label for="sector">Sector:</label>
            <input type="text" id="sector" name="sector" value="<?php echo $row['sector']; ?>" required>
        </div>
        <div>
            <label for="village">Village:</label>
            <input type="text" id="village" name="village" value="<?php echo $row['village']; ?>" required>
        </div>
    </div>
    <div class="form-row">
        <div>
            <label for="cell">Cell:</label>
            <input type="text" id="cell" name="cell" value="<?php echo $row['cell']; ?>" required>
        </div>
        <div>
            <label for="id">Id Cards:</label>
            <input type="text" id="ID" name="ID" value="<?php echo $row['ID']; ?>" required>
        </div>
    </div>
        <div>
            <input type="submit" name="update" value="Update" style="background-color: teal;">
        </div>
    </form>
    </div>
    </main>
    </div>
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
    $ID = htmlspecialchars($_POST['ID']);
    
    try {

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
            echo "Well updated";
        } else {
            echo "<script>alert('No records updated.');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
