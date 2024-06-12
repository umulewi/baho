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
    <div class="row">
        <div class="other-div1">
            <div class="table-data">
                <h2 style="color:teal">Welcome to Kozi Caretaker!</h2>
                <ul style="margin-left:2rem">
                    <li><svg xmlns="http://www.w3.org/2000/svg" width="15px" height="em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10m0-6a4 4 0 1 0 0-8a4 4 0 0 0 0 8"/></svg>Diverse Job Listings: From housekeeping to specialized services, find the perfect job that matches your expertise.</li><br>
                    <li><svg xmlns="http://www.w3.org/2000/svg" width="15px" height="em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10m0-6a4 4 0 1 0 0-8a4 4 0 0 0 0 8"/></svg>Skill Development: Enhance your skills with our training programs and workshops.</li><br>
                    <li><svg xmlns="http://www.w3.org/2000/svg" width="15px" height="em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10m0-6a4 4 0 1 0 0-8a4 4 0 0 0 0 8"/></svg>Supportive Community: Connect with other job seekers and share experiences and advice.</li><br>
                    <li><svg xmlns="http://www.w3.org/2000/svg" width="15px" height="em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10m0-6a4 4 0 1 0 0-8a4 4 0 0 0 0 8"/></svg>Personalized Recommendations: Get job suggestions based on your profile and preferences.</li><br>
                    <li><svg xmlns="http://www.w3.org/2000/svg" width="15px" height="em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10m0-6a4 4 0 1 0 0-8a4 4 0 0 0 0 8"/></svg>Exclusive Opportunities: Access job listings that are only available to our members.</li>
                </ul>
                <p>Thank you for choosing Kozi Caretakers. Together, we're transforming homes and empowering lives. Start exploring opportunities and take the next step in your career today!</p>
            </div>
        </div>
        <div class="other-div2">
            <div class="table-data">
                <h2 style="color:teal">Application Status Update</h2>
            </div>
            <div class="progress">
                <div class="progress-bar">
                    <?php echo $progress ? $progress . "%" : "Progress not available"; ?>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <h2 style="color:teal">Open positions:</h2><br>
    <div class="row">
        <?php
        $stmt = $pdo->query("SELECT * FROM jobs");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="other-div3">
                <div>
                    <div>District Sales TL <?php echo $row['job_id']; ?></div>
                    <div><?php echo $row['job_title']; ?> | <?php echo $row['location']; ?></div>
                    <div><?php echo $row['description']; ?></div>
                    <form action="" method="post">
                        <input type="hidden" name="job_id" value="<?php echo $row['job_id']; ?>">
                        <input type="submit" name="apply" value="Apply" style="width: 30%; padding: 10px; border: none; border-radius: 5px; background-color: teal; font-size: 16px; cursor: pointer;">
                    </form>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
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
