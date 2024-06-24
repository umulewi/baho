<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("location:login.php");
    exit();
}
include('../connection.php');

// Retrieve the email from the session
$email = $_SESSION['admin_email'];

// Retrieve the users_id from the database based on the email
$stmt = $pdo->prepare("SELECT users_id FROM users WHERE email = ?");
$stmt->execute([$email]); 
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
       .form-container {
            max-width: 750px;
            margin: 0 auto;
          
        }
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
            width: 30%;
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
 
  
    <div class="form-container">
        <main>
       <div class="table-data">
        
 
       <h2 style="text-align:center;margin-top:2rem;color:teal">Register Job provider</h2><br>
        <form action="" method="post">
        <div class="form-row">
            <div>
                <label for="name">Firstname:</label>
                <input type="text"  name="firstname" required>
            </div>
            <div>
                <label for="physical_code">Lastname:</label>
                <input type="text"  name="lastname" required>
            </div>
        </div>
        <div class="form-row">
        <div>
                <label for="gender">Gender:</label>
                <select name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div>
                <label for="phone">Date of birth</label>
                <input type="date"  name="date_of_birth" required>
            </div>
        </div>
            
        <div class="form-row">
        <div>
                    <label for="province">Province</label>
                    <select name="province" required>
                        <option value="">Choose province</option>
                        <option value="KIGALI CITY">Kigali city</option>
                        <option value="Western province">Western province</option>
                        <option value="Estern province">Estern province</option>
                        <option value="North province">North province</option>
                        <option value="South province">South Province</option>
                    </select>
                </div>
            <div>
                <label for="phone">District:</label>
                <input type="text"  name="district" required>
            </div>

        </div>
            
        <div class="form-row">
        <div>
                <label for="phone">Sector:</label>
                <input type="text"  name="sector" required>
            </div>
            <div>
                <label for="phone">Cell:</label>
                <input type="text"  name="cell" required>
            </div>
        </div>
        <div class="form-row">
            <div>
                <label for="phone">Village:</label>
                <input type="text"  name="village" required>
            </div>
            <div>
            <label for="physical_code">Email:</label>
            <input type="text" id="email" name="email" required>
        </div>
            </div>

            <div class="form-row">
            <div>
            <label for="phone">Phone number:</label>
            <input type="number" id="phone" name="telephone" required>
        </div>

        <div>
            <label for="email">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

            </div>
        <div>


        </div>
            <div>
                <label for="phone">ID</label>
                <input type="number" id="id" name="id" maxlength="16" pattern="[0-9]{16}" title="Please enter a 16-digit ID number." required>
            </div>
            
            <div>
                <input type="submit" name="register" value="Register">
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
    $full_name = $firstname . ' ' . $lastname; 
    $sector = $_POST['sector'];
    $gender=$_POST['gender'];
    $cell = $_POST['cell'];
    $village = $_POST['village'];
    $date_of_birth = $_POST['date_of_birth'];
    $id=$_POST['id'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $telephone = $_POST['telephone'];
    $role_id = $_GET['role_id'];

    //Insert into users table
    $stmt_user = $pdo->prepare("INSERT INTO users (role_id, email, first_name, last_name, full_name, gender, password)
    VALUES (:role_id, :email, :first_name, :last_name, :full_name, :gender, :password)");
    $stmt_user->bindParam(':email', $email);
    $stmt_user->bindParam(':first_name', $firstname);
    $stmt_user->bindParam(':last_name', $lastname);
    $stmt_user->bindParam(':full_name', $full_name);
    $stmt_user->bindParam(':password', $password);         
    $stmt_user->bindParam(':gender', $gender);         
    $stmt_user->bindParam(':role_id', $role_id);
    $stmt_user->execute();
    $users_id = $pdo->lastInsertId();


    $stmt_job_provider = $pdo->prepare("INSERT INTO job_provider (users_id, role_id,  province, district, sector, cell, village, date_of_birth,id) VALUES (:users_id, :role_id, :province, :district, :sector, :cell, :village,:date_of_birth, :id)");
    $stmt_job_provider->bindParam(':users_id', $users_id);
    $stmt_job_provider->bindParam(':role_id', $role_id);
    $stmt_job_provider->bindParam(':province', $province);
    $stmt_job_provider->bindParam(':district', $district);
    $stmt_job_provider->bindParam(':sector', $sector);
    $stmt_job_provider->bindParam(':cell', $cell);
    $stmt_job_provider->bindParam(':village', $village);
    $stmt_job_provider->bindParam(':date_of_birth', $date_of_birth);
    $stmt_job_provider->bindParam(':id', $id);
    try {
        if ($stmt_job_provider->execute()) {
            echo "<script>alert('New job provider has been added');</script>";
        } else {
            echo "<script>alert('Error: Unable to execute statement');</script>";
        }
    } catch(PDOException $e) {
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