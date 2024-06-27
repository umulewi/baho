<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location: ../index.php");
    exit();
}
$user_email = $_SESSION['user_email'];
include '../connection.php';

include 'dashboard.php';
$progress = 0;
$sql = "SELECT 1 FROM users WHERE users_id = :users_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $progress += 33;
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
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
        .custom-alert-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .custom-alert-box {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 300px;
            width: 100%;
        }

        .custom-alert-message {
            margin-bottom: 20px;
        }

        .custom-alert-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<main>
    <h1 style="text-align:center;font-family:'Michroma', sans-serif;">Open Positions</h1>
    <hr style="margin: 20px auto;border: 0;height: 1px;width: 50%;background: #EA60A7;">
    <br><br>
    <div class="row">
        <?php
        $stmt = $pdo->query("SELECT * FROM jobs");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="other-div3">
                <div>
                    <?php
                    $folderPath = '../dashboard';
                    $logoFilename = $row['logo'];
                    $uniqueLogoPath = $folderPath . $logoFilename . '?' . $row['job_id']; 
                    echo '<td><img class="company-logo" src="' . htmlspecialchars($uniqueLogoPath) . '" alt="Job Logo" style="width: 50px; height: 50px;"></td>';
                    ?>
                    <h3><?php echo $row['job_title'] ?></h3>
                    <p>
                        <?php echo  $row['job_description']?> | Published on <?php echo  $row['published_date']?> | Deadline <?php echo  $row['deadline_date']?>
                    </p>
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

<!-- Custom Alert Box -->
<div class="custom-alert-overlay" id="customAlertOverlay">
    <div class="custom-alert-box">
        <div class="custom-alert-message" id="customAlertMessage"></div>
        <button class="custom-alert-button" onclick="hideCustomAlert()">OK</button>
    </div>
</div>

<script>
    function showCustomAlert(message) {
        document.getElementById('customAlertMessage').innerText = message;
        document.getElementById('customAlertOverlay').style.display = 'flex';
    }

    function hideCustomAlert() {
        document.getElementById('customAlertOverlay').style.display = 'none';
    }
</script>

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
            $query = $pdo->prepare("SELECT job_seeker_id, payment FROM job_seeker WHERE users_id = :users_id");
            $query->execute(['users_id' => $users_id]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                if (empty($result['payment'])) {
                    echo "<script>showCustomAlert('You need to pay the registration fee before applying.');</script>";
                } else {
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
                        echo "<script>showCustomAlert('Application submitted successfully.');</script>";
                    } else {
                        echo "<script>showCustomAlert('You have already applied for this job.');</script>";
                    }
                }
            } else {
                echo "<script>showCustomAlert('Job seeker not found.');</script>";
                exit();
            }
        } else {
            echo "<script>showCustomAlert('User not found.');</script>";
            exit();
        }
    } catch (PDOException $e) {
        echo "<script>showCustomAlert('Database error: " . $e->getMessage() . "');</script>";
        exit();
    }
}
?>
</body>
</html>
