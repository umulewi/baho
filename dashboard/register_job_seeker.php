<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location:login.php");
    exit();
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
        .form-container input[type="file"],
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
            
            <h2 style="text-align:center;margin-top:2rem;color:teal">Register job Seeker</h2><br>
        <form action="" method="post" enctype="multipart/form-data">
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
                    <label for="email">Father's name:</label>
                    <input type="email"  name="fathers_name" required>
                </div>
                <div>
                    <label for="phone">Mother's name:</label>
                    <input type="text"  name="mothers_name" required>
                </div>
            </div>
            <div class="form-row">
            <div>
                    <label for="salary">Salary</label>
                    <select name="salary" required>
                    <option value="">choose salary</option>
                        <option value="35000-99000">35000RWF-99000RWF</option>
                        <option value="159000-199000">159000RWF-199000RWF</option>
                        <option value="200000-299000">200000RWF-299000RWF</option>
                        
                    </select>
                </div>
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
            </div>
            <div class="form-row">
                <div>
                    <label for="district">District:</label>
                    <input type="text"  name="district" required>
                </div>
                <div>
                    <label for="phone">Sector:</label>
                    <input type="text"  name="sector" required>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="phone">Cell:</label>
                    <input type="text"  name="cell" required>
                </div>
                <div>
                    <label for="phone">Village:</label>
                    <input type="text"  name="village" required>
                </div>

            </div>

            <div class="form-row">
            <div>
                        <label for="physical_code">Email:</label>
                        <input type="text" id="email" name="email" required>
                    </div>
                <div>
                    <label for="gender">Gender:</label>
                    <select name="gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>

                
                
            <div class="form-row">
                    
                    <div>
                        <label for="phone">Phone Number:</label>
                        <input type="text" id="phone" name="telephone" required>
                    </div>
                    <div>
            <label for="email">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
                </div>
                <div class="form-row">
                
             <div>
            <label for="date_of_birth">Date of birth:</label>
            <input type="date" name="date_of_birth" id="date_of_birth" required>
            </div>
            <div>
                <label for="id">ID</label>
                <input type="file" id="id" name="id" maxlength="16" pattern="[0-9]{16}" title="Please enter a 16-digit ID number." required>
            </div>
                </div>

                <div class="form-row">
                
            <div>
                <label for="bio">Bio:</label>
                <textarea style="height:133px;" id="bio" name="bio" required ></textarea>
            </div>
                </div>
            <div>
                <input type="submit" name="register" value="Register" stayle="background-color:red">
            </div>
        </form>
    </div>
    </main>
    </div>
			
			
</body>
</html>
<?php
include '../connection.php';

if (isset($_POST["register"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $fathers_name = $_POST['fathers_name'];
    $mothers_name = $_POST['mothers_name'];
    $full_name = $firstname . ' ' . $lastname; 
    $province = $_POST['province'];
    $district = $_POST['district'];
    $sector = $_POST['sector'];
    $cell = $_POST['cell'];
    $village = $_POST['village'];
    $date_of_birth = $_POST['date_of_birth'];

    $created_by = $_SESSION['user_email'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $telephone = $_POST['telephone'];
    $gender = $_POST['gender'];
    $bio = $_POST['bio'];
    $salary = $_POST['salary'];
    $role_id = $_GET['role_id'];
    $created_by=$_SESSION['user_email'];
    

    if (isset($_FILES['id']) && $_FILES['id']['error'] == 0) {
        $id = $_FILES['id'];
        $upload_dir = '../uploads/'; // Define your upload directory
        $file_name = basename($id['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($id['tmp_name'], $target_file)) {
            // File is uploaded successfully
        } else {
            echo "Error uploading the file.";
            exit;
        }
    } else {
        echo "File upload error.";
        exit;
    }

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

    // Insert into job_seeker table using the last inserted users_id
    $stmt_job_seeker = $pdo->prepare("INSERT INTO job_seeker (users_id, role_id, fathers_name, mothers_name,salary, province, district, sector, cell, village, date_of_birth,bio, id,created_by) VALUES (:users_id, :role_id, :fathers_name, :mothers_name,:salary, :province, :district, :sector, :cell, :village, :date_of_birth, :bio,:id,:created_by)");
    $stmt_job_seeker->bindParam(':users_id', $users_id);
    $stmt_job_seeker->bindParam(':role_id', $role_id);
    $stmt_job_seeker->bindParam(':fathers_name', $fathers_name);
    $stmt_job_seeker->bindParam(':mothers_name', $mothers_name);
    $stmt_job_seeker->bindParam(':salary', $salary);
    $stmt_job_seeker->bindParam(':province', $province);
    $stmt_job_seeker->bindParam(':district', $district);
    $stmt_job_seeker->bindParam(':sector', $sector);
    $stmt_job_seeker->bindParam(':cell', $cell);
    $stmt_job_seeker->bindParam(':village', $village);
    $stmt_job_seeker->bindParam(':date_of_birth', $date_of_birth);
    $stmt_job_seeker->bindParam(':bio', $bio);
    if ($target_file) {
        $stmt_job_seeker->bindParam(':id', $target_file);

    }

    $stmt_job_seeker->bindParam(':created_by', $created_by);

    try {
        if ($stmt_job_seeker->execute()) {
            echo "<script>alert('New job seeker has been added');</script>";
        } else {
            echo "<script>alert('Error: Unable to execute statement');</script>";
        }
    } catch(PDOException $e) {
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