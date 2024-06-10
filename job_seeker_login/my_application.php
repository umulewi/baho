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

$sql = "SELECT mothers_name, fathers_name, telephone, province, district, sector, cell, village, salary, bio, date_of_birth, ID, created_at FROM job_seeker WHERE users_id = :users_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $filledFields = 0;
    $totalFields = 12;
    
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
            width: 400px;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
        }
        .progress-bar {
            width: <?php echo $progress; ?>%;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 7px 0;
            box-sizing: border-box;
        }

        
        

        .row {
            display: flex;
            align-items: center;
        }

        

        .other-div1, .other-div2 {
            flex: 1;
            margin-right: 10px;
        }

        .progress-bar {
            
        }

        /* Media query for small screens */
        @media (max-width: 768px) {
            .row {
                flex-direction: column;
                align-items: stretch;
            }

            .progress, .other-div1, .other-div2 {
                margin-right: 0;
                
            }
        }
</style>

    </style>
</head>
<body>

<main>
   

    

    </div>
    </main>


    <main>
    <div>
       
    <div class="row">

        
        <div class="other-div1">
        
            <!-- Content for the first new div goes here -->
            <div class="progress">
                
                <div class="progress-bar">
               
                    <?php 
                    echo $progress ? $progress . "%" : "Progress not available";
                     ?>
                </div>
            </div>
        </div>
        
        <div class="other-div2">
            <div class="table-data">
                <h2>Job Application Progress</h2>
                <p>
                    The job application progress bar on this webpage visually tracks a user's progress through their job application journey. Initially set at 0%, progress increases as users complete key milestones: verifying basic information (33%), filling out profile fields (each contributing about 2.75%), and maintaining an active profile for over 15 days (adding 12%). Achieving employment sets the progress to 100%. This dynamic calculation ensures users can see their advancement clearly.
                </p>
            </div>
        </div>
    </div>
</div>
</body>

</html>

