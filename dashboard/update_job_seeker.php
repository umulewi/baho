<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location:login.php");
    exit();
}
include('../connection.php');

$job_seeker_id = $_GET['job_seeker_id'];
$stmt = $pdo->prepare("SELECT users_id FROM job_seeker WHERE job_seeker_id = ?");
$stmt->execute([$job_seeker_id]); 
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
    <title>Update Student</title>
    <style>
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

$email = $_SESSION['user_email'];
$id = $_GET['job_seeker_id'];
include '../connection.php';
$stmt = $pdo->prepare("SELECT *
FROM users
JOIN job_seeker ON users.users_id = job_seeker.users_id
WHERE job_seeker.job_seeker_id = :job_seeker_id");
$stmt->bindParam(':job_seeker_id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?> 


<div class="form-container">
		
		<main>
            <div class="table-data">
                <form action="" method="post">
                <div class="form-row">
        <div>
            <label for="name">Seeke's first name:</label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($row['first_name']); ?>" required>
        </div>
        <div>
            <label for="name">Seeker's last name:</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($row['last_name']); ?>" required>
        </div>
        </div>
        <div class="form-row">
        <div>
            <label for="fathers_name">Father;s name:</label>
            <input type="text" id="fathers_name" name="fathers_name" value="<?php echo htmlspecialchars($row['fathers_name']); ?>" required>
        </div>
        <div>
            <label for="mothers_name">Mothers'name:</label>
            <input type="text" id="mothers_name" name="mothers_name" value="<?php echo htmlspecialchars($row['mothers_name']); ?>" required>
        </div>
        </div>
        
        <div class="form-row">
        <div>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
        </div>
        
        <div>
            <label for="province">Province</label>
            <select name="province" required>
                <option value="KIGALI CITY" <?php echo ($row['province']=='kigali city')? 'selected' : ''; ?>>Kigali city</option>
                <option value="Western province" <?php echo ($row['province']=='western province')? 'selected' : ''; ?>>Western province</option>
                <option value="Estern province" <?php echo ($row['province']=='Estern province')? 'selected' : ''; ?>>Estern province</option>
                <option value="North province" <?php echo ($row['province']=='North province')? 'selected' : ''; ?>>North province</option>
                <option value="South province" <?php echo ($row['province']=='South province')? 'selected' : ''; ?>>South Province</option>
            </select>
        </div>
        </div>
        <div class="form-row">
        <div>
            <label for="district">District:</label>
            <input type="text" id="district" name="district" value="<?php echo htmlspecialchars($row['district']); ?>" required>
        </div>
        <div>
            <label for="sector">Sector:</label>
            <input type="text" id="sector" name="sector" value="<?php echo htmlspecialchars($row['sector']); ?>" required>
        </div>

        </div>
        
        <div class="form-row">
        <div>
            <label for="village">Village:</label>
            <input type="text" id="village" name="village" value="<?php echo htmlspecialchars($row['village']); ?>" required>
        </div>
        <div>
            <label for="cell">Cell:</label>
            <input type="text" id="cell" name="cell" value="<?php echo htmlspecialchars($row['cell']); ?>" required>
        </div>
        </div>
        <div class="form-row">
        <div>
            <label for="dob">DATE OF BIRTH:</label>
            <input type="date"  name="date_of_birth" id="date_of_birth" value="<?php echo htmlspecialchars($row['date_of_birth']); ?>" required>
        </div>
        <div>
            <label for="gender">GENDER:</label>
            <select name="gender">
                <option value="male" <?php echo ($row['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo ($row['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
            </select>
        </div>
        </div>
        <div class="form-row">
            
            <div>
            <label for="cell">SALARY:</label>
                <select name="salary">
                <option value="35000-99000" <?php echo($row['salary']=='35000-99000') ?  'selected': ''; ?>>35000RWF-99000RWF</option>
                <option value="159000-199000">159000RWF-199000RWF</option>
                <option value="200000-299000">200000RWF-299000RWF</option>
            </select>
            </div>
        <div>
            <label for="cell">SALARY:</label>
            <input type="number" id="cell" name="salary" value="<?php echo htmlspecialchars($row['salary']);?>" required>
        </div>
        <div>
            <label for="bio" class="">BIO:</label>
            <textarea id="bio" name="bio" required><?php echo ($row['bio']); ?></textarea>
        </div>
        </div>
        
        <div>
            <label for="ID">ID CARDS:</label>
            <input type="number"  value="<?php echo htmlspecialchars($row['ID']);?>" id="id" name="id" maxlength="16" pattern="[0-9]{16}"  title="Please enter a 16-digit ID number." >
            
        </div>
        <div>
            <input type="submit" name="update" value="Update" style="background-color: teal;">
        </div>    
               
        
    </form>
</div>
			
		</main>
		<!-- MAIN -->
	</section>

</body>
</html>


<?php
include '../connection.php';

if (isset($_POST['update'])) {
    $job_seeker_id = $_GET['job_seeker_id'];
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $full_name = $first_name . ' ' . $last_name;
    $gender = $_POST['gender'];
    $salary = $_POST['salary'];
    $fathers_name = htmlspecialchars($_POST['fathers_name']);
    $mothers_name = htmlspecialchars($_POST['mothers_name']);
    $province = htmlspecialchars($_POST['province']);
    $district = htmlspecialchars($_POST['district']);
    $sector = htmlspecialchars($_POST['sector']);
    $village = htmlspecialchars($_POST['village']);
    $cell = htmlspecialchars($_POST['cell']);
    $bio = htmlspecialchars($_POST['bio']);
    $date_of_birth = htmlspecialchars($_POST['date_of_birth']);
    


    try {
        // Update job_seeker table
        $sql = "UPDATE job_seeker
                SET fathers_name = :fathers_name,
                    mothers_name = :mothers_name,
                    province = :province,
                    district = :district,
                    salary = :salary,
                    bio = :bio,
                    sector = :sector,
                    cell = :cell,
                    village = :village,
                    date_of_birth = :date_of_birth,
                    ID = :ID
                WHERE job_seeker_id = :job_seeker_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':fathers_name', $fathers_name);
        $stmt->bindParam(':mothers_name', $mothers_name);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':district', $district);
        $stmt->bindParam(':sector', $sector);
        $stmt->bindParam(':salary', $salary);
        $stmt->bindParam(':cell', $cell);
        $stmt->bindParam(':village', $village);
        $stmt->bindParam(':date_of_birth', $date_of_birth);
        $stmt->bindParam(':ID', $ID);
        $stmt->bindParam(':bio', $bio);
        $stmt->bindParam(':job_seeker_id', $job_seeker_id);
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
            echo "<script>alert('Updated');</script>";
          } else {
            echo "<script>alert('Update atleast one record');</script>";
          }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<script>
    var today = new Date();
    var maxDate = new Date();
    maxDate.setFullYear(today.getFullYear() - 18);
    var maxDateFormatted = maxDate.toISOString().split('T')[0];
    document.getElementById("date_of_birth").setAttribute("max", maxDateFormatted);
</script>

<script>
const idInput = document.getElementById("id");
idInput.addEventListener("input", function() {
  const value = idInput.value;
  if (value.length > 16) {
    idInput.value = value.slice(0, 16); 
  }
  
});
</script>