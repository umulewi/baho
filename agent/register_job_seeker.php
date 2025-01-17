<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location:login.php");
    exit();
}
include('../connection.php');
$user_email = $_SESSION['user_email'];
$stmt = $pdo->prepare("SELECT users_id FROM users WHERE email = ?");
$stmt->execute([$user_email]); 
$user_id = $stmt->fetchColumn(); 
$stmt->closeCursor(); 
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
    <title>Document</title>
    <style>
        .form-container {
            max-width: 750px;
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
        .form-container input[type="file"],
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
    <div class="form-container">
        <main>
            <div class="table-data">
                <h2 style="text-align:center;margin-top:2rem;color:teal">Register Job Seeker</h2><br>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div>
                            <label for="name">Firstname:</label>
                            <input type="text" name="firstname" required>
                        </div>
                        <div>
                            <label for="physical_code">Lastname:</label>
                            <input type="text" name="lastname" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div>
                            <label for="email">Father's Name:</label>
                            <input type="text" name="fathers_name" required>
                        </div>
                        <div>
                            <label for="phone">Mother's Name:</label>
                            <input type="text" name="mothers_name" required>
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
                            <label for="PROVINCE">Province:</label>
                            <select name="province">
                                <option value="KIGALI CITY">KIGALI CITY</option>
                                <option value="WESTERN PROVINCE">WESTERN PROVINCE</option>
                                <option value="ESTERN PROVINCE">ESTERN PROVINCE</option>
                                <option value="NORTH PROVINCE">NORTH PROVINCE</option>
                                <option value="SOUTH PROVINCE">SOUTH PROVINCE</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div>
                            <label for="phone">District:</label>
                            <input type="text" name="district" required>
                        </div>
                        <div>
                            <label for="phone">Sector:</label>
                            <input type="text" name="sector" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div>
                            <label for="phone">Cell:</label>
                            <input type="text" name="cell" required>
                        </div>
                        <div>
                            <label for="phone">Village:</label>
                            <input type="text" name="village" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div>
                            <label for="physical_code">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div>
                            <label for="phone">Phone Number:</label>
                            <input type="text" id="phone" name="telephone" required>
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
                            <label for="date_of_birth">Date of Birth:</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div>
                            <label for="email">Password:</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <div>
                            <label for="phone">ID:</label>
                            <input type="file" name="id" accept="image/*" required>
                        </div>
                        <div>
                            <label for="bio">Bio:</label>
                            <textarea id="bio" name="bio" required></textarea>
                        </div>
                    </div>
                    <div>
                        <input type="submit" name="register" value="Register" style="width:104px;">
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>

<?php
include '../connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

function sendVerificationEmail($email, $verification_code) {
    $verification_link = "http://localhost/baho/job_seeker_login.php?code=$verification_code";
    $subject = "Email Verification";
    $message = "Please click the following link to verify your email: $verification_link";

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ntegerejimanalewis@gmail.com'; // your email
        $mail->Password = 'zwhcmifrjmnlnziz'; // your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('ntegerejimanalewis@gmail.com', 'Ntegerejimana Lewis'); // your email and name
        $mail->addAddress($email);
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
        echo "<script>alert('Verification email sent successfully');</script>";
    } catch (Exception $e) {
        echo "Email sending failed. Error: {$mail->ErrorInfo}";
    }
}

if (isset($_POST["register"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $fathers_name = $_POST['fathers_name'];
    $mothers_name = $_POST['mothers_name'];
    $province = $_POST['province'];
    $district = $_POST['district'];
    $full_name = $firstname . ' ' . $lastname; 
    $sector = $_POST['sector'];
    $gender = $_POST['gender'];
    $cell = $_POST['cell'];
    $village = $_POST['village'];
    $date_of_birth = $_POST['date_of_birth'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $bio = $_POST['bio'];
    $salary = $_POST['salary'];
    $telephone = $_POST['telephone'];
    $role_id = $_GET['role_id'];
    $created_by = $user_email;

    // Check if email already exists
    $stmt_check_email = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt_check_email->execute([$email]);
    if ($stmt_check_email->fetchColumn() > 0) {
        echo "<script>alert('Error: This email is already registered.');</script>";
        exit();
    }

    // Handle the file upload
    if (isset($_FILES['id']) && $_FILES['id']['error'] == 0) {
        $id = $_FILES['id'];
        $upload_dir = 'uploads/'; // Define your upload directory
        $file_name = basename($id['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($id['tmp_name'], $target_file)) {
            // File is uploaded successfully
        } else {
            echo "Error uploading the file.";
            exit();
        }
    } else {
        echo "File upload error.";
        exit();
    }

    // Insert into users table
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

    // Insert into job_seeker table
    $stmt_job_provider = $pdo->prepare("INSERT INTO job_seeker (users_id, role_id, province, fathers_name, mothers_name, district, sector, cell, village, date_of_birth, id, bio, salary, created_by)
    VALUES (:users_id, :role_id, :province, :fathers_name, :mothers_name, :district, :sector, :cell, :village, :date_of_birth, :id, :bio, :salary, :created_by)");
    $stmt_job_provider->bindParam(':users_id', $users_id);
    $stmt_job_provider->bindParam(':role_id', $role_id);
    $stmt_job_provider->bindParam(':province', $province);
    $stmt_job_provider->bindParam(':district', $district);
    $stmt_job_provider->bindParam(':fathers_name', $fathers_name);
    $stmt_job_provider->bindParam(':mothers_name', $mothers_name);
    $stmt_job_provider->bindParam(':sector', $sector);
    $stmt_job_provider->bindParam(':cell', $cell);
    $stmt_job_provider->bindParam(':village', $village);
    $stmt_job_provider->bindParam(':bio', $bio);
    $stmt_job_provider->bindParam(':salary', $salary);
    $stmt_job_provider->bindParam(':date_of_birth', $date_of_birth);
    $stmt_job_provider->bindParam(':id', $target_file);
    $stmt_job_provider->bindParam(':created_by', $created_by);

    try {
        if ($stmt_job_provider->execute()) {
            // Generate verification code
            $verification_code = md5(uniqid(rand(), true));
            // Store the verification code in the database
            $stmt_update_verification_code = $pdo->prepare("UPDATE users SET verification_code = ? WHERE email = ?");
            $stmt_update_verification_code->execute([$verification_code, $email]);
            // Send verification email
            sendVerificationEmail($email, $verification_code);
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
