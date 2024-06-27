<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location: ../index.php");
    exit();
}
$user_email = $_SESSION['user_email'];
include '../connection.php';

try {
    $query = $pdo->prepare("SELECT users_id FROM users WHERE email = :email");
    $query->execute(['email' => $user_email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $users_id = $user['users_id'];
    } else {
        echo "User not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit();
}

include 'dashboard.php';
$progress = 0;
$sql = "SELECT 1 FROM users WHERE users_id = :users_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $progress += 33;
}

$sql = "SELECT mothers_name, fathers_name, telephone, province, district, sector, cell, village, salary, bio, date_of_birth, ID, created_at, payment FROM job_seeker WHERE users_id = :users_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $filledFields = 0;
    $totalFields = 13;
    
    if (!empty($result['mothers_name'])) { $filledFields++; }
    if (!empty($result['fathers_name'])) { $filledFields++; }
    if (!empty($result['telephone'])) { $filledFields++; }
    if (!empty($result['province'])) { $filledFields++; }
    if (!empty($result['district'])) { $filledFields++; }
    if (!empty($result['sector'])) { $filledFields++; }
    if (!empty($result['cell'])) { $filledFields++; }
    if (!empty($result['village'])) { $filledFields++; }
    if (!empty($result['salary'])) { $filledFields++; }
    if (!empty($result['bio'])) { $filledFields++; }
    if (!empty($result['date_of_birth'])) { $filledFields++; }
    if (!empty($result['ID'])) { $filledFields++; }
    if (!empty($result['payment'])) { 
        $filledFields++; 
        // Adding 15% progress if payment is not empty
        $progress += (15 / $totalFields); 
    }

    $progress += (33 / $totalFields) * $filledFields;
    $created_at = new DateTime($result['created_at']);
    $now = new DateTime();
    $interval = $now->diff($created_at);
    if ($interval->days > 15) {
        $progress += 12;
    }
}

$sql = "SELECT job_seeker_id FROM job_seeker WHERE users_id = :users_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $job_seeker_id = $result['job_seeker_id'];
    $sql = "SELECT 1 FROM hired_seekers WHERE job_seeker_id = :job_seeker_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':job_seeker_id', $job_seeker_id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $progress = 100;
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Application Progress</title>
    <style>
        .progress {
            width: 100%;
            max-width: 400px;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
        }
        .progress-bar {
            width: <?php echo $progress; ?>%;
            background-color: teal;
            color: white;
            text-align: center;
            padding: 7px 0;
            box-sizing: border-box;
        }
        .company-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .other-div1, .other-div2 {
            flex: 1 1 100%;
        }
        @media (min-width: 768px) {
            .other-div1, .other-div2 {
                flex: 1 1 calc(50% - 10px);
            }
        }
        .other-div3 {
            width: 48%;
            background-color: #fff;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            margin-bottom: 1rem;
            padding: 1rem;
            box-sizing: border-box;
        }
        @media (max-width: 768px) {
            .other-div3 {
                width: 100%;
            }
        }
        
    </style>
</head>
<body>
<main>

    
<h1 style="text-align:center;font-family:'Michroma', sans-serif;">Application Status & Benefits of Kozi Caretakers</h1>
    
<hr style="margin: 20px auto;border: 0;height: 1px;width: 50%;background: #EA60A7; ">
    <div class="row">
        <div class="other-div3">
           
                <h2 style="color:teal">Benefits of Kozi Caretakers
                </h2>
                <ul style="margin-left:"><br>
                    <li style="text-align: justify;">Wide Range of Opportunities: Discover diverse job listings tailored to your skills, spanning from housekeeping to specialized services.
                    </li><br>
                    <li style="text-align: justify;">Continuous Skill Enhancement: Engage in our comprehensive training programs and workshops to sharpen your professional skills.</li><br>
                    <li style="text-align: justify;">Community Support: Connect with a supportive community of fellow job seekers to share experiences and gain valuable advice.</li><br>
                    <li style="text-align: justify;">Exclusive Access: Gain access to exclusive job listings available only to Kozi Caretaker members, enhancing your employment opportunities.</li><br>
                    <li style="text-align: justify;">Thank you for choosing Kozi Caretakers. Together, we're transforming homes and empowering lives.</li><br>
                    
            
        </div>
        <div class="other-div3">
           
                <h2 style="color:teal">Application Status Update</h2>
            
            <div class="progress">
                <div class="progress-bar">
                    <?php echo $progress ? $progress . "%" : "Progress not available"; ?>
                </div>
            </div>
            <strong> Step 1: Initial Sign-up:</strong>
Start your journey with us! Your application status begins at 36%. Sign up and create your profile.<br>

<strong> Step 2: Complete Your Profile:</strong>
Update your information and complete your profile details to increase your status to 66%. Provide accurate information to enhance your job opportunities.<br>

<strong>Step 3: Get Recruited:</strong>
Congratulations! Once recruited, your application status reaches 100%. You are now part of our team and ready to begin your new role.<br>

<strong>Step 4: Start Working ðŸ’¼</strong>
Begin working and making a difference! Your journey with us starts here. Dive into your responsibilities and contribute to our community.<br><br>

<span style="font-size: 14px;">Track your progress and take the next step in your career journey with us!</span></p>
    
        </div>
    </div>
    <br><br>
   

    
        </main>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['apply'])) {
    include '../connection.php';
    $job_id = $_POST['job_id'];

    try {
        $query = $pdo->prepare("SELECT users_id FROM users WHERE email = :email");
        $query->execute(['email' => $user_email]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $users_id = $user['users_id'];
            $query = $pdo->prepare("SELECT job_seeker_id FROM job_seeker WHERE users_id = :users_id");
            $query->execute(['users_id' => $users_id]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $job_seeker_id = $result['job_seeker_id'];

                // Check if the user has already applied for this job
                $checkQuery = $pdo->prepare("SELECT COUNT(*) FROM applied WHERE job_id = :job_id AND job_seeker_id = :job_seeker_id");
                $checkQuery->execute(['job_id' => $job_id, 'job_seeker_id' => $job_seeker_id]);
                $applicationCount = $checkQuery->fetchColumn();

                if ($applicationCount == 0) {
                    // Insert the application if the user has not applied for this job yet
                    $sql = "INSERT INTO applied (job_id, job_seeker_id) VALUES (:job_id, :job_seeker_id)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
                    $stmt->bindParam(':job_seeker_id', $job_seeker_id, PDO::PARAM_INT);
                    $stmt->execute();
                    echo "Application submitted successfully.";
                } else {
                    echo "You have already applied for this job.";
                }
            } else {
                echo "Job seeker not found.";
                exit();
            }
        } else {
            echo "User not found.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit();
    }
}
?>
</body>
</html>


