<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: ../../../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Dashboard</title>
    <style>
        .body-container {
            display: flex;
            flex-direction: row;
            width: 100%;
           
            max-width: 1000px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
            background: white;
            transition: transform 0.3s;
            gap: 20px; /* Added gap between columns */
        }

        .description {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-top: -2%;
        }

        .description h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
            font-family: 'Michroma', sans-serif;
        }

        .description p {
            font-size: 16px;
            margin-bottom: 20px;
            color: #666;
        }

        .update-button {
            background-color: #EA60A7;
            color: white;
            width: 50%;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .update-button:hover {
            background-color: #503141;
        }

        .picture-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            padding: 40px; /* Added padding to match the description section */
        }

        .profile-picture {
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .profile-picture:hover {
            transform: scale(1.1);
        }

        .apply-container {
            width: 80%;
            max-width: 1200px;
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            margin-left: 5%;
        }

        .position {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-bottom: 20px;
        }

        .company-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 20px;
        }

        .position-details {
            flex: 1;
        }

        .position-details h3 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .position-details p {
            margin: 5px 0 10px;
            color: #666;
        }

        .apply-button {
            background-color: #EA60A7;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .apply-button:hover {
            background-color: #503141;
        }

        @media (max-width: 768px) {
            .body-container {
                flex-direction: column;
            }

            .description, .picture-container {
                flex: none;
                width: 100%;
                padding: 20px;
            }

            .profile-picture {
                max-width: 100%;
                width: auto;
            }
        }

        @media (max-width: 768px) {
            .apply-container {
                width: 95%;
            }

            .position-details h3 {
                font-size: 18px;
            }

            .position-details p {
                font-size: 14px;
            }

            .apply-button {
                padding: 10px;
                font-size: 14px;
            }

            .company-logo {
                width: 50px;
                height: 50px;
            }
        }

        @media (max-width: 480px) {
            .apply-container {
                width: 100%;
                padding: 10px;
            }

            .position {
                flex-direction: column;
                align-items: flex-start;
            }

            .company-logo {
                margin-bottom: 10px;
            }

            .apply-button {
                width: 100%;
                padding: 10px 0;
            }
            .custom-alert-box {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-left:3rem;
            max-width: 100px;
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

<?php include 'dashboard.php'; ?>

<div class="form-container">
<main>
        <h1 style="text-align:center;font-family:'Michroma', sans-serif;">
            Welcome to Job Seeker Dashboard</h1>
        <hr style="margin: 20px auto;border: 0;height: 1px;width: 50%;background: #EA60A7; ">
        <ul class="box-info">
            <li>
                <i class='bx bxs-group'></i>
                <?php
                include '../connection.php';
                $sql = "SELECT COUNT(job_provider_id) AS total FROM job_provider";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <span class="text">
                    <h3><?php echo $result['total']; ?></h3>
                    <p>All Job Provider</p>
                </span>
            </li>
            <li>
                <i class='bx bxs-group'></i>
                <?php
                include '../connection.php';
                $sql = "SELECT COUNT(job_seeker_id) AS total FROM job_seeker";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <span class="text">
                    <h3><?php echo $result['total']; ?></h3>
                    <p>All Seekers</p>
                </span>
            </li>
        </ul>
    </main>

<main>

<div class="table-data">
<h1 style="text-align:center;font-family:'Michroma', sans-serif;">Payment Status & Benefits of Kozi Caretakers</h1>
    
<hr style="margin: 20px auto;border: 0;height: 1px;width: 50%;background: #EA60A7; ">
    <div class="row">
    <div class="other-div3" style="text-align: center;">
    <img src="../img/team1.jpg" alt="" srcset="" style="width: 350px; display: inline-block;">
</div>

        <div class="other-div3"><br>
           
                <h2 style="text-align:center">How It works</h2><br>
                <hr style="margin: 0px auto;border: 0;height: 1px;width: 50%;background: #EA60A7; "><br>
            <strong> Step 1:</strong>Enter momo pay code *182*8*1*724002#
            <br><br>
            <strong> Step 2:</strong> Check if name is: Sam
                <br><br>
                <strong>Step 3:</strong>Enter your momo pin  <br><br>
                <strong>Step 4:</strong>Wait 5 min to be approved  <br><br>
                <strong>Step 5:</strong>For any assistance call: (+250)789 524 429 <br><br>
                <span style="font-size: 14px;">Track your progress and take the next step in your career journey with us!</span></p>
                
    
        </div>
    </div>
    <br><br>
    </div>
   

    
        </main>

    





    <main>
        <div class="body-container">
            <div class="description">
                <h2>Profile Information</h2>
                <p>Welcome to your profile page! Here, you can view and update your personal 
                information. If your profile is not complete, please check the bio section 
                below to add more details and help potential employers learn more about you.</p><br>
                <h3 style="font-family:'Michroma', sans-serif; size:12px">Update your bio:</h3>
                <p><br>
                    <?php
                    include '../connection.php';
                    $user_email = $_SESSION['user_email'];

                    try {
                        $sql = "SELECT job_seeker.bio 
                                FROM job_seeker
                                JOIN users ON job_seeker.users_id = users.users_id
                                WHERE users.email = :email";

                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':email', $user_email, PDO::PARAM_STR);
                        $stmt->execute();
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($result) {
                            $user_bio = htmlspecialchars($result['bio'], ENT_QUOTES, 'UTF-8');
                            echo "<b style='color:#ea60a7'>User Bio:</b> " . $user_bio;
                        } else {
                            echo "No bio found for this user.";
                        }
                    } catch (PDOException $e) {
                        die('Database error: ' . htmlspecialchars($e->getMessage()));
                    }
                    ?>
                </p>
                <a href="my_profile.php"><button class="update-button">Update My Info</button></a>
            </div>
            <div class="picture-container">
                <img src="sample.png" alt="Profile Picture" class="profile-picture">
            </div>
        </div>

        <div class="apply-container">
            <h2 style="font-family:'Michroma', sans-serif; text-align: center;">Open Positions</h2>
            <?php
            $stmt = $pdo->query("SELECT * FROM jobs");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="position">
                <?php
                $folderPath = '../dashboard';
                $logoFilename = $row['logo'];
                $uniqueLogoPath = $folderPath . $logoFilename . '?' . $row['job_id'];
                echo '<td><img class="company-logo" src="' . htmlspecialchars($uniqueLogoPath) . '" alt="Job Logo" style="width: 50px; height: 50px;"></td>';
                ?>
                <div class="position-details">
                    <h3><?php echo $row['job_title'] ?></h3>
                    <p>
                        <?php echo  $row['job_description']?> | Published on <?php echo  $row['published_date']?> | Deadline <?php echo  $row['deadline_date']?>
                    </p>
                    <form action="" method="post">
                        <input type="hidden" name="job_id" value="<?php echo $row['job_id']; ?>">
                        <input type="submit" name="apply" value="Apply" class="apply-button">
                    </form>
                </div>
            </div>
            <?php }?>
        </div>
    </main>
</div>

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
    $user_email = $_SESSION['user_email'];

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
                $job_seeker_id = $result['job_seeker_id'];
                $payment_status = $result['payment'];

                if ($payment_status == 1) {
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
                } else {
                    echo "<script>showCustomAlert('You must pay registration fees before applying to  this job.');</script>";
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
