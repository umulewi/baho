<?php
session_start();
if (!isset($_SESSION['provider_email'])) {
    header("Location: ../index.php");
    exit();
}
$user_email = $_SESSION['provider_email'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
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
            max-width: 800px;
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
        button {
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
        @media (max-width: 600px) {
            .form-row > div {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
<main>

<?php
$job_seeker_id = $_GET['job_seeker_id'];

include '../connection.php';
$stmt = $pdo->prepare("SELECT * FROM job_seeker JOIN users ON job_seeker.users_id = users.users_id WHERE job_seeker_id = :job_seeker_id");
$stmt->bindParam(':job_seeker_id', $job_seeker_id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$salaryWithCurrency = $row['salary'] . ' RWF';
$email = $row['email'];

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
                    <textarea style="height: x;" id="bio" name="bio" required readonly><?php echo ($row['bio']); ?></textarea>
                </div>
                </div>
                
                <button type="submit" style="display: inline-block; padding: 10px 20px; margin: 10px 0; font-size: 16px; cursor: pointer; text-align: center; text-decoration: none; outline: none; color: #fff; background-color: teal; border: none; border-radius: 5px;">Hire Me</button>
            </form>
        </div>
    </main>
</div>

<?php
$stmt = $pdo->prepare("SELECT job_provider_id, first_name, last_name FROM job_provider INNER JOIN users ON users.users_id = job_provider.users_id WHERE users.email = :user_email");
$stmt->bindParam(':user_email', $user_email);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $job_provider_id = $row['job_provider_id'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
} else {
    echo "No job provider found for this email.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $job_seeker_id = filter_var($_GET['job_seeker_id'], FILTER_SANITIZE_NUMBER_INT);
    $stmt = $pdo->prepare("SELECT * FROM hired_seekers WHERE job_seeker_id = :job_seeker_id AND job_provider_id = :job_provider_id");
    $seeker_first_name = $_POST['first_name'];
    $seeker_last_name = $_POST['last_name'];
    $stmt->execute([
        ':job_seeker_id' => $job_seeker_id,
        ':job_provider_id' => $job_provider_id
    ]);
    $existing_entry = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_entry) {
        echo "<script>alert('This job seeker has already been hired by you.');</script>";
    } else {
        $sql = "INSERT INTO hired_seekers (job_seeker_id, job_provider_id, provider_first_name, provider_last_name, seeker_first_name, seeker_last_name) 
                VALUES (:job_seeker_id, :job_provider_id, :provider_first_name, :provider_last_name, :seeker_first_name, :seeker_last_name)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([
                ':job_seeker_id' => $job_seeker_id,
                ':job_provider_id' => $job_provider_id,
                ':provider_first_name' => $first_name,
                ':provider_last_name' => $last_name,
                ':seeker_first_name' => $seeker_first_name,
                ':seeker_last_name' => $seeker_last_name,
            ]);
            echo "<script>alert('Thank you for hiring our seeker, we shall communicate with you soon.');</script>";

            // Email notification
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ntegerejimanalewis@gmail.com';
                $mail->Password = 'zwhcmifrjmnlnziz';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('your_email@gmail.com');
                $mail->addAddress($email);
                $mail->isHTML(false);
                $mail->Subject = 'Confirmation';
                $mail->Body = 'You have been hired.';
                $mail->send();
                // echo "Email sent successfully!";
            } catch (Exception $e) {
                echo "Email sending failed. Error: {$mail->ErrorInfo}";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        }
    }
}
?>
</main>
</body>
</html>
