<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location:login.php");
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
        
       .form-container {
        max-width: 900px;
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
        .form-container input[type="email"],xta
        .form-container input[type="tel"],
        .form-container input[type="number"],
        select,
        textarea,
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


<h2 style="text-align:center"></h2><br>
<div class="form-container">	
		<main>
            <div class="table-data">
                <form action="" method="post">
                    <div class="form-row">
                        <div>
                            <label for="name">Agent's first name:</label>
                            <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required readonly>
                        </div>
                        <div>
                        <label for="name">Agent's last name:</label>
                        <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required readonly>
                    </div>
    </div>

                    <div class="form-row">
                        <div>
                            <label for="gender">Gender:</label>
                            <input type="text" id="gender" name="gender" value="<?php echo $row['gender']; ?>" required readonly>
                        </div>
                        <div>
                            <label for="dob">Date of birth:</label>
                            <input type="date" id="dob" name="date_of_birth" value="<?php echo htmlspecialchars($row['date_of_birth']); ?>" required readonly>
                        </div>
                        
                    </div>
                    
                    <div class="form-row">
                        <div>
                            <label for="province">Province:</label>
                            <input type="text" id="province" name="province" value="<?php echo $row['province']; ?>" required readonly >
                        </div>
                        <div>
                            <label for="district">District:</label>
                            <input type="text" id="district" name="district" value="<?php echo $row['district']; ?>" required readonly>
                        </div>
                    </div>


                    <div class="form-row">
                        <div>
                            <label for="sector">sector:</label>
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
                        <label for="id">Id cards:</label>
                        <input type="text" id="ID" name="ID" value="<?php echo $row['ID']; ?>" required readonly>
                    </div>
                </div>
        
    </form>
    </div>
    </main>
    </div>
</div>

</body>
</html>



